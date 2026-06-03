<?php

namespace App\Controllers;

class Analitik extends BaseController
{
    /**
     * Tampilkan halaman Spatial Intelligence (Analitik K-Means).
     * Hanya dapat diakses oleh Administrator, Kepala Balai, dan Kasubbag.
     */
    public function index()
    {
        // Proteksi akses - validasi role pengguna
        if (! in_array(session()->get('role'), ['Administrator', 'Kepala Balai', 'Kasubbag'])) {
            return redirect()->to('/home')->with('error', 'Otoritas ditolak untuk Modul Spatial Intelligence.');
        }

        $db = \Config\Database::connect();

        $data = [
            'title' => 'Spatial Intelligence | SILABAK',

            // Data hasil klaster K-Means dengan informasi barang
            'klaster' => $db->table('tb_klaster_kmeans k')
                ->select('k.*, b.nama_barang, b.kode_barang, b.stok_aktual')
                ->join('tb_barang b', 'b.id_barang = k.id_barang')
                ->get()
                ->getResultArray(),

            // Rekap jumlah barang per klaster
            'rekap' => $db->table('tb_klaster_kmeans')
                ->select('label_klaster, COUNT(*) as total')
                ->groupBy('label_klaster')
                ->get()
                ->getResultArray(),

            // Data untuk visualisasi grafik spasial
            'chart_spasial' => $db->table('tb_klaster_kmeans k')
                ->select('k.velocity_score as x, b.stok_aktual as y, k.label_klaster, b.nama_barang')
                ->join('tb_barang b', 'b.id_barang = k.id_barang')
                ->get()
                ->getResultArray(),
        ];

        return view('analitik/index', $data);
    }

    /**
     * Jalankan algoritma K-Means dengan metrik RFM (Recency, Frequency, Monetary).
     * Proses ini meliputi:
     * 1. Ekstraksi data RFM dari riwayat transaksi
     * 2. Normalisasi MIN-MAX SCALING
     * 3. Iterasi K-Means untuk menemukan klaster optimal
     * 4. Simpan hasil ke database
     */
    public function kalkulasi_kmeans()
    {
        $db = \Config\Database::connect();
        $barang_all = $db->table('tb_barang')
            ->get()
            ->getResultArray();

        // Validasi apakah ada data master barang
        if (empty($barang_all)) {
            return redirect()->back()->with('error', 'Data master aset kosong. Kalkulasi dibatalkan.');
        }

        $dataset_rfm = [];
        $r_values = [];
        $f_values = [];
        $m_values = [];

        // =====================================================================
        // FASE 1: EKSTRAKSI DATA RFM (Data Mining)
        // =====================================================================
        // RFM = Recency (R), Frequency (F), Monetary (M)
        $now = time();

        foreach ($barang_all as $b) {
            $id = $b['id_barang'];
            $harga = $b['harga_beli'];

            // Ambil riwayat barang keluar dari database
            $histori = $db->table('tb_keluar')
                ->where('id_barang', $id)
                ->orderBy('tanggal_keluar', 'DESC')
                ->get()
                ->getResultArray();

            if (count($histori) > 0) {
                // R: Recency - Selisih hari dari transaksi terakhir
                $last_date = strtotime($histori[0]['tanggal_keluar']);
                $recency = round(($now - $last_date) / (60 * 60 * 24));

                // F: Frequency - Total jumlah transaksi barang keluar
                $frequency = count($histori);

                // M: Monetary - Total nilai (quantity * harga) yang keluar
                $monetary = 0;
                foreach ($histori as $h) {
                    $monetary += ($h['qty_keluar'] * $harga);
                }
            } else {
                // Pinalti untuk barang yang belum pernah keluar (stock dead)
                $recency = 365;      // Anggap 1 tahun menumpuk
                $frequency = 0;      // Tidak pernah keluar
                $monetary = 0;       // Tidak ada nilai keluar
            }

            $dataset_rfm[$id] = ['R' => $recency, 'F' => $frequency, 'M' => $monetary];
            $r_values[] = $recency;
            $f_values[] = $frequency;
            $m_values[] = $monetary;
        }

        // =====================================================================
        // FASE 2: NORMALISASI MIN-MAX SCALING
        // =====================================================================
        // Formula: X_norm = (X - X_min) / (X_max - X_min)
        // Hasil berkisar antara 0 hingga 1
        $r_min = min($r_values);
        $r_max = max($r_values) ?: 1;
        $f_min = min($f_values);
        $f_max = max($f_values) ?: 1;
        $m_min = min($m_values);
        $m_max = max($m_values) ?: 1;

        $dataset_normalized = [];
        
        // Mencegah pembagian dengan nol (Division by Zero) jika nilai min dan max identik.
        $r_diff = ($r_max - $r_min) ?: 1;
        $f_diff = ($f_max - $f_min) ?: 1;
        $m_diff = ($m_max - $m_min) ?: 1;

        foreach ($dataset_rfm as $id => $rfm) {
            // Untuk Recency: nilai kecil lebih baik, jadi kita inverse (1 - x)
            $r_norm = 1 - (($rfm['R'] - $r_min) / $r_diff);
            $f_norm = ($rfm['F'] - $f_min) / $f_diff;
            $m_norm = ($rfm['M'] - $m_min) / $m_diff;

            $dataset_normalized[$id] = ['R' => $r_norm, 'F' => $f_norm, 'M' => $m_norm];
        }

        // =====================================================================
        // FASE 3: INISIALISASI CENTROID AWAL (K = 3)
        // =====================================================================
        // Kita mendefinisikan 3 klaster: Fast Moving, Slow Moving, Dead Stock
        $centroids = [
            'Fast Moving' => ['R' => 1, 'F' => 1, 'M' => 1],       // Ideal item
            'Slow Moving' => ['R' => 0.5, 'F' => 0.5, 'M' => 0.5], // Medium item
            'Dead Stock'  => ['R' => 0, 'F' => 0, 'M' => 0],       // Worst item
        ];

        $clusters = [];
        $max_iterations = 100;

        // =====================================================================
        // FASE 4: ITERASI K-MEANS (Euclidean Distance Calculation)
        // =====================================================================
        // Setiap iterasi:
        // 1. Assign setiap data point ke centroid terdekat
        // 2. Update centroid baru berdasarkan mean semua member
        // 3. Ulangi sampai konvergen atau max iterasi
        for ($iter = 0; $iter < $max_iterations; $iter++) {
            $new_clusters = [
                'Fast Moving' => [],
                'Slow Moving' => [],
                'Dead Stock'  => [],
            ];

            // Assign setiap barang ke klaster terdekat
            foreach ($dataset_normalized as $id => $data) {
                $min_distance = PHP_FLOAT_MAX;
                $assigned_cluster = '';

                // Hitung jarak Euclidean: d = sqrt((R2-R1)^2 + (F2-F1)^2 + (M2-M1)^2)
                foreach ($centroids as $label => $centroid) {
                    $distance = sqrt(
                        pow($data['R'] - $centroid['R'], 2) +
                        pow($data['F'] - $centroid['F'], 2) +
                        pow($data['M'] - $centroid['M'], 2)
                    );

                    if ($distance < $min_distance) {
                        $min_distance = $distance;
                        $assigned_cluster = $label;
                    }
                }

                $new_clusters[$assigned_cluster][$id] = $data;
            }

            // Cek apakah ada perubahan - jika tidak, algoritma sudah konvergen
            if ($clusters === $new_clusters) {
                break;
            }

            $clusters = $new_clusters;

            // ========================================================
            // FASE 5: UPDATE CENTROID BARU (Mean/Rata-rata)
            // ========================================================
            foreach ($clusters as $label => $members) {
                if (count($members) > 0) {
                    $sum_r = 0;
                    $sum_f = 0;
                    $sum_m = 0;

                    foreach ($members as $data) {
                        $sum_r += $data['R'];
                        $sum_f += $data['F'];
                        $sum_m += $data['M'];
                    }

                    $centroids[$label] = [
                        'R' => $sum_r / count($members),
                        'F' => $sum_f / count($members),
                        'M' => $sum_m / count($members),
                    ];
                }
            }
        }

        // =====================================================================
        // FASE 6: SIMPAN HASIL KE DATABASE
        // =====================================================================
        $db->transStart();

        // Bersihkan hasil kalkulasi lama
        $db->table('tb_klaster_kmeans')->emptyTable();

        // Simpan setiap member ke dalam tabel klaster
        foreach ($clusters as $label => $members) {
            foreach ($members as $id => $data) {
                // Hitung velocity score (0-100) untuk keperluan grafik
                $velocity_score = round((($data['R'] + $data['F'] + $data['M']) / 3) * 100, 2);

                $db->table('tb_klaster_kmeans')->insert([
                    'id_barang'      => $id,
                    'label_klaster'  => $label,
                    'velocity_score' => $velocity_score,
                ]);
            }
        }

        // Catat aktivitas kalkulasi ke log audit
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Menjalankan ulang algoritma RFM & K-Means',
            'modul'   => 'Spatial Intelligence',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        $db->transComplete();

        return redirect()->to('/analitik')->with('success', 'Kalkulasi Ulang Kecerdasan Buatan Selesai! Data klaster telah diperbarui menggunakan parameter RFM.');
    }
}

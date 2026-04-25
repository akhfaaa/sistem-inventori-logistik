<?php

namespace App\Controllers;

class Analitik extends BaseController
{
    public function index()
    {
        // Proteksi Akses
        if (!in_array(session()->get('role'), ['Administrator', 'Kepala Balai', 'Kasubbag'])) {
            return redirect()->to('/home')->with('error', 'Otoritas ditolak untuk Modul Spatial Intelligence.');
        }

        $db = \Config\Database::connect();
        
        $data = [
            'title'   => 'Spatial Intelligence | SILABAK',
            'klaster' => $db->table('tb_klaster_kmeans k')
                            ->select('k.*, b.nama_barang, b.kode_barang, b.stok_aktual')
                            ->join('tb_barang b', 'b.id_barang = k.id_barang')
                            ->get()->getResultArray(),
            'rekap'   => $db->table('tb_klaster_kmeans')->select('label_klaster, COUNT(*) as total')->groupBy('label_klaster')->get()->getResultArray(),
            
            // Variabel ini yang sebelumnya terlewat dan menyebabkan error:
            'chart_spasial' => $db->table('tb_klaster_kmeans k')
                                  ->select('k.velocity_score as x, b.stok_aktual as y, k.label_klaster, b.nama_barang')
                                  ->join('tb_barang b', 'b.id_barang = k.id_barang')
                                  ->get()->getResultArray()
        ];

        return view('analitik/index', $data);
    }

    // --- ENGINE ALGORITMA K-MEANS + RFM ---
    public function kalkulasi_kmeans()
    {
        $db = \Config\Database::connect();
        $barang_all = $db->table('tb_barang')->get()->getResultArray();

        if(empty($barang_all)) {
            return redirect()->back()->with('error', 'Data master aset kosong. Kalkulasi dibatalkan.');
        }

        $dataset_rfm = [];
        $r_values = []; $f_values = []; $m_values = [];

        // 1. FASE EKSTRAKSI DATA RFM (Data Mining)
        $now = time();
        foreach ($barang_all as $b) {
            $id = $b['id_barang'];
            $harga = $b['harga_beli'];

            // Ambil riwayat barang keluar
            $histori = $db->table('tb_keluar')->where('id_barang', $id)->orderBy('tanggal_keluar', 'DESC')->get()->getResultArray();

            if (count($histori) > 0) {
                // R: Recency (Selisih hari dari transaksi terakhir)
                $last_date = strtotime($histori[0]['tanggal_keluar']);
                $recency = round(($now - $last_date) / (60 * 60 * 24)); 
                
                // F: Frequency (Total frekuensi transaksi)
                $frequency = count($histori);
                
                // M: Monetary (Total valuasi aset yang keluar)
                $monetary = 0;
                foreach ($histori as $h) {
                    $monetary += ($h['qty_keluar'] * $harga);
                }
            } else {
                // Pinalti untuk barang yang belum pernah keluar sama sekali
                $recency = 365; // Anggap sudah setahun mengendap
                $frequency = 0;
                $monetary = 0;
            }

            $dataset_rfm[$id] = ['R' => $recency, 'F' => $frequency, 'M' => $monetary];
            $r_values[] = $recency;
            $f_values[] = $frequency;
            $m_values[] = $monetary;
        }

        // 2. FASE NORMALISASI MIN-MAX SCALING (X_norm = (X - X_min) / (X_max - X_min))
        $r_min = min($r_values); $r_max = max($r_values) ?: 1;
        $f_min = min($f_values); $f_max = max($f_values) ?: 1;
        $m_min = min($m_values); $m_max = max($m_values) ?: 1;

        $dataset_normalized = [];
        foreach ($dataset_rfm as $id => $rfm) {
            // Catatan: Untuk Recency, nilai kecil lebih bagus. Kita inverse (1 - x) agar setara dengan F & M
            $r_norm = 1 - (($rfm['R'] - $r_min) / ($r_max - $r_min)); 
            $f_norm = ($rfm['F'] - $f_min) / ($f_max - $f_min);
            $m_norm = ($rfm['M'] - $m_min) / ($m_max - $m_min);
            
            $dataset_normalized[$id] = ['R' => $r_norm, 'F' => $f_norm, 'M' => $m_norm];
        }

        // 3. INISIALISASI CENTROID AWAL (K = 3)
        // Kita paksa titik awal agar iterasi lebih terarah
        $centroids = [
            'Fast Moving' => ['R' => 1, 'F' => 1, 'M' => 1],       // Titik Ideal
            'Slow Moving' => ['R' => 0.5, 'F' => 0.5, 'M' => 0.5], // Titik Tengah
            'Dead Stock'  => ['R' => 0, 'F' => 0, 'M' => 0]        // Titik Terburuk
        ];

        $clusters = [];
        $max_iterations = 100;

        // 4. ITERASI K-MEANS (Menghitung Jarak Euclidean)
        for ($iter = 0; $iter < $max_iterations; $iter++) {
            $new_clusters = ['Fast Moving' => [], 'Slow Moving' => [], 'Dead Stock' => []];

            foreach ($dataset_normalized as $id => $data) {
                $min_distance = PHP_FLOAT_MAX;
                $assigned_cluster = '';

                // Hitung d = sqrt((x2-x1)^2 + (y2-y1)^2 + (z2-z1)^2)
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

            // Jika posisi klaster tidak berubah, algoritma konvergen (selesai)
            if ($clusters === $new_clusters) break;
            $clusters = $new_clusters;

            // 5. UPDATE TITIK CENTROID BARU (Nilai Rata-rata / Mean)
            foreach ($clusters as $label => $members) {
                if (count($members) > 0) {
                    $sum_r = 0; $sum_f = 0; $sum_m = 0;
                    foreach ($members as $data) {
                        $sum_r += $data['R'];
                        $sum_f += $data['F'];
                        $sum_m += $data['M'];
                    }
                    $centroids[$label] = [
                        'R' => $sum_r / count($members),
                        'F' => $sum_f / count($members),
                        'M' => $sum_m / count($members)
                    ];
                }
            }
        }

        // 6. SIMPAN HASIL KE DATABASE
        $db->transStart();
        $db->table('tb_klaster_kmeans')->emptyTable(); // Bersihkan hasil lama

        foreach ($clusters as $label => $members) {
            foreach ($members as $id => $data) {
                // Hitung Score performa absolut (0 - 100) untuk keperluan grafik
                $velocity_score = round((($data['R'] + $data['F'] + $data['M']) / 3) * 100, 2);
                
                $db->table('tb_klaster_kmeans')->insert([
                    'id_barang'      => $id,
                    'label_klaster'  => $label,
                    'velocity_score' => $velocity_score
                ]);
            }
        }

        // Catat Audit Log
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Menjalankan ulang algoritma RFM & K-Means',
            'modul'   => 'Spatial Intelligence',
            'waktu'   => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        return redirect()->to('/analitik')->with('success', 'Kalkulasi Ulang Kecerdasan Buatan Selesai! Data klaster telah diperbarui menggunakan parameter RFM.');
    }
}
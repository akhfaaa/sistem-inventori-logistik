<?php

namespace App\Controllers;

class Home extends BaseController
{
    /**
     * Menampilkan dashboard sesuai peran pengguna.
     * Data yang dimuat berbeda untuk setiap role.
     */
    public function index()
    {
        $role = session()->get('role');
        $db = \Config\Database::connect();
        $data['title'] = 'Dashboard Operasional | SILABAK';

        // Log aktivitas terbaru yang ditampilkan di semua dashboard
        $data['recent_logs'] = $db->table('tb_log_aktivitas l')
            ->select('l.waktu, l.aksi as aktivitas, u.nama_lengkap')
            ->join('tb_users u', 'u.id_user = l.id_user', 'left')
            ->orderBy('l.waktu', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        switch ($role) {
            case 'Kepala Balai':
                // Rekap K-Means untuk tampilan Kepala Balai
                $data['rekap_kmeans'] = $db->table('tb_klaster_kmeans')
                    ->select('label_klaster, COUNT(*) as total')
                    ->groupBy('label_klaster')
                    ->get()
                    ->getResultArray();

                // Hitung nilai total barang berdasarkan harga beli dan stok aktual
                $valuasi = $db->table('tb_barang')
                    ->select('SUM(harga_beli * stok_aktual) as total')
                    ->get()
                    ->getRow();
                $data['total_nilai'] = $valuasi->total ?? 0;

                return view('dashboard/v_kepala_balai', $data);

            case 'Kasubbag':
                // Daftar barang dengan stok kritis
                $data['stok_kritis'] = $db->table('tb_barang')
                    ->where('stok_aktual <= stok_minimum')
                    ->get()
                    ->getResultArray();

                // Hitung outbound hari ini
                $data['outbound_today'] = $db->table('tb_keluar')
                    ->where('DATE(tanggal_keluar)', date('Y-m-d'))
                    ->countAllResults();

                return view('dashboard/v_kasubbag', $data);

            case 'Staff':
                // Ringkasan transaksi untuk staff
                $data['total_barang'] = $db->table('tb_barang')->countAllResults();
                $data['transaksi_masuk_hari_ini'] = $db->table('tb_masuk')
                    ->where('DATE(tanggal_masuk)', date('Y-m-d'))
                    ->countAllResults();
                $data['transaksi_keluar_hari_ini'] = $db->table('tb_keluar')
                    ->where('DATE(tanggal_keluar)', date('Y-m-d'))
                    ->countAllResults();

                // Barang dengan stok menipis untuk notifikasi cepat
                $data['stok_menipis'] = $db->table('tb_barang')
                    ->where('stok_aktual <= stok_minimum')
                    ->limit(5)
                    ->get()
                    ->getResultArray();

                return view('dashboard/v_staff', $data);

            case 'Administrator':
                // Statistik pengguna dan log aktivitas untuk admin
                $data['total_users'] = $db->table('tb_users')->countAllResults();
                $data['logs'] = $db->table('tb_log_aktivitas')
                    ->select('waktu, aksi as aktivitas, modul')
                    ->orderBy('waktu', 'DESC')
                    ->limit(10)
                    ->get()
                    ->getResultArray();

                return view('dashboard/v_admin', $data);

            default:
                // Role tidak dikenali, arahkan kembali ke auth
                return redirect()->to('/auth');
        }
    }

    /**
     * Menampilkan dashboard utama generik.
     * Data ini dapat digunakan untuk grafik dan ringkasan inventori.
     */
    public function main()
    {
        $db = \Config\Database::connect();

        // Ambil semua data barang
        $semuaBarang = $db->table('tb_barang')
            ->get()
            ->getResultArray();

        // Hitung berapa banyak barang yang stoknya rendah
        $lowStockCount = 0;
        foreach ($semuaBarang as $barang) {
            $limit = $barang['stok_minimum'] ?? $barang['batas_stok_kritis'] ?? 0;
            if ($barang['stok_aktual'] <= $limit) {
                $lowStockCount++;
            }
        }

        $data = [
            'title'        => 'Dashboard Utama | SILABAK PUPR',
            'total_barang' => count($semuaBarang),
            'low_stock'    => $lowStockCount,

            // Rekap K-Means untuk ditampilkan di dashboard utama
            'rekap_kmeans' => $db->table('tb_klaster_kmeans')
                ->select('label_klaster, COUNT(*) as total')
                ->groupBy('label_klaster')
                ->get()
                ->getResultArray(),

            // Data plot untuk grafik K-Means
            'plot_data' => json_encode($db->table('tb_klaster_kmeans k')
                ->select('k.velocity_score as x, b.stok_aktual as y, k.label_klaster, b.nama_barang')
                ->join('tb_barang b', 'b.id_barang = k.id_barang')
                ->get()
                ->getResultArray()),

            // Log aktivitas terbaru untuk tampilan ringkas
            'recent_logs' => $db->table('tb_log_aktivitas l')
                ->select('l.waktu, l.aksi as aktivitas, u.nama_lengkap, l.modul')
                ->join('tb_users u', 'u.id_user = l.id_user', 'left')
                ->orderBy('l.waktu', 'DESC')
                ->limit(5)
                ->get()
                ->getResultArray(),
        ];

        return view('dashboard_fix', $data);
    }
}

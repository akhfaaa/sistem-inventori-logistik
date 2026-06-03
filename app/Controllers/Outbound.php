<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Outbound extends BaseController
{
    /**
     * Tampilkan halaman outbound logistik.
     * Menampilkan daftar barang, customer, dan riwayat transaksi keluar.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $data = [
            'title'    => 'Transaksi Outbound | Barang Keluar',

            // Data barang untuk dropdown form
            'barang'   => $db->table('tb_barang')
                ->get()
                ->getResultArray(),

            // Data customer untuk dropdown form
            'customer' => $db->table('tb_customer')
                ->get()
                ->getResultArray(),

            // Riwayat transaksi keluar dengan informasi barang dan customer
            'riwayat'  => $db->table('tb_keluar k')
                ->select('k.*, b.nama_barang, c.nama_customer')
                ->join('tb_barang b', 'b.id_barang = k.id_barang')
                ->join('tb_customer c', 'c.id_customer = k.id_customer')
                ->orderBy('k.tanggal_keluar', 'DESC')
                ->get()
                ->getResultArray(),
        ];

        return view('outbound/index', $data);
    }

    /**
     * Simpan transaksi pengiriman barang (outbound).
     * Melakukan validasi stok, update stok, dan mencatat log aktivitas dalam satu transaksi database.
     */
    public function store()
    {
        $db = \Config\Database::connect();

        // Ambil data dari form submission
        $id_barang = $this->request->getPost('id_barang');
        $id_customer = $this->request->getPost('id_customer');
        $qty_keluar = $this->request->getPost('qty_keluar');

        // Validasi input - cegah manipulasi melalui inspect element atau user error
        if (empty($id_barang) || empty($id_customer) || $qty_keluar < 1) {
            return redirect()->back()->with('error', 'Validasi Gagal: Formulir tidak lengkap atau kuantitas tidak valid!');
        }

        // Ambil data barang untuk pemeriksaan stok
        $barang = $db->table('tb_barang')
            ->where('id_barang', $id_barang)
            ->get()
            ->getRowArray();

        // Periksa apakah barang ditemukan
        if (! $barang) {
            return redirect()->back()->with('error', 'Validasi Gagal: Aset tidak ditemukan di sistem.');
        }

        // Periksa ketersediaan stok - cegah stok menjadi negatif
        if ($qty_keluar > $barang['stok_aktual']) {
            return redirect()->back()->with('error', 'Distribusi Ditolak! Stok aktual (' . $barang['stok_aktual'] . ' unit) tidak mencukupi permintaan sebanyak ' . $qty_keluar . ' unit.');
        }

        // Mulai transaksi database untuk menjamin konsistensi data (ACID Compliance)
        $db->transStart();

        // Catat transaksi barang keluar
        $db->table('tb_keluar')->insert([
            'id_barang'      => $id_barang,
            'id_customer'    => $id_customer,
            'qty_keluar'     => $qty_keluar,
            'tanggal_keluar' => date('Y-m-d H:i:s'),
            'id_user'        => session()->get('id_user'),
        ]);

        // Kurangi stok aktual barang
        $db->table('tb_barang')
            ->where('id_barang', $id_barang)
            ->set('stok_aktual', 'stok_aktual - ' . $qty_keluar, false)
            ->update();

        // Catat aktivitas pengguna ke tabel log audit
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Distribusi keluar: ' . $barang['nama_barang'] . ' (' . $qty_keluar . ' unit)',
            'modul'   => 'Outbound Logistik',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        // Selesaikan transaksi database
        $db->transComplete();

        // Periksa status transaksi - jika gagal, semua perubahan akan di-rollback
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem (Database Error). Transaksi dibatalkan otomatis.');
        }

        return redirect()->to('/outbound')->with('success', 'Distribusi barang berhasil diverifikasi dan stok telah dikurangi.');
    }
}

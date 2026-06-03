<?php

namespace App\Controllers;

use App\Models\SpkModel;
use App\Models\BarangModel;

class Inbound extends BaseController
{
    /**
     * Tampilkan halaman inbound logistik.
     * Menampilkan daftar barang, supplier, riwayat masuk, dan rekomendasi supplier.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil data barang dan supplier untuk dropdown form
        $data['barang'] = $db->table('tb_barang')
            ->get()
            ->getResultArray();

        $data['supplier'] = $db->table('tb_supplier')
            ->get()
            ->getResultArray();

        // Ambil riwayat transaksi masuk dengan informasi lengkap
        // Join dengan tabel barang dan supplier untuk mendapatkan nama
        $data['riwayat'] = $db->table('tb_masuk m')
            ->select('m.*, b.nama_barang, s.nama_supplier')
            ->join('tb_barang b', 'b.id_barang = m.id_barang')
            ->join('tb_supplier s', 's.id_supplier = m.id_supplier')
            ->orderBy('m.tanggal_masuk', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        // Hitung rekomendasi supplier terbaik menggunakan metode SAW
        $spkModel = new SpkModel();
        $rekomendasi = $spkModel->hitungSAW();

        // Ambil peringkat pertama (skor tertinggi) sebagai rekomendasi utama
        $data['best_supplier'] = ! empty($rekomendasi) ? $rekomendasi[0] : null;

        $data['title'] = 'Stock Inbound | Logistics Hub';

        return view('Inbound/index', $data);
    }

    /**
     * Simpan transaksi penerimaan barang (inbound).
     * Melakukan validasi, update stok, dan mencatat log aktivitas dalam satu transaksi database.
     */
    public function store()
    {
        $db = \Config\Database::connect();

        // Ambil data dari form submission
        $id_barang = $this->request->getPost('id_barang');
        $id_supplier = $this->request->getPost('id_supplier');
        $qty_masuk = $this->request->getPost('qty_masuk');

        // Validasi data input
        if (empty($id_barang) || empty($id_supplier) || $qty_masuk < 1) {
            return redirect()->back()->with('error', 'Validasi Gagal: Formulir tidak lengkap atau kuantitas masuk tidak logis!');
        }

        // Ambil data barang untuk keperluan logging
        $barang = $db->table('tb_barang')
            ->where('id_barang', $id_barang)
            ->get()
            ->getRowArray();

        // Mulai transaksi database untuk menjamin konsistensi data
        $db->transStart();

        // Catat histori penerimaan barang
        $db->table('tb_masuk')->insert([
            'id_barang'     => $id_barang,
            'id_supplier'   => $id_supplier,
            'qty_masuk'     => $qty_masuk,
            'tanggal_masuk' => date('Y-m-d H:i:s'),
            'id_user'       => session()->get('id_user'),
        ]);

        // Tambahkan kuantitas ke stok aktual barang
        $db->table('tb_barang')
            ->where('id_barang', $id_barang)
            ->set('stok_aktual', 'stok_aktual + ' . $qty_masuk, false)
            ->update();

        // Catat aktivitas pengguna ke tabel log audit
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Penerimaan logistik: ' . ($barang['nama_barang'] ?? 'Aset ID ' . $id_barang) . ' (' . $qty_masuk . ' unit)',
            'modul'   => 'Inbound Logistik',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        // Selesaikan transaksi database
        $db->transComplete();

        // Periksa status transaksi
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem (Database Error). Registrasi stok dibatalkan otomatis.');
        }

        return redirect()->to('/inbound')->with('success', 'Penerimaan barang berhasil diregistrasi dan stok telah ditambahkan ke gudang.');
    }
}


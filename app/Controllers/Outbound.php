<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Outbound extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $data = [
            'title'    => 'Transaksi Outbound | Barang Keluar',
            'barang'   => $db->table('tb_barang')->get()->getResultArray(),
            'customer' => $db->table('tb_customer')->get()->getResultArray(),
            'riwayat'  => $db->table('tb_keluar k')
                ->select('k.*, b.nama_barang, c.nama_customer')
                ->join('tb_barang b', 'b.id_barang = k.id_barang')
                ->join('tb_customer c', 'c.id_customer = k.id_customer')
                ->orderBy('k.tanggal_keluar', 'DESC')->get()->getResultArray()
        ];
        return view('outbound/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();

        $id_barang   = $this->request->getPost('id_barang');
        $id_customer = $this->request->getPost('id_customer');
        $qty_keluar  = $this->request->getPost('qty_keluar');

        // 1. Validasi Sisi Server (Cegah input manipulasi HTML melalui Inspect Element)
        if (empty($id_barang) || empty($id_customer) || $qty_keluar < 1) {
            return redirect()->back()->with('error', 'Validasi Gagal: Formulir tidak lengkap atau kuantitas tidak valid!');
        }

        // 2. Cek Ketersediaan Stok (Mencegah Stok Minus / Over-Deduct)
        $barang = $db->table('tb_barang')->where('id_barang', $id_barang)->get()->getRowArray();

        if (!$barang) {
            return redirect()->back()->with('error', 'Validasi Gagal: Aset tidak ditemukan di sistem.');
        }

        if ($qty_keluar > $barang['stok_aktual']) {
            return redirect()->back()->with('error', 'Distribusi Ditolak! Stok aktual (' . $barang['stok_aktual'] . ' unit) tidak mencukupi permintaan sebanyak ' . $qty_keluar . ' unit.');
        }

        // 3. Mulai Transaksi Database (ACID Compliance)
        $db->transStart();

        // A. Catat barang keluar
        $db->table('tb_keluar')->insert([
            'id_barang'      => $id_barang,
            'id_customer'    => $id_customer,
            'qty_keluar'     => $qty_keluar,
            'tanggal_keluar' => date('Y-m-d H:i:s'),
            'id_user'        => session()->get('id_user')
        ]);

        // B. Kurangi stok aktual di tabel barang
        $db->table('tb_barang')
            ->where('id_barang', $id_barang)
            ->set('stok_aktual', 'stok_aktual - ' . $qty_keluar, false)
            ->update();

        // C. Catat Log Audit Sistem
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Distribusi keluar: ' . $barang['nama_barang'] . ' (' . $qty_keluar . ' unit)',
            'modul'   => 'Outbound Logistik',
            'waktu'   => date('Y-m-d H:i:s')
        ]);

        // Selesaikan Transaksi
        $db->transComplete();

        // Cek apakah ada query yang gagal di tengah jalan (otomatis di-Rollback)
        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem (Database Error). Transaksi dibatalkan otomatis.');
        }

        return redirect()->to('/outbound')->with('success', 'Distribusi barang berhasil diverifikasi dan stok telah dikurangi.');
    }
}

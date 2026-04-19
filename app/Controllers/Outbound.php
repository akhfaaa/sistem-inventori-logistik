<?php

namespace App\Controllers;
use App\Models\BarangModel;

class Outbound extends BaseController {
    public function index() {
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

    public function store() {
    $db = \Config\Database::connect();
    $id_barang = $this->request->getPost('id_barang');
    $qty = $this->request->getPost('qty_keluar');

    // Simpan transaksi
    $db->table('tb_keluar')->insert([
        'id_barang'   => $id_barang,
        'id_customer' => $this->request->getPost('id_customer'),
        'id_user'     => 1,
        'qty_keluar'  => $qty
    ]);

    // Update stok
    $db->table('tb_barang')->where('id_barang', $id_barang)->set('stok_aktual', "stok_aktual - $qty", false)->update();

    // Tulis Log Aktivitas
    $this->tulis_log("Mengeluarkan barang ID: $id_barang sebanyak $qty", "Outbound");

    return redirect()->to('/outbound')->with('success', 'Transaksi keluar berhasil!');
}
}
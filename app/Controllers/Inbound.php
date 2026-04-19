<?php

namespace App\Controllers;
use App\Models\BarangModel;

class Inbound extends BaseController {
    public function index() {
        $db = \Config\Database::connect();
        $data = [
            'title'    => 'Transaksi Inbound | Barang Masuk',
            'barang'   => $db->table('tb_barang')->get()->getResultArray(),
            'supplier' => $db->table('tb_supplier')->get()->getResultArray(),
            'riwayat'  => $db->table('tb_masuk m')
                            ->select('m.*, b.nama_barang, s.nama_supplier')
                            ->join('tb_barang b', 'b.id_barang = m.id_barang')
                            ->join('tb_supplier s', 's.id_supplier = m.id_supplier')
                            ->orderBy('m.tanggal_masuk', 'DESC')->get()->getResultArray()
        ];
        return view('inbound/index', $data);
    }

    public function store() {
    $db = \Config\Database::connect();
    $id_barang = $this->request->getPost('id_barang');
    $qty = $this->request->getPost('qty_masuk');

    $db->table('tb_masuk')->insert([
        'id_barang'   => $id_barang,
        'id_supplier' => $this->request->getPost('id_supplier'),
        'id_user'     => 1,
        'qty_masuk'   => $qty
    ]);

    // Update stok
    $db->table('tb_barang')->where('id_barang', $id_barang)->set('stok_aktual', "stok_aktual + $qty", false)->update();

    // Tulis Log Aktivitas
    $this->tulis_log("Menambah stok barang ID: $id_barang sebanyak $qty", "Inbound");

    return redirect()->to('/inbound')->with('success', 'Stok berhasil ditambah!');
}
}
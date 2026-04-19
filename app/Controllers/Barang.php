<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Barang extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Inilah inti dari Langkah 3: Melakukan JOIN agar data lengkap
        $data = [
            'title'    => 'Master Inventory | SKU Management',

            // Kita berikan alias 'b' untuk tb_barang agar query lebih pendek
            'barang'   => $db->table('tb_barang b')
                ->select('b.*, k.nama_kategori, r.nama_rak, r.lokasi')
                ->join('tb_kategori k', 'k.id_kategori = b.id_kategori', 'left')
                ->join('tb_rak r', 'r.id_rak = b.id_rak', 'left') // Inilah kolom yang tadi error
                ->get()->getResultArray(),

            // Data ini dikirim agar Dropdown di Modal Tambah Barang bisa muncul
            'kategori' => $db->table('tb_kategori')->get()->getResultArray(),
            'rak'      => $db->table('tb_rak')->get()->getResultArray()
        ];

        return view('barang/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();

        $dataInsert = [
            'kode_barang'        => $this->request->getPost('kode_barang'),
            'nama_barang'        => $this->request->getPost('nama_barang'),
            'id_kategori'        => $this->request->getPost('id_kategori'),
            'id_rak'             => $this->request->getPost('id_rak'), // Pastikan baris ini ada
            'stok_aktual'        => $this->request->getPost('stok_aktual'),
            'batas_stok_kritis'  => $this->request->getPost('batas_stok_kritis'),
            'harga_beli'         => $this->request->getPost('harga_beli'),
        ];

        $db->table('tb_barang')->insert($dataInsert);

        return redirect()->to('/barang')->with('success', 'SKU baru berhasil terdaftar dan ditempatkan di rak.');
    }
}

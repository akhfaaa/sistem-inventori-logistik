<?php

namespace App\Controllers;

class Barang extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data = [
            'title'    => 'Master Inventory | SKU Management',
            'barang'   => $db->table('tb_barang b')
                ->select('b.*, k.nama_kategori, r.nama_rak, r.lokasi')
                ->join('tb_kategori k', 'k.id_kategori = b.id_kategori', 'left')
                ->join('tb_rak r', 'r.id_rak = b.id_rak', 'left')
                ->get()->getResultArray(),
            'kategori' => $db->table('tb_kategori')->get()->getResultArray(),
            'rak'      => $db->table('tb_rak')->get()->getResultArray()
        ];

        return view('barang/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $id_rak = $this->request->getPost('id_rak');

        $dataInsert = [
            'kode_barang'   => $this->request->getPost('kode_barang'),
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'id_kategori'   => $this->request->getPost('id_kategori'),
            'id_rak'        => empty($id_rak) ? null : $id_rak,
            'stok_aktual'   => $this->request->getPost('stok_aktual'),
            'stok_minimum'  => $this->request->getPost('stok_minimum'), // <-- Sudah diperbaiki
            'harga_beli'    => $this->request->getPost('harga_beli'),
        ];

        $db->table('tb_barang')->insert($dataInsert);
        return redirect()->to('/barang')->with('success', 'Aset baru berhasil diregistrasi.');
    }

    public function update($id_barang)
    {
        $db = \Config\Database::connect();
        $id_rak = $this->request->getPost('id_rak');

        $dataUpdate = [
            'kode_barang'   => $this->request->getPost('kode_barang'),
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'id_kategori'   => $this->request->getPost('id_kategori'),
            'id_rak'        => empty($id_rak) ? null : $id_rak,
            'stok_aktual'   => $this->request->getPost('stok_aktual'),
            'stok_minimum'  => $this->request->getPost('stok_minimum'), // <-- Sudah diperbaiki
            'harga_beli'    => $this->request->getPost('harga_beli'),
        ];

        $db->table('tb_barang')->where('id_barang', $id_barang)->update($dataUpdate);
        return redirect()->to('/barang')->with('success', 'Data aset berhasil diperbarui.');
    }

    public function delete($id_barang)
    {
        $db = \Config\Database::connect();
        $db->table('tb_barang')->where('id_barang', $id_barang)->delete();
        return redirect()->to('/barang')->with('success', 'Data aset berhasil dihapus dari sistem.');
    }
}
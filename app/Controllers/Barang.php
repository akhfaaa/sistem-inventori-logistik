<?php

namespace App\Controllers;
use App\Models\BarangModel;

class Barang extends BaseController
{
    public function index()
{
    $barangModel = new BarangModel();
    
    // Mengambil data barang dengan JOIN ke kategori agar tampilan lebih informatif
    $db = \Config\Database::connect();
    $builder = $db->table('tb_barang b');
    $builder->select('b.*, k.nama_kategori');
    $builder->join('tb_kategori k', 'k.id_kategori = b.id_kategori');
    $semua_barang = $builder->get()->getResultArray();

    // Mengambil list kategori untuk dropdown di Modal
    $kategori = $db->table('tb_kategori')->get()->getResultArray();

    $data = [
        'title'    => 'Master Barang | Logistik',
        'barang'   => $semua_barang,
        'kategori' => $kategori
    ];
    
    return view('barang/index', $data);
}

    public function store()
    {
        // Memanggil Model Barang yang sudah kita buat sebelumnya
        $barangModel = new BarangModel();

        // Menangkap data dari Form HTML dan menyimpannya secara atomik
        $barangModel->insert([
            'kode_barang'       => $this->request->getPost('kode_barang'),
            'nama_barang'       => $this->request->getPost('nama_barang'),
            'id_kategori'       => $this->request->getPost('id_kategori'),
            'harga_beli'        => $this->request->getPost('harga_beli'),
            'stok_aktual'       => $this->request->getPost('stok_aktual'),
            'batas_stok_kritis' => $this->request->getPost('batas_stok_kritis')
        ]);

        // Mengembalikan user ke halaman tabel setelah sukses menyimpan
        return redirect()->to('/barang');
    }
}
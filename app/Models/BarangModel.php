<?php

namespace App\Models;
use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'tb_barang';
    protected $primaryKey       = 'id_barang';
    protected $allowedFields = ['kode_barang', 'nama_barang', 'id_kategori', 'id_rak', 'harga_beli', 'stok_aktual', 'stok_minimum'];

    // Fungsi khusus untuk White Box Coding Anda
    public function kurangiStok($id_barang, $qty_keluar)
    {
        // Query builder untuk mengurangi stok secara atomik
        $this->builder()
             ->where('id_barang', $id_barang)
             ->set('stok_aktual', "stok_aktual - $qty_keluar", false)
             ->update();
    }
}
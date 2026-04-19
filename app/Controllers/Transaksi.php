<?php

namespace App\Controllers;
use App\Models\BarangModel;
// Nanti kita akan tambahkan TransaksiModel di sini

class Transaksi extends BaseController
{
    public function proses_barang_keluar()
    {
        // Memanggil Model
        $barangModel = new BarangModel();

        // Mengambil inputan dari View (Form HTML)
        $id_barang = $this->request->getPost('id_barang');
        $qty_keluar = $this->request->getPost('qty');

        // Mengambil data barang saat ini
        $barang = $barangModel->find($id_barang);

        // Pengecekan logika ketersediaan stok (White Box)
        if ($barang['stok_aktual'] >= $qty_keluar) {
            
            // Eksekusi mutasi (Mengurangi stok)
            $barangModel->kurangiStok($id_barang, $qty_keluar);

            // Cek apakah sisa stok menyentuh batas kritis
            $sisa_stok = $barang['stok_aktual'] - $qty_keluar;
            if ($sisa_stok <= $barang['batas_stok_kritis']) {
                // Di sini nanti kita buatkan trigger Notifikasi/Alert
                log_message('warning', "Stok Kritis untuk Barang ID: " . $id_barang);
            }

            return "Transaksi Berhasil. Stok telah diperbarui.";

        } else {
            // Fallback galat jika stok kurang
            return "Error: Kuantitas melebihi persediaan gudang aktual!";
        }
    }
}
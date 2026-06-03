<?php

namespace App\Controllers;

use App\Models\BarangModel;

class Transaksi extends BaseController
{
    /**
     * Proses transaksi pengurangan stok barang keluar.
     * Memvalidasi ketersediaan stok dan mengurangi stok aktual.
     * Juga memeriksa apakah stok mencapai batas kritis untuk notifikasi.
     *
     * @return string Status transaksi (sukses atau error)
     */
    public function proses_barang_keluar()
    {
        // Inisialisasi model barang
        $barangModel = new BarangModel();

        // Ambil data input dari form HTML
        $id_barang = $this->request->getPost('id_barang');
        $qty_keluar = $this->request->getPost('qty');

        // Ambil data barang saat ini dari database
        $barang = $barangModel->find($id_barang);

        // Validasi ketersediaan stok (White Box Testing)
        if ($barang['stok_aktual'] >= $qty_keluar) {

            // Eksekusi pengurangan stok
            $barangModel->kurangiStok($id_barang, $qty_keluar);

            // Hitung sisa stok setelah transaksi
            $sisa_stok = $barang['stok_aktual'] - $qty_keluar;

            // Periksa apakah sisa stok mencapai batas kritis untuk trigger alert
            if ($sisa_stok <= $barang['batas_stok_kritis']) {
                log_message('warning', 'Stok Kritis untuk Barang ID: ' . $id_barang);
            }

            return 'Transaksi Berhasil. Stok telah diperbarui.';

        } else {
            // Kembalikan error jika stok tidak mencukupi
            return 'Error: Kuantitas melebihi persediaan gudang aktual!';
        }
    }
}

<?php

namespace App\Controllers;

class Retur extends BaseController
{
    // Tampilan Utama Tabel Retur (Tampilan 15)
    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title'   => 'Reverse Logistics | Retur Barang',
            // Ambil data barang untuk dropdown form
            'barang'  => $db->table('tb_barang')->get()->getResultArray(),
            // Ambil riwayat retur dengan Join untuk mendapatkan nama barang
            'riwayat' => $db->table('tb_retur r')
                            ->select('r.*, b.nama_barang, b.kode_barang')
                            ->join('tb_barang b', 'b.id_barang = r.id_barang')
                            ->orderBy('r.tanggal_retur', 'DESC')
                            ->get()->getResultArray()
        ];

        return view('retur/index', $data);
    }

    // Eksekusi Simpan & Perbaikan Stok (Tampilan 16)
    public function store()
    {
        $db = \Config\Database::connect();
        
        $id_barang = $this->request->getPost('id_barang');
        $qty       = $this->request->getPost('qty_retur');
        $aksi      = $this->request->getPost('aksi_stok'); // 'Kembali ke Stok' atau 'Musnahkan'
        $alasan    = $this->request->getPost('alasan');

        // 1. Simpan data ke tabel tb_retur
        $db->table('tb_retur')->insert([
            'id_barang'     => $id_barang,
            'qty_retur'     => $qty,
            'alasan'        => $alasan,
            'aksi_stok'     => $aksi,
            'tanggal_retur' => date('Y-m-d H:i:s')
        ]);

        // 2. Logika Perbaikan Stok
        if ($aksi == 'Kembali ke Stok') {
            // Jika layak kembali ke stok, maka stok aktual bertambah
            $db->table('tb_barang')
               ->where('id_barang', $id_barang)
               ->set('stok_aktual', "stok_aktual + $qty", false)
               ->update();
            
            $msg = "Barang diretur dan dikembalikan ke stok.";
        } else {
            $msg = "Barang diretur untuk dimusnahkan (stok tidak berubah).";
        }

        // 3. Catat ke Audit Log (Laporan No 11)
        $barang = $db->table('tb_barang')->where('id_barang', $id_barang)->get()->getRowArray();
        $this->tulis_log("Input Retur: {$barang['nama_barang']} ({$qty} unit) - {$aksi}", "Retur");

        return redirect()->to('/retur')->with('success', $msg);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_retur')->where('id_retur', $id)->delete();
        return redirect()->to('/retur')->with('success', 'Data riwayat retur berhasil dihapus.');
    }
}
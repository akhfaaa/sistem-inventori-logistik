<?php

namespace App\Controllers;

class Retur extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title'   => 'Manajemen Retur | SILABAK PUPR',
            // Ambil daftar barang untuk dropdown form
            'barang'  => $db->table('tb_barang')->get()->getResultArray(),
            // Ambil riwayat retur dengan JOIN ke tabel barang
            'riwayat' => $db->table('tb_retur r')
                            ->select('r.*, b.nama_barang, b.kode_barang')
                            ->join('tb_barang b', 'b.id_barang = r.id_barang')
                            ->orderBy('r.tanggal_retur', 'DESC')
                            ->get()->getResultArray()
        ];

        return view('retur/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        
        $id_barang = $this->request->getPost('id_barang');
        $qty_retur = $this->request->getPost('qty_retur');
        $aksi_stok = $this->request->getPost('aksi_stok');
        $alasan    = $this->request->getPost('alasan');

        // 1. Simpan data ke tabel Retur
        $db->table('tb_retur')->insert([
            'id_barang'     => $id_barang,
            'qty_retur'     => $qty_retur,
            'alasan'        => $alasan,
            'aksi_stok'     => $aksi_stok,
            'tanggal_retur' => date('Y-m-d H:i:s')
        ]);

        // 2. Logika Aksi Stok (Sesuai dengan ENUM di database)
        if ($aksi_stok === 'Kembali ke Stok') {
            // Jika barang masih layak, kembalikan ke stok aktual
            $db->table('tb_barang')
               ->where('id_barang', $id_barang)
               ->set('stok_aktual', "stok_aktual + $qty_retur", false)
               ->update();
        }

        // 3. Catat ke Log Aktivitas (Opsional jika Anda menggunakan fungsi tulis_log)
        if (method_exists($this, 'tulis_log')) {
            $barang = $db->table('tb_barang')->where('id_barang', $id_barang)->get()->getRowArray();
            $nama = $barang ? $barang['nama_barang'] : 'ID '.$id_barang;
            $this->tulis_log("Input Retur: $nama ($qty_retur unit) - $aksi_stok", "Retur");
        }

        return redirect()->to('/retur')->with('success', 'Laporan retur barang berhasil diproses dan dicatat.');
    }
}
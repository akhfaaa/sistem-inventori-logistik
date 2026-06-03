<?php

namespace App\Controllers;

class Retur extends BaseController
{
    /**
     * Tampilkan halaman manajemen retur barang.
     * Menampilkan daftar barang dan riwayat transaksi retur.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $data = [
            'title' => 'Manajemen Retur | SILABAK PUPR',

            // Data barang untuk dropdown form input retur
            'barang' => $db->table('tb_barang')
                ->get()
                ->getResultArray(),

            // Riwayat transaksi retur dengan informasi detail barang
            'riwayat' => $db->table('tb_retur r')
                ->select('r.*, b.nama_barang, b.kode_barang')
                ->join('tb_barang b', 'b.id_barang = r.id_barang')
                ->orderBy('r.tanggal_retur', 'DESC')
                ->get()
                ->getResultArray(),
        ];

        return view('retur/index', $data);
    }

    /**
     * Simpan data retur barang.
     * Mencatat retur dan melakukan aksi stok sesuai dengan pilihan pengguna.
     */
    public function store()
    {
        $db = \Config\Database::connect();

        // Ambil data dari form submission
        $id_barang = $this->request->getPost('id_barang');
        $qty_retur = $this->request->getPost('qty_retur');
        $aksi_stok = $this->request->getPost('aksi_stok');
        $alasan = $this->request->getPost('alasan');

        // Simpan data retur ke database
        $db->table('tb_retur')->insert([
            'id_barang'     => $id_barang,
            'qty_retur'     => $qty_retur,
            'alasan'        => $alasan,
            'aksi_stok'     => $aksi_stok,
            'tanggal_retur' => date('Y-m-d H:i:s'),
        ]);

        // Proses aksi stok berdasarkan pilihan pengguna
        // Jika barang layak, kembalikan ke stok aktual
        if ($aksi_stok === 'Kembali ke Stok') {
            $db->table('tb_barang')
                ->where('id_barang', $id_barang)
                ->set('stok_aktual', "stok_aktual + $qty_retur", false)
                ->update();
        }

        // Catat aktivitas ke log (jika method tersedia)
        if (method_exists($this, 'tulis_log')) {
            $barang = $db->table('tb_barang')
                ->where('id_barang', $id_barang)
                ->get()
                ->getRowArray();

            $nama = $barang ? $barang['nama_barang'] : 'ID ' . $id_barang;
            $this->tulis_log("Input Retur: $nama ($qty_retur unit) - $aksi_stok", 'Retur');
        }

        return redirect()->to('/retur')->with('success', 'Laporan retur barang berhasil diproses dan dicatat.');
    }
}

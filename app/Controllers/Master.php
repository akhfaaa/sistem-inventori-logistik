<?php

namespace App\Controllers;

class Master extends BaseController
{
    /**
     * Tampilkan halaman master data.
     * Memuat daftar kategori dan rak yang tersedia.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $data = [
            'title'    => 'Master Data Management | Logistics Hub',
            'kategori' => $db->table('tb_kategori')
                ->get()
                ->getResultArray(),
            'rak'      => $db->table('tb_rak')
                ->get()
                ->getResultArray(),
        ];

        return view('master/index', $data);
    }

    // --------------------------------------------------------------------
    // LOGIKA KATEGORI
    // --------------------------------------------------------------------

    /**
     * Simpan kategori baru ke database.
     */
    public function storeKategori()
    {
        $db = \Config\Database::connect();
        $db->table('tb_kategori')->insert([
            'nama_kategori' => $this->request->getPost('nama_kategori'),
        ]);

        return redirect()->to('/master')->with('success', 'Kategori baru ditambahkan.');
    }

    /**
     * Hapus kategori berdasarkan ID.
     *
     * @param int $id
     */
    public function deleteKategori($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_kategori')
            ->where('id_kategori', $id)
            ->delete();

        return redirect()->to('/master');
    }

    // --------------------------------------------------------------------
    // LOGIKA RAK
    // --------------------------------------------------------------------

    /**
     * Simpan rak baru ke database.
     */
    public function storeRak()
    {
        $db = \Config\Database::connect();
        $db->table('tb_rak')->insert([
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi'),
        ]);

        return redirect()->to('/master')->with('success', 'Lokasi rak baru ditambahkan.');
    }

    /**
     * Hapus rak berdasarkan ID.
     *
     * @param int $id
     */
    public function deleteRak($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_rak')
            ->where('id_rak', $id)
            ->delete();

        return redirect()->to('/master');
    }
}

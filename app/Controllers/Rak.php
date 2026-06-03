<?php

namespace App\Controllers;

class Rak extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'title' => 'Manajemen Lokasi Rak',
            'rak'   => $db->table('tb_rak')->orderBy('id_rak', 'DESC')->get()->getResultArray()
        ];
        
        return view('rak/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $id = $this->request->getPost('id_rak'); // Jika ada ID, berarti Update
        
        $data = [
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi')
        ];

        if (!empty($id)) {
            // Proses Update (Edit)
            $db->table('tb_rak')->where('id_rak', $id)->update($data);
            $pesan = 'Data lokasi rak berhasil diperbarui!';
        } else {
            // Proses Create (Tambah Baru)
            $db->table('tb_rak')->insert($data);
            $pesan = 'Data lokasi rak baru berhasil ditambahkan!';
        }

        return redirect()->to('/rak')->with('success', $pesan);
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        $db->table('tb_rak')->where('id_rak', $id)->delete();
        
        return redirect()->to('/rak')->with('success', 'Data lokasi rak berhasil dihapus!');
    }
}
<?php
namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        // Proteksi: Hanya Admin yang boleh masuk
        if (session()->get('role') !== 'Administrator') {
            return redirect()->to('/dashboard')->with('error', 'Akses Ditolak! Menu ini khusus Administrator.');
        }

        $db = \Config\Database::connect();
        $data = [
            'title' => 'User Management | Hak Akses',
            'users' => $db->table('tb_users')->orderBy('created_at', 'DESC')->get()->getResultArray()
        ];

        return view('users/index', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        
        $dataInsert = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            // Menggunakan MD5 menyesuaikan dengan data admin Anda saat ini
            'password'     => md5($this->request->getPost('password')),
            'role'         => $this->request->getPost('role')
        ];

        $db->table('tb_users')->insert($dataInsert);
        
        // Catat ke Log Aktivitas
        $this->tulis_log("Mendaftarkan akun baru: " . $this->request->getPost('username') . " (" . $this->request->getPost('role') . ")", "User Admin");
        
        return redirect()->to('/users')->with('success', 'Akun pengguna baru berhasil dibuat.');
    }

    public function delete($id)
    {
        // Cegah Admin tidak sengaja menghapus dirinya sendiri
        if ($id == session()->get('id_user')) {
            return redirect()->to('/users')->with('error', 'Peringatan: Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $db = \Config\Database::connect();
        $db->table('tb_users')->where('id_user', $id)->delete();
        
        return redirect()->to('/users')->with('success', 'Akun pengguna berhasil dicabut dan dihapus.');
    }
}
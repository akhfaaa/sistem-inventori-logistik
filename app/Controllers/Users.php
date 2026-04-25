<?php
namespace App\Controllers;

class Users extends BaseController
{
    public function index()
    {
        if (session()->get('role') !== 'Administrator') {
            return redirect()->to('/dashboard')->with('error', 'Akses Ditolak! Kredensial Anda tidak memiliki otorisasi penuh untuk menu ini.');
        }

        $db = \Config\Database::connect();
        $data = [
            'title' => 'User Management | Hak Akses SILABAK',
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
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role')
        ];

        $db->table('tb_users')->insert($dataInsert);
        
        // Pencatatan Log Aktivitas
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Registrasi personel baru: ' . $this->request->getPost('username'),
            'modul'   => 'User Admin',
            'waktu'   => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/users')->with('success', 'Kredensial personel baru berhasil diterbitkan.');
    }

    // --- FUNGSI BARU UNTUK UPDATE DATA (EDIT) ---
    public function update($id_user)
    {
        $db = \Config\Database::connect();
        
        $dataUpdate = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role')
        ];

        // Jika form password diisi, maka perbarui password (Bcrypt). Jika kosong, abaikan.
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $dataUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $db->table('tb_users')->where('id_user', $id_user)->update($dataUpdate);
        
        // Pencatatan Log Aktivitas
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Memperbarui data kredensial: ' . $this->request->getPost('username'),
            'modul'   => 'User Admin',
            'waktu'   => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/users')->with('success', 'Data kredensial personel berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($id == session()->get('id_user')) {
            return redirect()->to('/users')->with('error', 'Peringatan Keamanan: Anda tidak diizinkan mencabut hak akses dari akun Anda sendiri.');
        }

        $db = \Config\Database::connect();
        
        // Ambil nama user untuk log
        $user = $db->table('tb_users')->where('id_user', $id)->get()->getRowArray();
        
        $db->table('tb_users')->where('id_user', $id)->delete();
        
        // Pencatatan Log Aktivitas
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Mencabut akses dan menghapus: ' . ($user['username'] ?? 'User ID '.$id),
            'modul'   => 'User Admin',
            'waktu'   => date('Y-m-d H:i:s')
        ]);
        
        return redirect()->to('/users')->with('success', 'Otoritas akses berhasil dicabut dan data dihapus.');
    }
}
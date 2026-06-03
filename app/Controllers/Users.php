<?php
namespace App\Controllers;

class Users extends BaseController
{
    /**
     * Tampilkan daftar pengguna.
     * Hanya Administrator yang dapat mengakses menu ini.
     */
    public function index()
    {
        if (session()->get('role') !== 'Administrator') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak! Kredensial Anda tidak memiliki otorisasi penuh untuk menu ini.');
        }

        $db = \Config\Database::connect();
        $data = [
            'title' => 'User Management | Hak Akses SILABAK',
            'users' => $db->table('tb_users')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray(),
        ];

        return view('users/index', $data);
    }

    /**
     * Simpan user baru ke database.
     */
    public function store()
    {
        $db = \Config\Database::connect();

        $dataInsert = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'         => $this->request->getPost('role'),
        ];

        $db->table('tb_users')->insert($dataInsert);

        // Pencatatan aktivitas admin
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Registrasi personel baru: ' . $this->request->getPost('username'),
            'modul'   => 'User Admin',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'Kredensial personel baru berhasil diterbitkan.');
    }

    /**
     * Perbarui data user yang ada.
     * Jika password diisi, maka password akan di-hash ulang.
     *
     * @param int $id_user
     */
    public function update($id_user)
    {
        $db = \Config\Database::connect();

        $dataUpdate = [
            'nama_lengkap' => $this->request->getPost('nama_lengkap'),
            'username'     => $this->request->getPost('username'),
            'role'         => $this->request->getPost('role'),
        ];

        $password = $this->request->getPost('password');
        if (! empty($password)) {
            $dataUpdate['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $db->table('tb_users')
            ->where('id_user', $id_user)
            ->update($dataUpdate);

        // Pencatatan aktivitas admin
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Memperbarui data kredensial: ' . $this->request->getPost('username'),
            'modul'   => 'User Admin',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'Data kredensial personel berhasil diperbarui.');
    }

    /**
     * Hapus user dari sistem.
     * Tidak mengizinkan pengguna untuk menghapus akun dirinya sendiri.
     *
     * @param int $id
     */
    public function delete($id)
    {
        if ($id === session()->get('id_user')) {
            return redirect()->to('/users')->with('error', 'Peringatan keamanan: Anda tidak diizinkan mencabut hak akses dari akun Anda sendiri.');
        }

        $db = \Config\Database::connect();

        // Ambil data user sebelum penghapusan untuk keperluan log
        $user = $db->table('tb_users')
            ->where('id_user', $id)
            ->get()
            ->getRowArray();

        $db->table('tb_users')
            ->where('id_user', $id)
            ->delete();

        // Pencatatan aktivitas admin
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => session()->get('id_user'),
            'aksi'    => 'Mencabut akses dan menghapus: ' . ($user['username'] ?? 'User ID ' . $id),
            'modul'   => 'User Admin',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/users')->with('success', 'Otoritas akses berhasil dicabut dan data dihapus.');
    }
}
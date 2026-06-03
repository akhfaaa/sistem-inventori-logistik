<?php

namespace App\Controllers;

class Auth extends BaseController
{
    /**
     * Tampilkan halaman login.
     * Jika pengguna sudah masuk, arahkan ke halaman home.
     */
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/home');
        }

        $data['title'] = 'Portal Otentikasi | SILABAK PUPR';
        return view('auth/login', $data);
    }

    /**
     * Proses autentikasi pengguna.
     * Mencari user berdasarkan username, kemudian memeriksa kata sandi.
     * Menangani migrasi sandi lama MD5 ke Bcrypt secara otomatis.
     */
    public function process()
    {
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $passwordInput = $this->request->getPost('password');

        // Cari pengguna berdasarkan username
        $user = $db->table('tb_users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (! $user) {
            return redirect()->back()->with('error', 'Username tidak terdaftar!');
        }

        $isPasswordValid = false;

        // Periksa kata sandi baru (Bcrypt)
        if (password_verify($passwordInput, $user['password'])) {
            $isPasswordValid = true;
        }
        // Periksa kata sandi lama (MD5)
        elseif ($user['password'] === md5($passwordInput)) {
            $isPasswordValid = true;

            // Migrasi otomatis ke Bcrypt untuk keamanan lebih baik
            $newHash = password_hash($passwordInput, PASSWORD_DEFAULT);
            $db->table('tb_users')
                ->where('id_user', $user['id_user'])
                ->update(['password' => $newHash]);
        }

        if (! $isPasswordValid) {
            return redirect()->back()->with('error', 'Kata sandi salah!');
        }

        // Simpan data pengguna ke session setelah login sukses
        session()->set([
            'id_user'      => $user['id_user'],
            'nama_lengkap' => $user['nama_lengkap'],
            'role'         => $user['role'],
            'isLoggedIn'   => true,
        ]);

        // Catat aktivitas login ke tabel log
        $db->table('tb_log_aktivitas')->insert([
            'id_user' => $user['id_user'],
            'aksi'    => 'User login ke dalam sistem',
            'modul'   => 'Autentikasi',
            'waktu'   => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/home');
    }

    /**
     * Logout pengguna.
     * Menghapus sesi dan mencatat aktivitas logout.
     */
    public function logout()
    {
        $session = session();

        if ($session->get('id_user')) {
            $db = \Config\Database::connect();
            $db->table('tb_log_aktivitas')->insert([
                'id_user' => $session->get('id_user'),
                'aksi'    => 'User logout dari sistem',
                'modul'   => 'Autentikasi',
                'waktu'   => date('Y-m-d H:i:s'),
            ]);
        }

        $session->destroy();

        return redirect()->to('/auth')->with('success', 'Anda berhasil keluar dengan aman.');
    }
}

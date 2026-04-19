<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke Dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/home/main');
        }
        
        $data['title'] = "Login | Logistics Hub Enterprise";
        return view('auth/login', $data);
    }

    public function process()
    {
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $password = md5($this->request->getPost('password')); // Sesuaikan dengan enkripsi Anda

        $user = $db->table('tb_users')->where(['username' => $username, 'password' => $password])->get()->getRowArray();

        if ($user) {
            // Set session data
            session()->set([
                'id_user'      => $user['id_user'],
                'nama_lengkap' => $user['nama_lengkap'],
                'role'         => $user['role'],
                'isLoggedIn'   => true
            ]);

            // Catat ke Audit Log bahwa user ini login
            $this->tulis_log("User login ke dalam sistem", "Autentikasi");

            return redirect()->to('/home/main');
        } else {
            return redirect()->back()->with('error', 'Username atau Password salah!');
        }
    }

    public function logout()
    {
        $session = session();
        
        // (Opsional) Catat aktivitas logout ke tabel log sebelum sesi dihancurkan
        if ($session->get('id_user')) {
            $db = \Config\Database::connect();
            $db->table('tb_log_aktivitas')->insert([
                'id_user' => $session->get('id_user'),
                'aksi'    => 'User logout dari sistem',
                'modul'   => 'Autentikasi',
                'waktu'   => date('Y-m-d H:i:s')
            ]);
        }

        // Hancurkan semua data sesi (login)
        $session->destroy();

        // Arahkan kembali ke halaman login dengan pesan sukses
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}
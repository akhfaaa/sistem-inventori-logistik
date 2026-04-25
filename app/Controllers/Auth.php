<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/home');
        }
        
        $data['title'] = "Portal Otentikasi | SILABAK PUPR";
        return view('auth/login', $data);
    }

    public function process()
    {
        $db = \Config\Database::connect();
        $username = $this->request->getPost('username');
        $password_input = $this->request->getPost('password');

        // 1. Cari pengguna berdasarkan username
        $user = $db->table('tb_users')->where('username', $username)->get()->getRowArray();

        if ($user) {
            $isPasswordValid = false;

            // 2A. Cek apakah ini kata sandi format BARU (Bcrypt)
            if (password_verify($password_input, $user['password'])) {
                $isPasswordValid = true;
            } 
            // 2B. Cek apakah ini kata sandi format LAMA (MD5)
            elseif ($user['password'] === md5($password_input)) {
                $isPasswordValid = true;
                
                // MIGRASI OTOMATIS: Perbarui sandi lama di database menjadi format Bcrypt yang aman
                $new_hash = password_hash($password_input, PASSWORD_DEFAULT);
                $db->table('tb_users')->where('id_user', $user['id_user'])->update(['password' => $new_hash]);
            }

            // 3. Jika kata sandi cocok (baik format lama maupun baru), izinkan masuk
            if ($isPasswordValid) {
                session()->set([
                    'id_user'      => $user['id_user'],
                    'nama_lengkap' => $user['nama_lengkap'],
                    'role'         => $user['role'],
                    'isLoggedIn'   => true
                ]);

                // Catat log aktivitas
                $db->table('tb_log_aktivitas')->insert([
                    'id_user' => $user['id_user'],
                    'aksi'    => 'User login ke dalam sistem',
                    'modul'   => 'Autentikasi',
                    'waktu'   => date('Y-m-d H:i:s')
                ]);

                return redirect()->to('/home');
            } else {
                return redirect()->back()->with('error', 'Kata Sandi salah!');
            }
        } else {
            return redirect()->back()->with('error', 'Username tidak terdaftar!');
        }
    }

    public function logout()
    {
        $session = session();
        if ($session->get('id_user')) {
            $db = \Config\Database::connect();
            $db->table('tb_log_aktivitas')->insert([
                'id_user' => $session->get('id_user'),
                'aksi'    => 'User logout dari sistem',
                'modul'   => 'Autentikasi',
                'waktu'   => date('Y-m-d H:i:s')
            ]);
        }
        $session->destroy();
        return redirect()->to('/auth')->with('success', 'Anda berhasil keluar dengan aman.');
    }
}
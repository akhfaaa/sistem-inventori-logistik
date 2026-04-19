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
        $this->tulis_log("User logout dari sistem", "Autentikasi");
        session()->destroy();
        return redirect()->to('/auth');
    }
}
<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Pengecekan krusial: Jika tidak ada session 'isLoggedIn', blokir akses!
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth')->with('error', 'Akses Ditolak! Anda harus melakukan otorisasi terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi setelah request untuk saat ini
    }
}
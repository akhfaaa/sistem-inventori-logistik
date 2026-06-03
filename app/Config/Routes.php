<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| Konfigurasi Rute untuk Sistem Inventori
|--------------------------------------------------------------------------
|
| File ini mendefinisikan semua rute untuk sistem manajemen inventori.
| Rute diorganisir menjadi rute publik (tidak memerlukan otentikasi)
| dan rute terproteksi (memerlukan otentikasi melalui filter 'auth').
|
*/

// ========================================================================
// 1. RUTE PUBLIK (Tidak Memerlukan Otentikasi)
// ========================================================================

/**
 * Rute Otentikasi
 * Menangani login, logout, dan proses otentikasi
 */
$routes->get('/', 'Auth::index');              // Rute root - mengarahkan ke login
$routes->get('/auth', 'Auth::index');          // Halaman indeks auth
$routes->get('/login', 'Auth::index');         // Halaman login
$routes->post('/auth/process', 'Auth::process'); // Memproses form login

// PENTING: Rute logout ditempatkan di luar filter auth untuk menghindari konflik sesi
$routes->get('/auth/logout', 'Auth::logout');  // Logout dan menghancurkan sesi

// ========================================================================
// 2. RUTE TERPROTEKSI (Memerlukan Otentikasi)
// ========================================================================

/**
 * Semua rute dalam grup ini memerlukan otentikasi pengguna
 * Diterapkan melalui filter 'auth'
 */
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // --------------------------------------------------------------------
    // Modul Evaluasi Supplier
    // --------------------------------------------------------------------
    /**
     * Rute untuk evaluasi performa supplier
     */
    $routes->get('/supplierevaluasi', 'SupplierEvaluasi::index');           // Melihat evaluasi supplier
    $routes->post('/supplierevaluasi/store', 'SupplierEvaluasi::store');    // Menyimpan evaluasi baru
    $routes->post('/supplierevaluasi/update', 'SupplierEvaluasi::update');  // Memperbarui evaluasi yang ada
    $routes->get('/supplierevaluasi/delete/(:num)', 'SupplierEvaluasi::delete/$1'); // Menghapus evaluasi berdasarkan ID

    // --------------------------------------------------------------------
    // Modul Dashboard & Home
    // --------------------------------------------------------------------
    /**
     * Rute untuk dashboard utama dan fungsi home
     */
    $routes->get('/home', 'Home::index');           // Dashboard utama
    $routes->get('/home/main', 'Home::main');       // Tampilan utama home
    $routes->get('/home/exportPDF', 'Home::exportPDF'); // Mengekspor dashboard ke PDF

    // --------------------------------------------------------------------
    // Modul Data Master
    // --------------------------------------------------------------------

    /**
     * Rute Manajemen Produk/Barang
     */
    $routes->get('/barang', 'Barang::index');                    // Daftar semua produk
    $routes->post('/barang/store', 'Barang::store');             // Menambah produk baru
    $routes->post('/barang/update/(:num)', 'Barang::update/$1'); // Memperbarui produk berdasarkan ID
    $routes->get('/barang/delete/(:num)', 'Barang::delete/$1');  // Menghapus produk berdasarkan ID

    /**
     * Rute Manajemen Retur/Pengembalian
     */
    $routes->get('/retur', 'Retur::index');     // Melihat pengembalian
    $routes->post('/retur/store', 'Retur::store'); // Memproses pengembalian

    /**
     * Manajemen Data Master (Kategori dan Rak)
     */
    $routes->get('/master', 'Master::index');                          // Dashboard data master
    $routes->post('/master/storeKategori', 'Master::storeKategori');   // Menambah kategori baru
    $routes->get('/master/deleteKategori/(:num)', 'Master::deleteKategori/$1'); // Menghapus kategori berdasarkan ID
    $routes->post('/master/storeRak', 'Master::storeRak');             // Menambah rak baru
    $routes->get('/master/deleteRak/(:num)', 'Master::deleteRak/$1');  // Menghapus rak berdasarkan ID

    /**
     * Rute Manajemen Rak
     */
    $routes->get('rak', 'Rak::index');                    // Daftar rak
    $routes->post('rak/store', 'Rak::store');             // Menambah rak baru
    $routes->get('rak/delete/(:num)', 'Rak::delete/$1');  // Menghapus rak berdasarkan ID

    // --------------------------------------------------------------------
    // Modul Logistik
    // --------------------------------------------------------------------

    /**
     * Logistik Inbound (Penerimaan Barang)
     */
    $routes->get('/inbound', 'Inbound::index');     // Dashboard inbound
    $routes->post('/inbound/store', 'Inbound::store'); // Mencatat transaksi inbound

    /**
     * Logistik Outbound (Pengiriman Barang)
     */
    $routes->get('/outbound', 'Outbound::index');     // Dashboard outbound
    $routes->post('/outbound/store', 'Outbound::store'); // Mencatat transaksi outbound

    // --------------------------------------------------------------------
    // Modul Laporan & Analitik
    // --------------------------------------------------------------------

    /**
     * Rute Pelaporan Umum
     */
    $routes->get('/laporan', 'Laporan::index');                          // Dashboard laporan
    $routes->get('/laporan/generate/(:segment)', 'Laporan::generate/$1'); // Menghasilkan laporan spesifik
    $routes->get('/laporan/eksekutif', 'Laporan::eksekutif');            // Laporan eksekutif
    $routes->get('/laporan/generate/(:any)', 'Laporan::generate/$1');    // Pembuatan laporan universal

    /**
     * Modul Analitik dengan K-Means Clustering
     */
    $routes->get('/analitik', 'Analitik::index');                   // Dashboard analitik (dengan slash awal)
    $routes->post('/analitik/kalkulasi', 'Analitik::kalkulasi_kmeans'); // Perhitungan K-Means

    // --------------------------------------------------------------------
    // Modul Manajemen Pengguna
    // --------------------------------------------------------------------

    /**
     * Rute Manajemen Akses Pengguna
     */
    $routes->get('/users', 'Users::index');                    // Daftar pengguna
    $routes->post('/users/store', 'Users::store');             // Menambah pengguna baru
    $routes->post('/users/update/(:num)', 'Users::update/$1'); // Memperbarui pengguna berdasarkan ID
    $routes->get('/users/delete/(:num)', 'Users::delete/$1');  // Menghapus pengguna berdasarkan ID

});

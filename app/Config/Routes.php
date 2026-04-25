<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Rute Publik (Tidak butuh login)
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');

$routes->get('/login', 'Auth::index');

$routes->post('/auth/process', 'Auth::process');
// PENTING: Rute Logout kita letakkan di luar filter agar tidak bentrok dengan sesi
$routes->get('/auth/logout', 'Auth::logout');

// 2. Rute Enterprise (Wajib Login)
// Kita bungkus menggunakan group dan filter
$routes->group('', ['filter' => 'auth'], function ($routes) {

    $routes->get('/supplierevaluasi', 'SupplierEvaluasi::index');
    $routes->post('/supplierevaluasi/store', 'SupplierEvaluasi::store');
    $routes->post('/supplierevaluasi/update', 'SupplierEvaluasi::update');
    $routes->get('/supplierevaluasi/delete/(:num)', 'SupplierEvaluasi::delete/$1');

    // Dashboard & PDF
    // --- Rute Dashboard & Home ---
    $routes->get('/home', 'Home::index');
    $routes->get('/home/main', 'Home::main');
    $routes->get('/home/exportPDF', 'Home::exportPDF');

    // --- Rute Master Barang ---
    $routes->get('/barang', 'Barang::index');
    $routes->post('/barang/store', 'Barang::store');
    $routes->post('/barang/update/(:num)', 'Barang::update/$1');
    $routes->get('/barang/delete/(:num)', 'Barang::delete/$1');

    $routes->get('/retur', 'Retur::index');
    $routes->post('/retur/store', 'Retur::store');

    $routes->get('/master', 'Master::index');
    $routes->post('/master/storeKategori', 'Master::storeKategori');
    $routes->get('/master/deleteKategori/(:num)', 'Master::deleteKategori/$1');
    $routes->post('/master/storeRak', 'Master::storeRak');
    $routes->get('/master/deleteRak/(:num)', 'Master::deleteRak/$1');

    // Logistik Inbound
    $routes->get('/inbound', 'Inbound::index');
    $routes->post('/inbound/store', 'Inbound::store');

    // Logistik Outbound
    $routes->get('/outbound', 'Outbound::index');
    $routes->post('/outbound/store', 'Outbound::store');

    // Laporan & Analytics
    $routes->get('/laporan', 'Laporan::index');
    $routes->get('/laporan/generate/(:segment)', 'Laporan::generate/$1');
    // --- Rute Laporan Eksekutif ---
    $routes->get('/laporan/eksekutif', 'Laporan::eksekutif');
    // --- Rute Cetak Universal ---
    $routes->get('/laporan/generate/(:any)', 'Laporan::generate/$1');
    // --- Rute untuk Modul Analitik K-Means ---
    $routes->get('analitik', 'Analitik::index');
    $routes->post('analitik/proses', 'Analitik::proses');
    // --- Modul Spatial Intelligence (AI) ---
    $routes->get('/analitik', 'Analitik::index');
    $routes->post('/analitik/kalkulasi', 'Analitik::kalkulasi_kmeans');

    // --- Rute Manajemen Akses (Users) ---
    $routes->get('/users', 'Users::index');
    $routes->post('/users/store', 'Users::store');
    $routes->post('/users/update/(:num)', 'Users::update/$1'); // <-- Tambahkan baris ini
    $routes->get('/users/delete/(:num)', 'Users::delete/$1');
});

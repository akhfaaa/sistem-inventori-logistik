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
    $routes->get('/home/main', 'Home::main');
    $routes->get('/home/exportPDF', 'Home::exportPDF');

    // Master Barang
    $routes->get('/barang', 'Barang::index');
    $routes->post('/barang/store', 'Barang::store');
    $routes->post('/barang/update', 'Barang::update');
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
    // --- Rute untuk Modul Analitik K-Means ---
    $routes->get('analitik', 'Analitik::index');
    $routes->post('analitik/proses', 'Analitik::proses');

    $routes->get('/users', 'Users::index');
    $routes->post('/users/store', 'Users::store');
    $routes->get('/users/delete/(:num)', 'Users::delete/$1');
});

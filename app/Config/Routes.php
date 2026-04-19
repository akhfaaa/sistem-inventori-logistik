<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 1. Rute Publik (Tidak butuh login)
$routes->get('/', 'Auth::index'); // Default route sekarang mengarah ke Login
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/process', 'Auth::process');

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

    // Logistik Inbound
    $routes->get('/inbound', 'Inbound::index');
    $routes->post('/inbound/store', 'Inbound::store');

    // Logistik Outbound
    $routes->get('/outbound', 'Outbound::index');
    $routes->post('/outbound/store', 'Outbound::store');

    // Laporan & Analytics
    $routes->get('/laporan', 'Laporan::index');
    $routes->get('/laporan/generate/(:segment)', 'Laporan::generate/$1');

    // Logout
    $routes->get('/auth/logout', 'Auth::logout');
});

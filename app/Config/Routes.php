<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::main');
$routes->get('/barang', 'Barang::index'); // Tambahkan baris ini
$routes->post('/barang/store', 'Barang::store');
$routes->get('/inbound', 'Inbound::index');
$routes->post('/inbound/store', 'Inbound::store');
$routes->get('/outbound', 'Outbound::index');
$routes->post('/outbound/store', 'Outbound::store');
$routes->get('/analitik', 'Analitik::index');
$routes->post('/analitik/proses', 'Analitik::proses');
$routes->get('home/exportPDF', 'Home::exportPDF');
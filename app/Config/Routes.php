<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('dashboard', 'Aplikasi\DashboardController::index');
$routes->get('unggahdokumen', 'Aplikasi\DokumenUpload::index');
$routes->get('datadokumen', 'Aplikasi\DokumenUpload::datadokumen');
$routes->post('unggahdokumen/import', 'Aplikasi\DokumenUpload::import');

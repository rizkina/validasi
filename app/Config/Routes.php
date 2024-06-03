<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('dashboard', 'Aplikasi\DashboardController::index');
$routes->get('unggahdokumen', 'Aplikasi\DokumenUpload::index');
$routes->get('datadokumen', 'Aplikasi\DokumenUpload::getDataDokumen');
$routes->post('unggahdokumen/import', 'Aplikasi\DokumenUpload::import');
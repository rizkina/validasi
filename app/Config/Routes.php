<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('dashboard', 'Aplikasi\DashboardController::index');
$routes->get('unggahdokumen', 'Aplikasi\DokumenUpload::index');

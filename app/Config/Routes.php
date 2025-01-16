<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public Routes (Akses untuk semua pengunjung)
$routes->get('/', 'Home::index');
$routes->get('buat-laporan', 'Laporan::buatLaporan');
$routes->post('buat-laporan', 'Home::buatLaporan');
$routes->get('peta', 'Home::peta');
$routes->get('history', 'Home::history');
$routes->get('about', 'Home::about');

// Admin Auth Routes
$routes->get('/admin/login', 'Auth::login');
$routes->post('/admin/login', 'Auth::attemptLogin');
$routes->get('/admin/register', 'Auth::register');
$routes->post('/admin/register', 'Auth::attemptRegister');
$routes->get('/admin/dashboard', 'Admin::dashboard', ['filter' => 'auth']);
$routes->get('/admin/logout', 'Auth::logout');

// Admin Routes (Perlu login sebagai admin)
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Admin::dashboard');
    $routes->get('laporan', 'Admin::laporan');
    $routes->post('laporan/updateStatus', 'Admin::updateStatus');
    $routes->get('peta', 'Admin::peta');
    $routes->get('statistik', 'Admin::statistik');
});

// API Routes untuk Maps
$routes->group('api', function($routes) {
    $routes->get('markers', 'Api::getMarkers');
    $routes->get('latest-reports', 'Api::getLatestReports');
});

// Error Pages
$routes->set404Override(function() {
    return view('errors/404');
});

$routes->get('/admin/aduan', 'Aduan::index');
$routes->post('/admin/aduan/updateStatus', 'Aduan::updateStatus');

$routes->post('laporan/simpan', 'Laporan::simpan');

$routes->get('laporan/detail/(:num)', 'Laporan::detail/$1');

$routes->post('admin/updateStatus', 'Admin::updateStatus');

$routes->get('admin/statistik', 'Admin::statistik');
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ===================================================================
// ROUTES UTAMA
// ===================================================================

// Redirect halaman utama ke daftar menu
$routes->get('/', 'MenuController::index');

// ===================================================================
// ROUTES MENU BURJO (CRUD)
// ===================================================================

// Tampilkan semua menu (dengan filter kategori via GET params)
$routes->get('menu', 'MenuController::index');

// Form tambah menu baru
$routes->get('menu/create', 'MenuController::create');

// Proses simpan menu baru (POST)
$routes->post('menu/store', 'MenuController::store');

// Form edit menu berdasarkan ID
$routes->get('menu/edit/(:num)', 'MenuController::edit/$1');

// Proses update menu berdasarkan ID (POST)
$routes->post('menu/update/(:num)', 'MenuController::update/$1');

// Proses hapus menu berdasarkan ID (POST)
$routes->post('menu/delete/(:num)', 'MenuController::delete/$1');

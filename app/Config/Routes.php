<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ===================================================================
// ROUTES UTAMA
// ===================================================================
// Halaman utama → halaman order pelanggan
$routes->get('/', 'CartController::order');
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

// ===================================================================
// ROUTES SAMPAH MENU (TRASH / SOFT DELETE)
// ===================================================================

// Halaman sampah menu yang sudah di-soft delete
$routes->get('menu/trash', 'MenuController::trash');

// Pulihkan menu dari sampah (POST)
$routes->post('menu/restore/(:num)', 'MenuController::restore/$1');

// Hapus menu secara permanen dari sampah (POST)
$routes->post('menu/force-delete/(:num)', 'MenuController::forceDelete/$1');

// ===================================================================
// ROUTES PELANGGAN (CRUD + SOFT DELETE)
// ===================================================================

// Tampilkan semua pelanggan aktif
$routes->get('pelanggan', 'PelangganController::index');

// Form tambah pelanggan baru
$routes->get('pelanggan/create', 'PelangganController::create');

// Proses simpan pelanggan baru (POST)
$routes->post('pelanggan/store', 'PelangganController::store');

// Form edit pelanggan
$routes->get('pelanggan/edit/(:num)', 'PelangganController::edit/$1');

// Proses update pelanggan (POST)
$routes->post('pelanggan/update/(:num)', 'PelangganController::update/$1');

// Soft delete pelanggan (GET)
$routes->get('pelanggan/delete/(:num)', 'PelangganController::delete/$1');

// Halaman sampah pelanggan
$routes->get('pelanggan/trash', 'PelangganController::trash');

// Pulihkan pelanggan dari sampah (GET)
$routes->get('pelanggan/restore/(:num)', 'PelangganController::restore/$1');

// Hapus pelanggan secara permanen (GET)
$routes->get('pelanggan/force-delete/(:num)', 'PelangganController::forceDelete/$1');

// ==============================================================
// ROUTES AUTH (LOGIN & LOGOUT)
// ==============================================================

// Halaman form login (GET)
$routes->get('login', 'AuthController::login');

// Proses login (POST)
$routes->post('login', 'AuthController::attemptLogin');

// Logout (GET)
$routes->get('logout', 'AuthController::logout');

// ==============================================================
// ROUTES PELANGGAN – tanpa autentikasi
// ==============================================================

// Halaman menu untuk pelanggan
$routes->get('order', 'CartController::order');

// Download daftar menu sebagai PDF
$routes->get('order/pdf', 'CartController::downloadMenuPdf');

// Tambahkan item ke keranjang (POST)
$routes->post('cart/insert', 'CartController::insert');

// Tampilkan isi keranjang
$routes->get('cart', 'CartController::cart');

// Update qty item di keranjang (POST)
$routes->post('cart/update', 'CartController::update');

// Hapus satu item dari keranjang (POST)
$routes->post('cart/remove', 'CartController::remove');

// Kosongkan seluruh keranjang (POST)
$routes->post('cart/destroy', 'CartController::destroy');

// Halaman checkout
$routes->get('checkout', 'CartController::checkout');

// Proses checkout (POST)
$routes->post('checkout/process', 'CartController::processCheckout');

// Halaman struk setelah checkout
$routes->get('struk', 'CartController::struk');

// Download struk sebagai PDF
$routes->get('struk/pdf', 'CartController::downloadStrukPdf');

// ==============================================================
// ROUTES SETTINGS – hanya untuk admin (dilindungi filter auth)
// ==============================================================

// Halaman pengaturan
$routes->get('settings', 'SettingsController::index');

// Proses simpan pengaturan (POST)
$routes->post('settings/update', 'SettingsController::update');
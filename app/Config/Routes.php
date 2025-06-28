<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// url awal
$routes->get('/', 'EventController::index');
// menangani search bar pada url awal
$routes->post('/', 'EventController::filter');

// CRUD event
// search event
$routes->get('event/search', 'EventController::filter');
// filter event
$routes->get('event/filter/(:any)/(:any)', 'EventController::filter/$1/$2');
// search ketika filter event
$routes->post('event/filter/(:any)/(:any)', 'EventController::filter/$1/$2');
// search dan filter
$routes->post('event/search', 'EventController::filter');
$routes->post('event/filter', 'EventController::filter');

// create event
$routes->get('/event/create', 'EventController::create', ['filter' => 'authGuard']);
$routes->post('/event/save', 'EventController::save', ['filter' => 'authGuard']);
// update event
$routes->get('/event/edit/(:segment)', 'EventController::edit/$1', ['filter' => 'authGuard']);
$routes->post('/event/update/(:segment)', 'EventController::update/$1', ['filter' => 'authGuard']);
// delete event
$routes->delete('/event/(:num)', 'EventController::delete/$1', ['filter' => 'authGuard']);

// CRUD Booth
// halaman booth
$routes->get('/booth', 'BoothController::index');
// create booth
$routes->get('/booth/create', 'BoothController::createBooth', ['filter' => 'authGuard']);
$routes->post('/booth/save', 'BoothController::saveBooth', ['filter' => 'authGuard']);
// update booth
$routes->get('/booth/edit/(:segment)', 'BoothController::editBooth/$1', ['filter' => 'authGuard']);
$routes->post('/booth/update/(:segment)', 'BoothController::updateBooth/$1', ['filter' => 'authGuard']);
// delete booth
$routes->delete('/booth/(:num)', 'BoothController::deleteBooth/$1', ['filter' => 'authGuard']);

// CRUD Booth List untuk tiap Event
// create booth
$routes->get('/boothlist/create/', 'BoothListController::createBoothList', ['filter' => 'authGuard']);
$routes->post('/boothlist/save', 'BoothListController::saveBoothList', ['filter' => 'authGuard']);
// update booth
$routes->get('/boothlist/edit/(:num)', 'BoothListController::editBoothList/$1', ['filter' => 'authGuard']);
$routes->post('/boothlist/update/(:num)', 'BoothListController::updateBoothList/$1', ['filter' => 'authGuard']);
// delete booth
$routes->delete('/boothlist/(:num)', 'BoothListController::deleteBoothList/$1', ['filter' => 'authGuard']);

// CRUD Produk untuk tiap Booth
// create produk
$routes->post('/produkbooth/save', 'ProdukController::save', ['filter' => 'authGuard']);
// update produk
$routes->put('/produkbooth/update/(:num)', 'ProdukController::update/$1', ['filter' => 'authGuard']);
// delete produk
$routes->delete('/produkbooth/(:num)', 'ProdukController::delete/$1', ['filter' => 'authGuard']);


// LOGIN Admin
$routes->get('login', 'Auth::login');
// set data admin ke session
$routes->post('login', 'Auth::loginPost');
// logout admin
$routes->get('logout', 'Auth::logout');
$routes->post('/admin/update/(:num)', 'Auth::update/$1');

// Admin Dashboard
$routes->get('/dashboard/home', 'Admin::dashboard', ['filter' => 'authGuard']);
// search bar pada halaman event
$routes->post('/dashboard/home', 'Admin::searchAndFilter', ['filter' => 'authGuard']);
$routes->get('/dashboard/event', 'Admin::event', ['filter' => 'authGuard']);
$routes->get('/dashboard/booth', 'Admin::booth', ['filter' => 'authGuard']);
$routes->get('/dashboard/produkbooth', 'Admin::produkbooth', ['filter' => 'authGuard']);
$routes->get('/dashboard/admin', 'Admin::admin', ['filter' => 'authGuard']);
$routes->get('/dashboard/boothlist', 'Admin::boothlist', ['filter' => 'authGuard']);
$routes->get('/dashboard/info', 'Admin::info', ['filter' => 'authGuard']);
$routes->get('/dashboard/pengaturan', 'Admin::pengaturan', ['filter' => 'authGuard']);

// REGISTER Admin
$routes->get('register', 'Auth::showRegister');
// tambah data register admin
$routes->post('register', 'Auth::register');

// DETAIL
// event
$routes->get('/event/(:any)', 'EventController::detail/$1');
// booth
$routes->get('/booth/(:any)', 'BoothController::detailBooth/$1');
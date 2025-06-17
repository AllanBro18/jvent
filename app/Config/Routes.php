<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// RESTful API
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function($routes) {
    $routes->resource('events');
});

$routes->get('events/(:any)', 'Api\Events::show/$1');


$routes->get('/', 'EventController::index');
$routes->post('/', 'EventController::filter');

// Create Event
$routes->get('event/search', 'EventController::filter');
$routes->get('event/filter/(:any)/(:any)', 'EventController::filter/$1/$2');
$routes->post('event/filter/(:any)/(:any)', 'EventController::filter/$1/$2');
$routes->post('event/search', 'EventController::filter');
$routes->post('event/filter', 'EventController::filter');

$routes->get('/event/create', 'EventController::create', ['filter' => 'authGuard']);
$routes->post('/event/save', 'EventController::save', ['filter' => 'authGuard']);

$routes->get('/event/edit/(:segment)', 'EventController::edit/$1', ['filter' => 'authGuard']);
$routes->post('/event/update/(:segment)', 'EventController::update/$1', ['filter' => 'authGuard']);

$routes->delete('/event/(:num)', 'EventController::delete/$1', ['filter' => 'authGuard']);

// BOOTH
$routes->get('/booth', 'BoothController::index');

$routes->get('/booth/create', 'BoothController::createBooth', ['filter' => 'authGuard']);
$routes->post('/booth/save', 'BoothController::saveBooth', ['filter' => 'authGuard']);
$routes->get('/booth/edit/(:segment)', 'BoothController::editBooth/$1', ['filter' => 'authGuard']);
$routes->post('/booth/update/(:segment)', 'BoothController::updateBooth/$1', ['filter' => 'authGuard']);
$routes->delete('/booth/(:num)', 'BoothController::deleteBooth/$1', ['filter' => 'authGuard']);


// BOOTH LIST
$routes->get('/boothlist/create/', 'BoothListController::createBoothList', ['filter' => 'authGuard']);
$routes->post('/boothlist/save', 'BoothListController::saveBoothList', ['filter' => 'authGuard']);
$routes->delete('/boothlist/(:num)', 'BoothListController::deleteBoothList/$1', ['filter' => 'authGuard']);
$routes->get('/boothlist/edit/(:num)', 'BoothListController::editBoothList/$1', ['filter' => 'authGuard']);
$routes->post('/boothlist/update/(:num)', 'BoothListController::updateBoothList/$1', ['filter' => 'authGuard']);
$routes->delete('/boothlist/(:num)', 'BoothListController::deleteBoothList/$1', ['filter' => 'authGuard']);


// LOGIN for ADMIN
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('logout', 'Auth::logout');

// Admin Dashboard
$routes->get('/dashboard', 'Admin::dashboard', ['filter' => 'authGuard']);
$routes->post('/dashboard', 'Admin::searchAndFilter', ['filter' => 'authGuard']);
$routes->get('/dashboard/booth', 'Admin::booth', ['filter' => 'authGuard']);
$routes->get('/dashboard/admin', 'Admin::admin', ['filter' => 'authGuard']);
$routes->get('/dashboard/boothlist', 'Admin::boothlist', ['filter' => 'authGuard']);
$routes->get('/dashboard/info', 'Admin::info', ['filter' => 'authGuard']);
$routes->get('/dashboard/pengaturan', 'Admin::pengaturan', ['filter' => 'authGuard']);

// Register
$routes->get('register', 'Auth::showRegister');
$routes->post('register', 'Auth::register');

// // ALERT MESSAGE
// $routes->get('alert/login', 'Alert::login');   // Contoh alert login diperlukan
// $routes->get('alert/success', 'Alert::success'); // Contoh alert sukses
// $routes->get('alert/error', 'Alert::error');     // Contoh alert error

// detail
// booth
$routes->get('/booth/(:any)', 'BoothController::detailBooth/$1');
// event
$routes->get('/event/(:any)', 'EventController::detail/$1');
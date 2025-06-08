<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EventController::index');
$routes->post('/', 'EventController::filter');

// Create Event
$routes->get('event/search', 'EventController::filter');
$routes->get('event/filter/(:any)/(:any)', 'EventController::filter/$1/$2');
$routes->post('event/filter/(:any)/(:any)', 'EventController::filter/$1/$2');
$routes->post('event/search', 'EventController::filter');
$routes->get('event/filter', 'Event::filterDefault');

$routes->get('/event/create', 'EventController::create', ['filter' => 'authGuard']);
$routes->post('/event/save', 'EventController::save', ['filter' => 'authGuard']);

$routes->get('/event/edit/(:segment)', 'EventController::edit/$1', ['filter' => 'authGuard']);
$routes->post('/event/update/(:segment)', 'EventController::update/$1', ['filter' => 'authGuard']);

$routes->delete('/event/(:num)', 'EventController::delete/$1', ['filter' => 'authGuard']);

// LOGIN for ADMIN
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('logout', 'Auth::logout');

// $routes->get('/admin', 'Admin::index');
$routes->get('/dashboard', 'Admin::dashboard', ['filter' => 'authGuard']);
$routes->post('/dashboard', 'Admin::searchAndFilter', ['filter' => 'authGuard']);
$routes->get('/dashboard/info', 'Admin::info', ['filter' => 'authGuard']);
$routes->get('/dashboard/pengaturan', 'Admin::pengaturan', ['filter' => 'authGuard']);

$routes->get('register', 'Auth::showRegister');
$routes->post('register', 'Auth::register');

// ALERT MESSAGE
$routes->get('alert/login', 'Alert::login');   // Contoh alert login diperlukan
$routes->get('alert/success', 'Alert::success'); // Contoh alert sukses
$routes->get('alert/error', 'Alert::error');     // Contoh alert error

// detail
$routes->get('/event/(:any)', 'EventController::detail/$1');
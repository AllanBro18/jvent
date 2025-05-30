<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EventController::index');

// Create Event
$routes->get('event', 'EventController::filter');
$routes->get('/event/create', 'EventController::create', ['filter' => 'authGuard']);
$routes->post('/event/save', 'EventController::save');
$routes->get('/event/edit/(:segment)', 'EventController::edit/$1', ['filter' => 'authGuard']);
$routes->post('/event/update/(:segment)', 'EventController::update/$1', ['filter' => 'authGuard']);
$routes->delete('/event/(:num)', 'EventController::delete/$1', ['filter' => 'authGuard']);

// detail
$routes->get('/event/(:any)', 'EventController::detail/$1', ['filter' => 'authGuard']);

// LOGIN for ADMIN
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('logout', 'Auth::logout');

// $routes->get('/admin', 'Admin::index');
$routes->get('/dashboard', 'Admin::dashboard', ['filter' => 'authGuard']);
$routes->get('/dashboard/info', 'Admin::info', ['filter' => 'authGuard']);
$routes->get('/dashboard/pengaturan', 'Admin::pengaturan', ['filter' => 'authGuard']);

$routes->get('register', 'Auth::showRegister');
$routes->post('register', 'Auth::register');

// ALERT MESSAGE
$routes->get('alert/login', 'Alert::login');   // Contoh alert login diperlukan
$routes->get('alert/success', 'Alert::success'); // Contoh alert sukses
$routes->get('alert/error', 'Alert::error');     // Contoh alert error
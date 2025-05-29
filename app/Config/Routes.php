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
$routes->get('/event/(:any)', 'EventController::detail/$1');

$routes->get('detail', 'EventController::detail');


// LOGIN for ADMIN
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::loginPost');
$routes->get('logout', 'Auth::logout');

// $routes->get('/admin', 'Admin::index');
$routes->get('/dashboard', 'Admin::dashboard', ['filter' => 'authGuard']);
$routes->get('/dashboard2', 'Admin::dashboard2', ['filter' => 'authGuard']);

$routes->get('/register', 'Auth::showRegister');
$routes->get('/auth/register', 'Auth::register');
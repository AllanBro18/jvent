<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EventController::index');

// Create Event
$routes->get('event', 'EventController::filter');
$routes->get('/event/create', 'EventController::create');
$routes->post('/event/save', 'EventController::save');
$routes->get('/event/(:any)', 'EventController::detail/$1');

$routes->get('detail', 'EventController::detail');


// LOGIN for ADMIN
$routes->get('login', 'Auth::index');
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/admin', 'Admin::index', ['filter' => 'authGuard']);

$routes->get('/register', 'Auth::showRegister');
$routes->get('/auth/register', 'Auth::register');
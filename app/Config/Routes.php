<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EventController::index');
$routes->get('events', 'EventController::filter');
$routes->get('detail', 'EventController::detail');


// LOGIN for ADMIN
$routes->get('login', 'Auth::index');
$routes->get('/auth/login', 'Auth::login');
$routes->get('/auth/logout', 'Auth::logout');

$routes->get('/admin', 'Admin::index', ['filter' => 'authGuard']);

$routes->get('/register', 'Auth::showRegister');
$routes->get('/auth/register', 'Auth::register');
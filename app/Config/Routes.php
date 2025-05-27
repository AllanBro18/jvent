<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('events', 'EventController::index');
$routes->get('detail', 'EventController::detail');

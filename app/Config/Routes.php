<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'EventController::index');
$routes->get('events', 'EventController::filter');
$routes->get('detail', 'EventController::detail');

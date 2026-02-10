<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AdminController::index');
$routes->post('/login', 'AdminController::login');

$routes->get('/dashboard', 'AdminController::dashboard');
$routes->get('/dashboard/edit/(:num)', 'AdminController::formEdit/$1');
$routes->post('/dashboard/update/(:num)', 'AdminController::updatePerangkat/$1');

$routes->get('/logout', 'AdminController::logout');
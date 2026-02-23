<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setAutoRoute(false);

$routes->group('', ['filter'=>'auth'], function($routes){
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('dashboard/edit/(:num)', 'AdminController::getPerangkat/$1');
    $routes->post('dashboard/update', 'AdminController::ajaxUpdate');
});

$routes->get('/', 'AdminController::index');
$routes->post('login', 'AdminController::login');

$routes->post('logout', 'AdminController::logout');
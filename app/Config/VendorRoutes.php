<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/** Vendor */
$routes->group('vendors', ['namespace' => 'App\Controllers\vendors'], function ($routes) {
    $routes->get('', 'WebController::index');
    $routes->get('dashboard', 'WebController::dashboard'); 
    $routes->get('products', 'WebController::products'); 
});

$routes->group('vendors/api', ['namespace' => 'App\Controllers\vendors'], function ($routes) {
    $routes->post('login', 'ApiController::login'); 
});
/** Vendor */


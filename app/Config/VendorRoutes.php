<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/** Vendor */
$routes->group('vendor', ['namespace' => 'App\Controllers\vendors'], function ($routes) {
    $routes->get('', function() {
        return redirect()->to('/vendor/login');
    });
    $routes->get('', 'WebController::index');
    $routes->get('login', 'WebController::index');
    $routes->get('dashboard', 'WebController::dashboard'); 
    $routes->get('products', 'WebController::products'); 
    $routes->get('logout', 'WebController::logout'); 
});

$routes->group('vendor/api', ['namespace' => 'App\Controllers\vendors'], function ($routes) {
    $routes->post('login', 'ApiController::login'); 
    /** Product */
    $routes->group("product", function ($routes) {
        $routes->post('created', 'ApiController::createdProduct'); 
        $routes->post('update', 'ApiController::updateProduct'); 
        $routes->post('update-status', 'ApiController::updateProductStatus'); 
        $routes->post('delete', 'ApiController::deleteProduct');
    });
    /** Product */
});
/** Vendor */


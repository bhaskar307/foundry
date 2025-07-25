<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/** Customer */
$routes->group('', ['namespace' => 'App\Controllers\Customer'], function ($routes) {
    $routes->get('/', 'WebController::index');
    $routes->get('product-list', 'WebController::product_list');
    $routes->get('category/product', 'WebController::category_product');
    $routes->get('product-details', 'WebController::product_details');
    $routes->get('registration', 'WebController::registration');
    //$routes->get('logout', 'WebController::logout'); 
});

$routes->group('customer/api', ['namespace' => 'App\Controllers\Customer'], function ($routes) {
    $routes->post('login', 'ApiController::login'); 
    
    $routes->group("request", function ($routes) {
        $routes->post('created', 'ApiController::createdRequest'); 
    });

    $routes->group("rating", function ($routes) {
        $routes->post('created', 'ApiController::createdRating'); 
    });
});
/** Customer */


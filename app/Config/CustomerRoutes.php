<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

/** Vendor */
$routes->group('customer', ['namespace' => 'App\Controllers\Customer'], function ($routes) {
    $routes->get('', 'WebController::index');
    $routes->get('logout', 'WebController::logout'); 
});

$routes->group('customer/api', ['namespace' => 'App\Controllers\Customer'], function ($routes) {
    $routes->post('login', 'ApiController::login'); 
    // $routes->post('change-password', 'ApiController::changePassword'); 
    // $routes->post('forgot-password', 'ApiController::forgotPassword'); 
    // $routes->post('reset-password', 'ApiController::resetPassword');
    // $routes->post('edit-profile', 'ApiController::edit_profile'); 
    /** Product */
    $routes->group("request", function ($routes) {
        $routes->post('created', 'ApiController::createdRequest'); 
        // $routes->post('update', 'ApiController::updateProduct'); 
        // $routes->post('update-status', 'ApiController::updateProductStatus'); 
        // $routes->post('delete', 'ApiController::deleteProduct');
    });
    /** Product */
});
/** Vendor */


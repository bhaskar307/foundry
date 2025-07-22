<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

/** Admin */
$routes->group('admin', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->get('', 'WebController::index');
    $routes->get('login', 'WebController::index');
    $routes->post('login', 'WebController::login'); 
    $routes->get('dashboard', 'WebController::dashboard'); 
    $routes->get('vendors', 'WebController::vendors'); 
    $routes->get('customers', 'WebController::customers'); 
    $routes->get('category', 'WebController::category'); 
    $routes->get('logout', 'WebController::logout'); 
});

$routes->group('admin/api', ['namespace' => 'App\Controllers\admin'], function ($routes) {
    $routes->post('login', 'ApiController::login'); 

    /** Customer */
    $routes->group("customer", function ($routes) {
        $routes->post('created', 'ApiController::createdCustomer'); 
        $routes->post('update', 'ApiController::updateCustomer'); 
        $routes->post('update-status', 'ApiController::updateCustomerStatus'); 
        $routes->post('delete', 'ApiController::deleteCustomer');
    });
    /** Customer */

    /** Vendor */
    $routes->post('created-vendor', 'ApiController::createdVendor'); 
    $routes->post('update-vendor', 'ApiController::updateVendor'); 
    $routes->post('vendor-update-status', 'ApiController::updateVendorStatus');
    $routes->post('delete-vendor', 'ApiController::deleteVendor');
    /** Vendor */

    /** Category */
    $routes->group("category", function ($routes) {
        $routes->post('created', 'ApiController::createdCategory'); 
        $routes->post('update', 'ApiController::updateCategory'); 
        $routes->post('update-status', 'ApiController::updateCategoryStatus'); 
        $routes->post('delete', 'ApiController::deleteCategory');
    });
    /** Category */
});
/** Admin */
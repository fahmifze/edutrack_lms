<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// Database test routes
// $routes->get('/db-test', 'DatabaseTest::index');
$routes->get('/basic-test', 'BasicDatabaseTest::index');
$routes->get('/complete-test', 'CompleteDatabaseTest::index');
$routes->get('/system-status', 'SystemStatusTest::index'); 



/*
 * --------------------------------------------------------------------
 * Additional Routes
 * --------------------------------------------------------------------
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
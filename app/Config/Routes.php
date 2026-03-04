<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// 🔐 AUTH ROUTES
$routes->get('/', 'Auth::login');
$routes->post('/login', 'Auth::attemptLogin');
$routes->get('/logout', 'Auth::logout');

// 📊 DASHBOARD ROUTES
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/cto-application', 'Dashboard::ctoApplication');
$routes->get('/cto-ledger', 'Dashboard::ctoLedger');
$routes->get('/report', 'Dashboard::report');
$routes->post('/save-cto', 'Dashboard::saveCto');
$routes->get('/report/pdf', 'Dashboard::pdf'); 



// Event  ROURES

$routes->get('/event', 'Event::index');
$routes->post('/save-event', 'Event::saveEvent');
$routes->get('delete-event/(:num)', 'Event::delete/$1');
$routes->post('update-event/(:num)', 'Event::update/$1');
<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

// ADM. USUARIOS
$routes->get('users','Admin::users');
$routes->get('users/(:any)','Admin::users/$1');
$routes->post('users','Admin::users');
$routes->post('users/(:any)','Admin::users');

// ADM. CARGOS
$routes->get('cargos','Admin::cargos');
$routes->get('cargos/(:any)','Admin::cargos/$1');
$routes->post('cargos','Admin::cargos');
$routes->post('cargos/(:any)','Admin::cargos');

// ADM. AREAS
$routes->get('areas','Admin::areas');
$routes->get('areas/(:any)','Admin::areas/$1');
$routes->post('areas','Admin::areas');
$routes->post('areas/(:any)','Admin::areas');

// DOCUMENTOS
$routes->get('documentos','Informativo::documentos');
$routes->get('documentos/(:any)','Informativo::documentos/$1');
$routes->post('documentos','Informativo::documentos');
$routes->post('documentos/(:any)','Informativo::documentos');
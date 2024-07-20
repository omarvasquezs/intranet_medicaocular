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

// PASSWORD RESET
$routes->get('reset_pass/(:num)', 'Admin::reset_pass/$1');

// REGISTRAR PERMISO / DESCANSO
$routes->get('registrar_permiso', 'General::registrar_permiso');
$routes->get('registrar_permiso/(:any)', 'General::registrar_permiso/$1');
$routes->post('registrar_permiso', 'General::registrar_permiso');
$routes->post('registrar_permiso/(:any)', 'General::registrar_permiso');

// LOGIN + LOG OUT
$routes->get('logout','Auth::logout');
$routes->get('login', 'Auth::login');
$routes->post('authenticate', 'Auth::authenticate');

// GERENCIA PERMISOS & BOLETAS
$routes->get('permisos_pendientes', 'Gerencia::permisos_pendientes');
$routes->get('permisos_pendientes/(:any)', 'Gerencia::permisos_pendientes/$1');
$routes->post('permisos_pendientes', 'Gerencia::permisos_pendientes');
$routes->post('permisos_pendientes/(:any)', 'Gerencia::permisos_pendientes');

$routes->get('permisos_aprobados', 'Gerencia::permisos_aprobados');
$routes->get('permisos_aprobados/(:any)', 'Gerencia::permisos_aprobados/$1');
$routes->post('permisos_aprobados', 'Gerencia::permisos_aprobados');
$routes->post('permisos_aprobados/(:any)', 'Gerencia::permisos_aprobados');

$routes->get('permisos_rechazados', 'Gerencia::permisos_rechazados');
$routes->get('permisos_rechazados/(:any)', 'Gerencia::permisos_rechazados/$1');
$routes->post('permisos_rechazados', 'Gerencia::permisos_rechazados');
$routes->post('permisos_rechazados/(:any)', 'Gerencia::permisos_rechazados');

$routes->get('boletas_pendientes', 'Gerencia::boletas_pendientes');
$routes->get('boletas_pendientes/(:any)', 'Gerencia::boletas_pendientes/$1');
$routes->post('boletas_pendientes', 'Gerencia::boletas_pendientes');
$routes->post('boletas_pendientes/(:any)', 'Gerencia::boletas_pendientes');

$routes->get('boletas_aprobadas', 'Gerencia::boletas_aprobadas');
$routes->get('boletas_aprobadas/(:any)', 'Gerencia::boletas_aprobadas/$1');
$routes->post('boletas_aprobadas', 'Gerencia::boletas_aprobadas');
$routes->post('boletas_aprobadas/(:any)', 'Gerencia::boletas_aprobadas');

// PERFIL
$routes->get('perfil', 'Home::perfil');
$routes->get('perfil/(:any)', 'Home::perfil/$1');
$routes->post('perfil', 'Home::perfil');
$routes->post('perfil/(:any)', 'Home::perfil');

$routes->get('mis_boletas', 'General::mis_boletas');
$routes->get('mis_boletas/(:any)', 'General::mis_boletas/$1');
$routes->post('mis_boletas', 'General::mis_boletas');
$routes->post('mis_boletas/(:any)', 'General::mis_boletas');

// CONTABILIDAD
$routes->get('contabilidad_boletas', 'Contabilidad::contabilidad_boletas');
$routes->get('contabilidad_boletas/(:any)', 'Contabilidad::contabilidad_boletas/$1');
$routes->post('contabilidad_boletas', 'Contabilidad::contabilidad_boletas');
$routes->post('contabilidad_boletas/(:any)', 'Contabilidad::contabilidad_boletas');

$routes->get('contabilidad_boletas_rechazadas', 'Contabilidad::contabilidad_boletas_rechazadas');
$routes->get('contabilidad_boletas_rechazadas/(:any)', 'Contabilidad::contabilidad_boletas_rechazadas/$1');
$routes->post('contabilidad_boletas_rechazadas', 'Contabilidad::contabilidad_boletas_rechazadas');
$routes->post('contabilidad_boletas_rechazadas/(:any)', 'Contabilidad::contabilidad_boletas_rechazadas');
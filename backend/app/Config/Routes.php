<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'ProductosController::index');

/* EMPLEADOS RUTAS */
$routes->group('empleados', function($routes) {
    $routes->get('/', 'EmpleadosController::index');
    $routes->get('eliminar/(:num)', 'EmpleadosController::eliminar/$1');
    $routes->get('buscar/(:num)', 'EmpleadosController::buscarId/$1');
    $routes->post('actualizar', 'EmpleadosController::actualizar');
    $routes->post('insertar', 'EmpleadosController::insertar');
});

/* CLIENTES RUTAS */
$routes->group('clientes', function($routes) {
    $routes->get('/', 'ClientesController::index');
    $routes->get('eliminar/(:any)', 'ClientesController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ClientesController::buscarId/$1');
    $routes->post('actualizar', 'ClientesController::actualizar');
    $routes->post('insertar', 'ClientesController::insertar');
});

/* CATEGORIAS RUTAS */
$routes->group('categorias', function($routes) {
    $routes->get('/', 'CategoriasController::index');
    $routes->get('eliminar/(:any)', 'CategoriasController::eliminar/$1');
    $routes->get('buscar/(:any)', 'CategoriasController::buscarId/$1');
    $routes->post('actualizar', 'CategoriasController::actualizar');
    $routes->post('insertar', 'CategoriasController::insertar');
});

/* PRODUCTOS RUTAS */
$routes->group('productos', function($routes) {
    $routes->get('/', 'ProductosController::index');
    $routes->get('eliminar/(:any)', 'ProductosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ProductosController::buscarId/$1');
    $routes->post('actualizar', 'ProductosController::actualizar');
    $routes->post('insertar', 'ProductosController::insertar');
});

/* CARRITOS RUTAS */
$routes->group('carritos', function($routes) {
    $routes->get('/', 'CarritosController::index');
    $routes->get('eliminar/(:any)', 'CarritosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'CarritosController::buscarId/$1');
    $routes->post('actualizar', 'CarritosController::actualizar');
    $routes->post('insertar', 'CarritosController::insertar');
});

/* DETALLE CARRITOS RUTAS */
$routes->group('detalle_carritos', function($routes) {
    $routes->get('/', 'DetalleCarritosController::index');
    $routes->get('eliminar/(:any)', 'DetalleCarritosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'DetalleCarritosController::buscarId/$1');
    $routes->post('actualizar', 'DetalleCarritosController::actualizar');
    $routes->post('insertar', 'DetalleCarritosController::insertar');
});

/* PEDIDOS RUTAS */
$routes->group('pedidos', function($routes) {
    $routes->get('/', 'PedidosController::index');
    $routes->get('eliminar/(:any)', 'PedidosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'PedidosController::buscarId/$1');
    $routes->post('actualizar', 'PedidosController::actualizar');
    $routes->post('insertar', 'PedidosController::insertar');
});

/* DETALLE PEDIDOS RUTAS */
$routes->group('detalle_pedidos', function($routes) {
    $routes->get('/', 'DetallePedidosController::index');
    $routes->get('eliminar/(:any)', 'DetallePedidosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'DetallePedidosController::buscarId/$1');
    $routes->post('actualizar', 'DetallePedidosController::actualizar');
    $routes->post('insertar', 'DetallePedidosController::insertar');
});

/* ENVIOS RUTAS */
$routes->group('envios', function($routes) {
    $routes->get('/', 'EnviosController::index');
    $routes->get('eliminar/(:any)', 'EnviosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'EnviosController::buscarId/$1');
    $routes->post('actualizar', 'EnviosController::actualizar');
    $routes->post('insertar', 'EnviosController::insertar');
});

/* RESEÑAS RUTAS */
$routes->group('resenias', function($routes) {
    $routes->get('/', 'ReseniasController::index');
    $routes->get('eliminar/(:any)', 'ReseniasController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ReseniasController::buscarId/$1');
    $routes->post('actualizar', 'ReseniasController::actualizar');
    $routes->post('insertar', 'ReseniasController::insertar');
});

/* LISTA DESEOS RUTAS */
$routes->group('lista_deseos', function($routes) {
    $routes->get('/', 'ListaDeseosController::index');
    $routes->get('eliminar/(:any)', 'ListaDeseosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ListaDeseosController::buscarId/$1');
    $routes->post('actualizar', 'ListaDeseosController::actualizar');
    $routes->post('insertar', 'ListaDeseosController::insertar');
});

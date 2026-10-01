<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

/* EMPLEADOS RUTAS */
$routes->group('empleados', function($routes) {
    $routes->get('/', 'EmpleadosController::index');
    $routes->get('eliminar/(:num)', 'EmpleadosController::eliminar/$1');
    $routes->get('buscar/(:num)', 'EmpleadosController::buscarId/$1');
    $routes->post('actualizar', 'EmpleadosController::actualizar');
    $routes->post('insertar', 'EmpleadosController::insertar');
});

/* ESTADOS RUTAS */
$routes->group('estados', function($routes) {
    $routes->get('/', 'EstadosController::index');
    $routes->get('eliminar/(:num)', 'EstadosController::eliminar/$1');
    $routes->get('buscar/(:num)', 'EstadosController::buscarId/$1');
    $routes->post('actualizar', 'EstadosController::actualizar');
    $routes->post('insertar', 'EstadosController::insertar');
});

/* GRADOS RUTAS */
$routes->group('grados', function($routes) {
    $routes->get('/', 'GradosController::index');
    $routes->get('eliminar/(:num)', 'GradosController::eliminar/$1');
    $routes->get('buscar/(:num)', 'GradosController::buscarId/$1');
    $routes->post('actualizar', 'GradosController::actualizar');
    $routes->post('insertar', 'GradosController::insertar');
});

/* EDITORIALES RUTAS */
$routes->group('editoriales', function($routes) {
    $routes->get('/', 'EditorialesController::index');
    $routes->get('eliminar/(:num)', 'EditorialesController::eliminar/$1');
    $routes->get('buscar/(:num)', 'EditorialesController::buscarId/$1');
    $routes->post('actualizar', 'EditorialesController::actualizar');
    $routes->post('insertar', 'EditorialesController::insertar');
});

/* AUTORES RUTAS */
$routes->group('autores', function($routes) {
    $routes->get('/', 'AutoresController::index');
    $routes->get('eliminar/(:num)', 'AutoresController::eliminar/$1');
    $routes->get('buscar/(:num)', 'AutoresController::buscarId/$1');
    $routes->post('actualizar', 'AutoresController::actualizar');
    $routes->post('insertar', 'AutoresController::insertar');
});

/* ESTUDIANTES RUTAS */
$routes->group('estudiantes', function($routes) {
    $routes->get('/', 'EstudiantesController::index');
    $routes->get('eliminar/(:num)', 'EstudiantesController::eliminar/$1');
    $routes->get('buscar/(:num)', 'EstudiantesController::buscarId/$1');
    $routes->post('actualizar', 'EstudiantesController::actualizar');
    $routes->post('insertar', 'EstudiantesController::insertar');
});

/* LIBROS RUTAS */
$routes->group('libros', function($routes) {
    $routes->get('/', 'LibrosController::index');
    $routes->get('eliminar/(:num)', 'LibrosController::eliminar/$1');
    $routes->get('buscar/(:num)', 'LibrosController::buscarId/$1');
    $routes->post('actualizar', 'LibrosController::actualizar');
    $routes->post('insertar', 'LibrosController::insertar');
});

/* PRÉSTAMOS RUTAS */
$routes->group('prestamos', function($routes) {
    $routes->get('/', 'PrestamosController::index');
    $routes->get('eliminar/(:num)', 'PrestamosController::eliminar/$1');
    $routes->get('buscar/(:num)', 'PrestamosController::buscarId/$1');
    $routes->post('actualizar', 'PrestamosController::actualizar');
    $routes->post('insertar', 'PrestamosController::insertar');
});

/* RUTAS GENERADAS AUTOMÁTICAMENTE PARA E-COMMERCE */
$routes->group('clientes', function($routes) {
    $routes->get('/', 'ClientesController::index');
    $routes->get('eliminar/(:any)', 'ClientesController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ClientesController::buscarId/$1');
    $routes->post('actualizar', 'ClientesController::actualizar');
    $routes->post('insertar', 'ClientesController::insertar');
});
$routes->group('categorias', function($routes) {
    $routes->get('/', 'CategoriasController::index');
    $routes->get('eliminar/(:any)', 'CategoriasController::eliminar/$1');
    $routes->get('buscar/(:any)', 'CategoriasController::buscarId/$1');
    $routes->post('actualizar', 'CategoriasController::actualizar');
    $routes->post('insertar', 'CategoriasController::insertar');
});
$routes->group('productos', function($routes) {
    $routes->get('/', 'ProductosController::index');
    $routes->get('eliminar/(:any)', 'ProductosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ProductosController::buscarId/$1');
    $routes->post('actualizar', 'ProductosController::actualizar');
    $routes->post('insertar', 'ProductosController::insertar');
});
$routes->group('carritos', function($routes) {
    $routes->get('/', 'CarritosController::index');
    $routes->get('eliminar/(:any)', 'CarritosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'CarritosController::buscarId/$1');
    $routes->post('actualizar', 'CarritosController::actualizar');
    $routes->post('insertar', 'CarritosController::insertar');
});
$routes->group('detalle_carritos', function($routes) {
    $routes->get('/', 'DetalleCarritosController::index');
    $routes->get('eliminar/(:any)', 'DetalleCarritosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'DetalleCarritosController::buscarId/$1');
    $routes->post('actualizar', 'DetalleCarritosController::actualizar');
    $routes->post('insertar', 'DetalleCarritosController::insertar');
});
$routes->group('pedidos', function($routes) {
    $routes->get('/', 'PedidosController::index');
    $routes->get('eliminar/(:any)', 'PedidosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'PedidosController::buscarId/$1');
    $routes->post('actualizar', 'PedidosController::actualizar');
    $routes->post('insertar', 'PedidosController::insertar');
});
$routes->group('detalle_pedidos', function($routes) {
    $routes->get('/', 'DetallePedidosController::index');
    $routes->get('eliminar/(:any)', 'DetallePedidosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'DetallePedidosController::buscarId/$1');
    $routes->post('actualizar', 'DetallePedidosController::actualizar');
    $routes->post('insertar', 'DetallePedidosController::insertar');
});
$routes->group('envios', function($routes) {
    $routes->get('/', 'EnviosController::index');
    $routes->get('eliminar/(:any)', 'EnviosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'EnviosController::buscarId/$1');
    $routes->post('actualizar', 'EnviosController::actualizar');
    $routes->post('insertar', 'EnviosController::insertar');
});
$routes->group('resenias', function($routes) {
    $routes->get('/', 'ReseniasController::index');
    $routes->get('eliminar/(:any)', 'ReseniasController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ReseniasController::buscarId/$1');
    $routes->post('actualizar', 'ReseniasController::actualizar');
    $routes->post('insertar', 'ReseniasController::insertar');
});
$routes->group('lista_deseos', function($routes) {
    $routes->get('/', 'ListaDeseosController::index');
    $routes->get('eliminar/(:any)', 'ListaDeseosController::eliminar/$1');
    $routes->get('buscar/(:any)', 'ListaDeseosController::buscarId/$1');
    $routes->post('actualizar', 'ListaDeseosController::actualizar');
    $routes->post('insertar', 'ListaDeseosController::insertar');
});

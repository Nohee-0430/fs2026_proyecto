<?php
if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
    @session_start();
}
require_once __DIR__ . "/conexion/conexion.php";
require_once __DIR__ . "/clases/Carrito.php";
require_once __DIR__ . "/clases/Deseos.php";
require_once __DIR__ . "/clases/Usuarios.php";
require_once __DIR__ . "/helpers.php";

$totalItemsCarrito = Carrito::contarItems();
$totalItemsDeseos = Deseos::contar();
$totalMontoCarrito = Carrito::obtenerTotal();

// Datos del usuario autenticado (basados en las variables de sesión del curso)
$estaAutenticado = Usuarios::estaAutenticado();
$nombreUsuario = $_SESSION['nombre'] ?? '';
$tipoUsuario = (int)($_SESSION['tipo'] ?? 0);
$esEmpleado = ($tipoUsuario === 2);

// Página activa para resaltar la pestaña correspondiente
$paginaActual = $paginaActual ?? 'catalogo';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($tituloPagina) ? escapar($tituloPagina) . ' | Dulce Impresión' : 'Dulce Impresión | Insumos & Papel Comestible' ?></title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Estilos personalizados Dulce Impresión -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ====================================================================
         HEADER & BARRA DE NAVEGACIÓN SUPERIOR
         ==================================================================== -->
    <header class="header-wrapper">
        <div class="container-fluid px-3 px-lg-4 py-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                
                <!-- Logo & Marca -->
                <a href="index.php" class="brand-container text-decoration-none">
                    <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión Logo" class="brand-logo-img">
                    <div>
                        <h1 class="brand-title">DULCE IMPRESIÓN</h1>
                        <p class="brand-subtitle">Tienda de Impresiones & Papel Comestible</p>
                    </div>
                </a>

                <!-- Pestañas de Navegación Centrales (Desktop) -->
                <nav class="d-none d-lg-block">
                    <ul class="nav-pills-custom">
                        <li>
                            <a href="index.php" class="nav-link-tab <?= $paginaActual === 'catalogo' ? 'active' : '' ?>">
                                Catálogo
                            </a>
                        </li>
                        <li>
                            <a href="carrito.php" class="nav-link-tab <?= $paginaActual === 'carrito' ? 'active' : '' ?>">
                                Mi Carrito 
                                <?php if ($totalItemsCarrito > 0): ?>
                                    <span class="tab-badge"><?= $totalItemsCarrito ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <a href="deseos.php" class="nav-link-tab <?= $paginaActual === 'deseos' ? 'active' : '' ?>">
                                Lista de Deseos 
                                <?php if ($totalItemsDeseos > 0): ?>
                                    <span class="tab-badge"><?= $totalItemsDeseos ?></span>
                                <?php endif; ?>
                            </a>
                        </li>
                        <li>
                            <a href="pedidos.php" class="nav-link-tab <?= $paginaActual === 'pedidos' ? 'active' : '' ?>">
                                Estado de Pedido
                            </a>
                        </li>
                        <?php if ($esEmpleado): ?>
                            <li>
                                <a href="admin.php" class="nav-link-tab text-primary fw-bold <?= $paginaActual === 'admin' ? 'active' : '' ?>">
                                    <i class="bi bi-shield-lock me-1"></i> Panel Empleado
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <!-- Buscador y Perfil de Usuario (Lógica de autenticación del curso) -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Buscador -->
                    <div class="search-input-wrapper d-none d-md-block">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="globalSearchInput" class="search-input-custom" 
                               placeholder="Buscar papel de azúcar, figuras...">
                    </div>

                    <?php if ($estaAutenticado): ?>
                        <!-- ESTADO: USUARIO CON SESIÓN INICIADA -->
                        <div class="user-account-badge dropdown">
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 text-wine"></i>
                                <div class="text-start">
                                    <span class="account-name d-block lh-1 fw-bold"><?= escapar($nombreUsuario) ?></span>
                                    <span class="badge <?= $esEmpleado ? 'bg-primary' : 'bg-wine' ?> text-white" style="font-size: 9px;">
                                        <?= $esEmpleado ? 'Empleado (Tipo 2)' : 'Cliente (Tipo 1)' ?>
                                    </span>
                                </div>
                                <span class="account-separator">|</span>
                                <span class="account-total fw-bold">Q <?= number_format($totalMontoCarrito, 2) ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                                <li class="px-3 py-1 small text-muted">Usuario: <strong><?= escapar($_SESSION['usuario']) ?></strong></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <?php if ($esEmpleado): ?>
                                    <li>
                                        <a class="dropdown-item small text-primary fw-semibold" href="pedidos.php">
                                            <i class="bi bi-shield-lock me-2"></i> Panel de Empleado (Pedidos)
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item small text-danger" href="objetos/cerrarSesion.php">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- ESTADO: INVITADO (BOTONES PARA INICIAR SESIÓN Y CREAR CUENTA) -->
                        <div class="d-flex align-items-center gap-2">
                            <a href="login.php" class="btn-pill-outline btn-sm fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1 text-wine"></i> Iniciar Sesión
                            </a>
                            <a href="frm_crear_usuario.php" class="btn-pill-primary btn-sm fw-semibold d-none d-sm-inline-flex">
                                <i class="bi bi-person-plus me-1"></i> Crear Cuenta
                            </a>
                        </div>
                    <?php endif; ?>

                    <!-- Botón Hamburguesa para Móviles -->
                    <button class="btn btn-sm d-lg-none border-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#mobileMenuCollapse">
                        <i class="bi bi-list fs-2 text-dark"></i>
                    </button>
                </div>

            </div>

            <!-- Menú Colapsable Móvil -->
            <div class="collapse d-lg-none mt-2" id="mobileMenuCollapse">
                <div class="p-3 bg-white rounded shadow-sm">
                    <ul class="nav flex-column gap-2 mb-3">
                        <li class="nav-item">
                            <a class="nav-link text-dark <?= $paginaActual === 'catalogo' ? 'fw-bold text-wine' : '' ?>" href="index.php">
                                <i class="bi bi-grid me-2"></i> Catálogo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark <?= $paginaActual === 'carrito' ? 'fw-bold text-wine' : '' ?>" href="carrito.php">
                                <i class="bi bi-cart me-2"></i> Mi Carrito (<?= $totalItemsCarrito ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark <?= $paginaActual === 'deseos' ? 'fw-bold text-wine' : '' ?>" href="deseos.php">
                                <i class="bi bi-heart me-2"></i> Lista de Deseos (<?= $totalItemsDeseos ?>)
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark <?= $paginaActual === 'pedidos' ? 'fw-bold text-wine' : '' ?>" href="pedidos.php">
                                <i class="bi bi-truck me-2"></i> Estado de Pedido
                            </a>
                        </li>
                        <?php if ($esEmpleado): ?>
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold <?= $paginaActual === 'admin' ? 'text-wine' : '' ?>" href="admin.php">
                                    <i class="bi bi-shield-lock me-2"></i> Panel Empleado
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <div class="pt-2 border-top">
                        <?php if ($estaAutenticado): ?>
                            <span class="d-block small text-muted mb-1">Conectado como: <strong><?= escapar($nombreUsuario) ?></strong></span>
                            <a href="objetos/cerrarSesion.php" class="btn btn-sm btn-outline-danger w-100 rounded-pill">
                                <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                            </a>
                        <?php else: ?>
                            <div class="d-grid gap-2">
                                <a href="login.php" class="btn btn-sm btn-pill-outline">Iniciar Sesión</a>
                                <a href="frm_crear_usuario.php" class="btn btn-sm btn-pill-primary">Crear Cuenta</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Aviso de Estado de Conexión a MongoDB -->
            <?php if ($mongoConectado): ?>
                <div class="alert alert-success py-1 px-3 mt-2 mb-0 d-flex align-items-center justify-content-between small shadow-sm rounded-pill">
                    <span><i class="bi bi-check-circle-fill me-1 text-success"></i> <strong>MongoDB Conectado:</strong> Base de datos <code><?= escapar($mongoDatabase) ?></code></span>
                    <a href="conexion/seed_mongo.php" class="text-success text-decoration-underline fw-semibold">Sincronizar Productos</a>
                </div>
            <?php endif; ?>

        </div>
    </header>

    <main class="main-wrapper py-4">
        <div class="container-fluid px-3 px-lg-4">

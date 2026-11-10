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

$estaAutenticado = Usuarios::estaAutenticado();
$nombreUsuario = $_SESSION['nombre'] ?? '';
$tipoUsuario = (int)($_SESSION['tipo'] ?? 0);
$esEmpleado = ($tipoUsuario === 2);

$paginaActual = $paginaActual ?? 'catalogo';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($tituloPagina) ? escapar($tituloPagina) . ' | Dulce Impresión' : 'Dulce Impresión | Insumos & Papel Comestible' ?></title>
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <header class="header-wrapper">
        <div class="container-fluid px-3 px-lg-4 py-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                
                <a href="<?= $esEmpleado ? '../backend/public/productos' : 'index.php' ?>" class="brand-container text-decoration-none">
                    <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión Logo" class="brand-logo-img">
                    <div>
                        <h1 class="brand-title">DULCE IMPRESIÓN</h1>
                        <p class="brand-subtitle">Tienda de Impresiones & Papel Comestible</p>
                    </div>
                </a>

                <nav class="d-none d-lg-block">
                    <ul class="nav-pills-custom">
                        <?php if ($esEmpleado): ?>
                            <li>
                                <a href="../backend/public/productos" class="nav-link-tab text-primary fw-bold active">
                                    <i class="bi bi-terminal me-1"></i> Backend CI4 (Productos & Formulario)
                                </a>
                            </li>
                            <li>
                                <a href="../backend/public/pedidos" class="nav-link-tab">
                                    <i class="bi bi-receipt me-1"></i> Pedidos (CI4)
                                </a>
                            </li>
                            <li>
                                <a href="../backend/public/clientes" class="nav-link-tab">
                                    <i class="bi bi-people me-1"></i> Clientes (CI4)
                                </a>
                            </li>
                            <li>
                                <a href="../backend/public/empleados" class="nav-link-tab">
                                    <i class="bi bi-shield-check me-1"></i> Empleados (CI4)
                                </a>
                            </li>
                            <li>
                                <a href="index.php" class="nav-link-tab <?= $paginaActual === 'catalogo' ? 'active' : '' ?>">
                                    <i class="bi bi-shop me-1"></i> Ver Tienda (Cliente)
                                </a>
                            </li>
                        <?php else: ?>
                            <li>
                                <a href="index.php" class="nav-link-tab <?= $paginaActual === 'catalogo' ? 'active' : '' ?>">
                                    <i class="bi bi-grid me-1"></i> Catálogo
                                </a>
                            </li>
                            <li>
                                <a href="carrito.php" class="nav-link-tab <?= $paginaActual === 'carrito' ? 'active' : '' ?>">
                                    <i class="bi bi-cart me-1"></i> Mi Carrito 
                                    <?php if ($totalItemsCarrito > 0): ?>
                                        <span class="tab-badge"><?= $totalItemsCarrito ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li>
                                <a href="deseos.php" class="nav-link-tab <?= $paginaActual === 'deseos' ? 'active' : '' ?>">
                                    <i class="bi bi-heart me-1"></i> Lista de Deseos 
                                    <?php if ($totalItemsDeseos > 0): ?>
                                        <span class="tab-badge"><?= $totalItemsDeseos ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li>
                                <a href="pedidos.php" class="nav-link-tab <?= $paginaActual === 'pedidos' ? 'active' : '' ?>">
                                    <i class="bi bi-truck me-1"></i> Estado de Pedido
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>

                <div class="d-flex align-items-center gap-3">
                    <div class="search-input-wrapper d-none d-md-block">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="globalSearchInput" class="search-input-custom" 
                               placeholder="Buscar papel de azúcar, figuras...">
                    </div>

                    <?php if ($estaAutenticado): ?>
                        <div class="user-account-badge dropdown">
                            <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi <?= $esEmpleado ? 'bi-shield-shaded text-primary' : 'bi-person-circle text-wine' ?> fs-5"></i>
                                <div class="text-start">
                                    <span class="account-name d-block lh-1 fw-bold"><?= escapar($nombreUsuario) ?></span>
                                    <span class="badge <?= $esEmpleado ? 'bg-primary' : 'bg-wine' ?> text-white" style="font-size: 9px;">
                                        <?= $esEmpleado ? 'Empleado / Admin' : 'Cliente' ?>
                                    </span>
                                </div>
                                <?php if (!$esEmpleado): ?>
                                    <span class="account-separator">|</span>
                                    <span class="account-total fw-bold">Q <?= number_format($totalMontoCarrito, 2) ?></span>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                                <li class="px-3 py-1 small text-muted">Usuario: <strong><?= escapar($_SESSION['usuario']) ?></strong></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <?php if ($esEmpleado): ?>
                                    <li>
                                        <a class="dropdown-item small text-primary fw-semibold" href="../backend/public/productos">
                                            <i class="bi bi-terminal me-2"></i> Backend CI4 (Modificar & Formularios)
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small" href="index.php">
                                            <i class="bi bi-shop me-2"></i> Ver Catálogo de Tienda
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a class="dropdown-item small" href="pedidos.php">
                                            <i class="bi bi-truck me-2"></i> Mis Pedidos
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item small" href="carrito.php">
                                            <i class="bi bi-cart me-2"></i> Mi Carrito (Q <?= number_format($totalMontoCarrito, 2) ?>)
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <a class="dropdown-item small text-danger" href="objetos/cerrarSesion.php">
                                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="d-flex align-items-center gap-2">
                            <a href="login.php" class="btn-pill-outline btn-sm fw-semibold">
                                <i class="bi bi-box-arrow-in-right me-1 text-wine"></i> Iniciar Sesión
                            </a>
                            <a href="frm_crear_usuario.php" class="btn-pill-primary btn-sm fw-semibold d-none d-sm-inline-flex">
                                <i class="bi bi-person-plus me-1"></i> Crear Cuenta
                            </a>
                        </div>
                    <?php endif; ?>

                    <button class="btn btn-sm d-lg-none border-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#mobileMenuCollapse">
                        <i class="bi bi-list fs-2 text-dark"></i>
                    </button>
                </div>

            </div>

            <div class="collapse d-lg-none mt-2" id="mobileMenuCollapse">
                <div class="p-3 bg-white rounded shadow-sm">
                    <ul class="nav flex-column gap-2 mb-3">
                        <?php if ($esEmpleado): ?>
                            <li class="nav-item">
                                <a class="nav-link text-primary fw-bold" href="../backend/public/productos">
                                    <i class="bi bi-terminal me-2"></i> Backend CI4 (Productos & Formularios)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="../backend/public/pedidos">
                                    <i class="bi bi-receipt me-2"></i> Pedidos (CI4)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="../backend/public/clientes">
                                    <i class="bi bi-people me-2"></i> Clientes (CI4)
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-dark" href="index.php">
                                    <i class="bi bi-grid me-2"></i> Catálogo Tienda
                                </a>
                            </li>
                        <?php else: ?>
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
                        <?php endif; ?>
                    </ul>

                    <div class="pt-2 border-top">
                        <?php if ($estaAutenticado): ?>
                            <span class="d-block small text-muted mb-1">
                                Conectado como: <strong><?= escapar($nombreUsuario) ?></strong> 
                                (<?= $esEmpleado ? 'Empleado' : 'Cliente' ?>)
                            </span>
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

            <?php if ($mysqlConectado): ?>
                <div class="alert alert-success py-1 px-3 mt-2 mb-0 d-flex align-items-center justify-content-between small shadow-sm rounded-pill">
                    <span>
                        <i class="bi bi-database-check me-1 text-success"></i> 
                        <strong>MySQL Conectado:</strong> Base de datos <code><?= escapar($mysqlDb) ?></code>
                        <?php if ($mongoConectado): ?>
                            <span class="ms-2">| <i class="bi bi-check-circle-fill text-success"></i> <strong>MongoDB:</strong> Activo</span>
                        <?php endif; ?>
                    </span>
                    <?php if ($esEmpleado): ?>
                        <a href="../backend/public/productos" class="badge bg-primary text-decoration-none rounded-pill px-3">
                            <i class="bi bi-terminal me-1"></i> Backend CI4 Activo
                        </a>
                    <?php else: ?>
                        <span class="badge bg-wine text-white rounded-pill px-3">
                            <i class="bi bi-person me-1"></i> <?= $estaAutenticado ? 'Cliente' : 'Invitado' ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

        </div>
    </header>

    <main class="main-wrapper py-4">
        <div class="container-fluid px-3 px-lg-4">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Dulce Impresión | Panel Empleados CI4') ?></title>
    <!-- Bootstrap CSS Local -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        :root {
            --wine: #6B1D2F;
            --wine-dark: #4A121F;
            --rose: #F9EBEA;
            --mint: #E8F8F5;
        }
        body {
            background-color: #f7f5f2;
            color: #2b2b2b;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .navbar-backend {
            background: linear-gradient(135deg, #6B1D2F 0%, #4A121F 100%) !important;
        }
        .navbar-brand-logo {
            height: 38px;
            filter: brightness(0) invert(1);
        }
        .nav-link {
            color: rgba(255, 255, 255, 0.88) !important;
            font-weight: 500;
            font-size: 0.90rem;
            padding: 0.45rem 0.70rem !important;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .nav-link:hover, .nav-link.active {
            color: #ffffff !important;
            background-color: rgba(255, 255, 255, 0.18);
        }
        .card {
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04);
            background-color: #ffffff;
        }
        .table thead th {
            background-color: #6B1D2F;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-wine {
            background-color: #6B1D2F;
            border-color: #6B1D2F;
            color: #ffffff;
        }
        .btn-wine:hover {
            background-color: #541624;
            border-color: #541624;
            color: #ffffff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-xl navbar-dark navbar-backend shadow-sm mb-4">
        <div class="container-fluid px-3 px-lg-4">
            <a class="navbar-brand d-flex align-items-center gap-2 text-white fw-bold" href="<?= base_url('productos') ?>">
                <img src="<?= base_url('imagenes/logo_proyecto.png') ?>" alt="Logo" class="navbar-brand-logo">
                <span>DULCE IMPRESIÓN <small class="fw-normal opacity-75 d-block" style="font-size: 11px;">Panel Empleados (CodeIgniter 4)</small></span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarBackend">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarBackend">
                <ul class="navbar-nav me-auto ms-2">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('productos') ?>"><i class="bi bi-box-seam me-1"></i> Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('categorias') ?>"><i class="bi bi-tag me-1"></i> Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('pedidos') ?>"><i class="bi bi-receipt me-1"></i> Pedidos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('clientes') ?>"><i class="bi bi-person me-1"></i> Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('empleados') ?>"><i class="bi bi-shield-check me-1"></i> Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('envios') ?>"><i class="bi bi-truck me-1"></i> Envíos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('carritos') ?>"><i class="bi bi-cart me-1"></i> Carritos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('resenias') ?>"><i class="bi bi-star me-1"></i> Reseñas</a></li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-white text-dark rounded-pill px-3 py-2 d-none d-lg-inline-block small">
                        <i class="bi bi-shield-check text-primary me-1"></i> Rol: Empleado
                    </span>
                    <a href="http://localhost/fs2026_proyecto/frontend/index.php" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="bi bi-shop me-1"></i> Ver Catálogo (Tienda)
                    </a>
                    <a href="http://localhost/fs2026_proyecto/frontend/objetos/cerrarSesion.php" class="btn btn-sm btn-light text-danger rounded-pill px-3 fw-semibold">
                        <i class="bi bi-box-arrow-right me-1"></i> Salir
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid px-3 px-lg-4 mb-5">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS Local -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="es" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Sweet Candy') ?></title>
    <!-- Bootstrap CSS Local -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css') ?>">
    <style>
        body {
            background-color: #7ae1c6;
            color: #306059;
        }
        .navbar {
            background-color: #13a4ba !important;
        }
        .card {
            background-color: #8ddcb7;
            border-color: #4e836a;
        }
        .table {
            color: #e0e0e0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="<?= base_url() ?>">
                Sweet Candy
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('clientes') ?>">Clientes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('empleados') ?>">Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('productos') ?>">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('categorias') ?>">Categorías</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('carritos') ?>">Carritos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('detalle_carritos') ?>">Detalles del Carrito</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('pedidos') ?>">Pedido</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('detalle_pedidos') ?>">Detalles del Pedido</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('envios') ?>">Envíos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('lista_deseos') ?>">Lista de Deseos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('resenias') ?>">Reseñas</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <?= $this->renderSection('content') ?>
    </div>

    <!-- Bootstrap JS Local -->
    <script src="<?= base_url('assets/js/bootstrap.bundle.min.js') ?>"></script>
</body>
</html>

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
            background-color: #121212;
            color: #e0e0e0;
        }
        .navbar {
            background-color: #1f1f1f !important;
        }
        .card {
            background-color: #1e1e1e;
            border-color: #333;
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
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('prestamos') ?>">Préstamos</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('libros') ?>">Libros</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('estudiantes') ?>">Estudiantes</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('autores') ?>">Autores</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('editoriales') ?>">Editoriales</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('empleados') ?>">Empleados</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('estados') ?>">Estados</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('grados') ?>">Grados</a></li>
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

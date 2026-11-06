<?php
$paginaActual = 'pedidos';
$tituloPagina = 'Estado de Pedidos';
require_once "header.php";
require_once "clases/Pedidos.php";

$listaPedidos = Pedidos::obtenerPedidos($conexionMongo);
?>

<div class="row g-4">
    <div class="col-12">
        <div class="content-card">
            
            <?php if (isset($_GET['creado'])): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between mb-4 rounded-pill px-4" role="alert">
                    <div>
                        <i class="bi bi-bag-check-fill me-2 fs-5"></i>
                        <span>¡Tu pedido <strong><?= escapar($_GET['creado']) ?></strong> ha sido registrado y guardado con éxito!</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <div>
                    <h2 class="card-title-lg mb-1">Estado e Historial de Pedidos</h2>
                    <p class="card-subtitle-muted mb-0">
                        Consulta el avance de tus órdenes.
                    </p>
                </div>
                <a href="index.php" class="btn btn-pill-outline btn-sm">
                    <i class="bi bi-cart-plus me-1"></i> Nuevo Pedido
                </a>
            </div>

            <?php if (empty($listaPedidos)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-truck fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">No tienes pedidos registrados todavía</h5>
                    <p class="text-muted small">Realiza una compra en el catálogo para registrar tu primer pedido.</p>
                    <a href="index.php" class="btn btn-pill-primary mt-2 px-4">
                        <i class="bi bi-grid me-1"></i> Ir al Catálogo
                    </a>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($listaPedidos as $pedido): ?>
                        <div class="col-md-6 col-lg-6">
                            <div class="card border rounded-4 shadow-sm h-100 p-3">
                                <div class="d-flex justify-content-between align-items-start border-bottom pb-2 mb-3">
                                    <div>
                                        <span class="badge bg-wine text-white rounded-pill px-3 py-1 fw-bold fs-6">
                                            <?= escapar($pedido['codigo']) ?>
                                        </span>
                                        <span class="text-muted small d-block mt-1">
                                            <i class="bi bi-clock me-1"></i> <?= escapar($pedido['fecha']) ?>
                                        </span>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill fw-semibold">
                                        <i class="bi bi-check-circle me-1"></i> <?= escapar($pedido['estado'] ?? 'En Preparación') ?>
                                    </span>
                                </div>

                                <div class="row g-2 small mb-3">
                                    <div class="col-6">
                                        <span class="text-muted d-block">Cliente:</span>
                                        <strong><?= escapar($pedido['cliente'] ?? 'N/A') ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">Teléfono:</span>
                                        <strong><?= escapar($pedido['telefono'] ?? 'N/A') ?></strong>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">Entrega:</span>
                                        <span><?= escapar($pedido['tipo_entrega'] ?? 'Local') ?></span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted d-block">No. Guía:</span>
                                        <code class="text-wine fw-bold"><?= escapar($pedido['guia_tracking'] ?? 'N/A') ?></code>
                                    </div>
                                    <div class="col-12">
                                        <span class="text-muted d-block">Dirección:</span>
                                        <span><?= escapar($pedido['direccion'] ?? 'Recoger en tienda') ?></span>
                                    </div>
                                </div>

                                <!-- Productos del pedido -->
                                <div class="bg-light p-2 rounded-3 mb-3 border small">
                                    <strong class="d-block mb-1 text-wine">Artículos del Pedido:</strong>
                                    <ul class="list-unstyled mb-0">
                                        <?php if (!empty($pedido['items']) && is_array($pedido['items'])): ?>
                                            <?php foreach ($pedido['items'] as $item): ?>
                                                <li class="d-flex justify-content-between py-1 border-bottom border-white">
                                                    <span><?= (int)$item['cantidad'] ?>x <?= escapar($item['nombre']) ?></span>
                                                    <span class="fw-semibold">Q <?= number_format((float)$item['subtotal'], 2) ?></span>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <li class="text-muted">Detalles en preparación</li>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                    <span class="text-muted small">Total Registrado:</span>
                                    <span class="fs-5 fw-bold text-wine">Q <?= number_format((float)$pedido['total'], 2) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>

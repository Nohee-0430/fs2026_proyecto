<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 my-3">
    <div>
        <h2 class="fw-bold mb-1" style="color: #6B1D2F;"><i class="bi bi-cart me-2"></i>Monitoreo de Carritos</h2>
        <p class="text-muted small mb-0">Visualiza los carritos en proceso de los clientes y si fueron confirmados como pedidos.</p>
    </div>
    <button type="button" class="btn btn-wine rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalcarritos">
        <i class="bi bi-plus-circle me-1"></i> Formulario: Nuevo Carrito
    </button>
</div>

<!-- Modal Formulario: Nuevo Carrito -->
<div class="modal fade" id="modalcarritos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white rounded-top-4" style="background-color: #6B1D2F;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-cart-plus me-1"></i> Formulario: Agregar Carrito
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('carritos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_cliente_id" class="form-label small fw-semibold text-muted">Cliente ID</label>
                        <input type="number" name="txt_cliente_id" id="txt_cliente_id" class="form-control rounded-pill" value="1" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_creacion" class="form-label small fw-semibold text-muted">Fecha Creación</label>
                        <input type="date" name="txt_fecha_creacion" id="txt_fecha_creacion" class="form-control rounded-pill" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="txt_estado" class="form-label small fw-semibold text-muted">Estado del Carrito</label>
                        <select name="txt_estado" id="txt_estado" class="form-select rounded-pill">
                            <option value="En Proceso" selected>En Proceso (No Confirmado)</option>
                            <option value="Confirmado">Confirmado (Convertido a Pedido)</option>
                            <option value="Abandonado">Abandonado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-wine w-100 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Guardar Carrito
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Carrito ID</th>
                        <th>Cliente ID</th>
                        <th>Fecha Creación</th>
                        <th>Estado de Confirmación</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($datos)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                No hay carritos registrados en la base de datos aún.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($datos as $fila): ?>
                        <tr>
                            <td class="ps-4 fw-bold" style="color: #6B1D2F;">#<?= $fila['carrito_id'] ?></td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3">
                                    Cliente #<?= $fila['cliente_id'] ?>
                                </span>
                            </td>
                            <td class="text-muted small">
                                <?= $fila['fecha_creacion'] ?>
                            </td>
                            <td>
                                <?php
                                    $est = $fila['estado'] ?? 'En Proceso';
                                    $badgeClass = match($est) {
                                        'Confirmado' => 'bg-success text-white',
                                        'En Proceso' => 'bg-warning text-dark',
                                        'Abandonado' => 'bg-danger text-white',
                                        default => 'bg-secondary text-white'
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1">
                                    <?= esc($est) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?= base_url('carritos/buscar/') . $fila['carrito_id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil me-1"></i> Modificar
                                </a>
                                <a href="<?= base_url('carritos/eliminar/') . $fila['carrito_id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('¿Eliminar carrito?');">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

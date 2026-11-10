<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 my-3">
    <div>
        <h2 class="fw-bold mb-1" style="color: #6B1D2F;"><i class="bi bi-receipt me-2"></i>Gestión de Pedidos</h2>
        <p class="text-muted small mb-0">Control de órdenes entrantes de clientes, estados de entrega y montos totales.</p>
    </div>
    <button type="button" class="btn btn-wine rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalpedidos">
        <i class="bi bi-plus-circle me-1"></i> Formulario: Nuevo Pedido
    </button>
</div>

<!-- Modal Formulario: Nuevo Pedido -->
<div class="modal fade" id="modalpedidos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white rounded-top-4" style="background-color: #6B1D2F;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-receipt me-1"></i> Formulario: Agregar Pedido
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('pedidos/insertar'); ?>" class="form" method="post">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_cliente_id" class="form-label small fw-semibold text-muted">Cliente ID</label>
                            <input type="number" name="txt_cliente_id" id="txt_cliente_id" class="form-control rounded-pill" value="1" required>
                        </div>
                        <div class="col-6">
                            <label for="txt_empleado_id" class="form-label small fw-semibold text-muted">Empleado ID</label>
                            <input type="number" name="txt_empleado_id" id="txt_empleado_id" class="form-control rounded-pill" value="1" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_fecha_pedido" class="form-label small fw-semibold text-muted">Fecha Pedido</label>
                            <input type="date" name="txt_fecha_pedido" id="txt_fecha_pedido" class="form-control rounded-pill" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="txt_total" class="form-label small fw-semibold text-muted">Total (Q)</label>
                            <input type="number" step="0.01" name="txt_total" id="txt_total" class="form-control rounded-pill" placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_estado" class="form-label small fw-semibold text-muted">Estado</label>
                            <select name="txt_estado" id="txt_estado" class="form-select rounded-pill">
                                <option value="En Preparación" selected>En Preparación</option>
                                <option value="En Tránsito">En Tránsito</option>
                                <option value="Entregado">Entregado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="txt_nit" class="form-label small fw-semibold text-muted">NIT</label>
                            <input type="text" name="txt_nit" id="txt_nit" class="form-control rounded-pill" value="C/F" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-4">
                        <div class="col-6">
                            <label for="txt_metodo_pago" class="form-label small fw-semibold text-muted">Método Pago</label>
                            <select name="txt_metodo_pago" id="txt_metodo_pago" class="form-select rounded-pill">
                                <option value="Pago Contra Entrega">Pago Contra Entrega</option>
                                <option value="Transferencia">Transferencia</option>
                                <option value="Tarjeta">Tarjeta</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="txt_tipo_entrega" class="form-label small fw-semibold text-muted">Tipo Entrega</label>
                            <select name="txt_tipo_entrega" id="txt_tipo_entrega" class="form-select rounded-pill">
                                <option value="Recoger en Tienda">Recoger en Tienda</option>
                                <option value="Entrega a Domicilio">Entrega a Domicilio</option>
                                <option value="Envío Departamental">Envío Departamental</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-wine w-100 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Guardar Pedido
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
                        <th class="ps-4">No. Pedido</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Tipo Entrega</th>
                        <th>Método Pago</th>
                        <th>Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($datos)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-3 d-block mb-1"></i>
                                No hay pedidos registrados en la base de datos aún.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($datos as $fila): ?>
                        <tr>
                            <td class="ps-4 fw-bold" style="color: #6B1D2F;">
                                PED-<?= date('Y', strtotime($fila['fecha_pedido'])) ?>-<?= str_pad((string)$fila['carrito_id'], 3, '0', STR_PAD_LEFT) ?>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3">
                                    Cliente #<?= $fila['cliente_id'] ?>
                                </span>
                            </td>
                            <td class="text-muted small">
                                <?= $fila['fecha_pedido'] ?>
                            </td>
                            <td class="fw-bold text-dark">
                                Q <?= number_format((float)$fila['total'], 2) ?>
                            </td>
                            <td>
                                <span class="small fw-semibold"><?= esc($fila['tipo_entrega']) ?></span>
                            </td>
                            <td class="small text-muted">
                                <?= esc($fila['metodo_pago']) ?>
                            </td>
                            <td>
                                <?php
                                    $est = $fila['estado'] ?? 'En Preparación';
                                    $badgeClass = match($est) {
                                        'Entregado' => 'bg-success text-white',
                                        'En Tránsito' => 'bg-primary text-white',
                                        'Cancelado' => 'bg-danger text-white',
                                        default => 'bg-warning text-dark'
                                    };
                                ?>
                                <span class="badge <?= $badgeClass ?> rounded-pill px-3 py-1">
                                    <?= esc($est) ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="<?= base_url('pedidos/buscar/') . $fila['carrito_id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                    <i class="bi bi-pencil me-1"></i> Modificar
                                </a>
                                <a href="<?= base_url('pedidos/eliminar/') . $fila['carrito_id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('¿Eliminar pedido?');">
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

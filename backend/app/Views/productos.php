<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 my-3">
    <div>
        <h2 class="fw-bold mb-1" style="color: #6B1D2F;"><i class="bi bi-box-seam me-2"></i>Gestión de Productos</h2>
        <p class="text-muted small mb-0">Módulo de Empleados para modificar datos y registrar nuevos productos mediante formulario.</p>
    </div>
    <button type="button" class="btn btn-wine rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalproductos">
        <i class="bi bi-plus-circle me-1"></i> Formulario: Nuevo Producto
    </button>
</div>

<!-- Modal Formulario: Nuevo Producto -->
<div class="modal fade" id="modalproductos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header text-white rounded-top-4" style="background-color: #6B1D2F;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> Formulario: Agregar Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <form action="<?= base_url('productos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_nombre" class="form-label small fw-semibold text-muted">Nombre del Producto</label>
                        <input type="text" name="txt_nombre" id="txt_nombre" class="form-control rounded-pill" placeholder="Ej: Hojas Papel de Azúcar A4" required>
                    </div>

                    <div class="mb-3">
                        <label for="txt_categoria_id" class="form-label small fw-semibold text-muted">Categoría ID (1=Hojas, 2=Tintas, 3=Impresión, 4=Impresoras, 5=Limpieza)</label>
                        <input type="number" name="txt_categoria_id" id="txt_categoria_id" class="form-control rounded-pill" value="1" min="1" max="5" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_precio" class="form-label small fw-semibold text-muted">Precio (Q)</label>
                            <input type="number" step="0.01" name="txt_precio" id="txt_precio" class="form-control rounded-pill" placeholder="0.00" required>
                        </div>
                        <div class="col-6">
                            <label for="txt_stock" class="form-label small fw-semibold text-muted">Stock</label>
                            <input type="number" name="txt_stock" id="txt_stock" class="form-control rounded-pill" placeholder="10" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_disponibilidad" class="form-label small fw-semibold text-muted">Disponibilidad (1=Sí, 0=No)</label>
                            <select name="txt_disponibilidad" id="txt_disponibilidad" class="form-select rounded-pill">
                                <option value="1" selected>1 - En Stock</option>
                                <option value="0">0 - Agotado</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="txt_imagen" class="form-label small fw-semibold text-muted">Ícono / Imagen</label>
                            <select name="txt_imagen" id="txt_imagen" class="form-select rounded-pill">
                                <option value="bi-file-earmark-richtext">Hojas Papel</option>
                                <option value="bi-droplet-half">Tintas</option>
                                <option value="bi-camera">Impresión Foto</option>
                                <option value="bi-printer">Impresora</option>
                                <option value="bi-circle">Discos Cupcake</option>
                                <option value="bi-wrench-adjustable">Mantenimiento</option>
                                <option value="bi-box-seam" selected>Caja General</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="txt_descripcion" class="form-label small fw-semibold text-muted">Descripción</label>
                        <textarea name="txt_descripcion" id="txt_descripcion" rows="3" class="form-control rounded-3" placeholder="Detalle del producto..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-wine w-100 py-2 rounded-pill shadow-sm">
                        <i class="bi bi-check-circle me-1"></i> Guardar Producto en MySQL
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Productos -->
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Producto</th>
                        <th>Cat ID</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Disponibilidad</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td class="ps-4 fw-bold" style="color: #6B1D2F;">#<?= $fila['productos_id'] ?></td>
                        <td>
                            <strong class="d-block text-dark"><?= esc($fila['nombre']) ?></strong>
                            <small class="text-muted text-truncate d-inline-block" style="max-width: 320px;">
                                <?= esc($fila['descripcion']) ?>
                            </small>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3">
                                Cat #<?= $fila['categoria_id'] ?>
                            </span>
                        </td>
                        <td class="fw-bold text-dark">
                            Q <?= number_format((float)$fila['precio'], 2) ?>
                        </td>
                        <td>
                            <span class="badge <?= (int)$fila['stock'] > 10 ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill px-3">
                                <?= (int)$fila['stock'] ?> uds
                            </span>
                        </td>
                        <td>
                            <?php if ((int)$fila['disponibilidad'] === 1): ?>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                    <i class="bi bi-check-circle me-1"></i> Disponible
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                    <i class="bi bi-x-circle me-1"></i> Agotado
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end pe-4">
                            <a href="<?= base_url('productos/buscar/') . $fila['productos_id']; ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1">
                                <i class="bi bi-pencil me-1"></i> Modificar
                            </a>
                            <a href="<?= base_url('productos/eliminar/') . $fila['productos_id']; ?>" class="btn btn-sm btn-outline-danger rounded-pill px-2" onclick="return confirm('¿Seguro que deseas eliminar este producto?');">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

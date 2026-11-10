<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center my-4">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header text-white rounded-top-4 p-3" style="background-color: #6B1D2F;">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i> Formulario: Modificar Producto
                    </h5>
                    <span class="badge bg-white text-dark rounded-pill">ID #<?= $datos['productos_id'] ?></span>
                </div>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('productos/actualizar'); ?>" class="form" method="post">
                    
                    <div class="mb-3">
                        <label for="txt_codigo" class="form-label small fw-semibold text-muted">Código de Producto (Solo Lectura)</label>
                        <input type="text" name="txt_codigo" id="txt_codigo" class="form-control rounded-pill bg-light" value="<?= $datos['productos_id']; ?>" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="txt_nombre" class="form-label small fw-semibold text-muted">Nombre del Producto</label>
                        <input type="text" name="txt_nombre" id="txt_nombre" class="form-control rounded-pill" value="<?= esc($datos['nombre']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="txt_categoria_id" class="form-label small fw-semibold text-muted">Categoría ID (1=Hojas, 2=Tintas, 3=Impresión, 4=Impresoras, 5=Limpieza)</label>
                        <input type="number" name="txt_categoria_id" id="txt_categoria_id" class="form-control rounded-pill" value="<?= $datos['categoria_id']; ?>" min="1" max="5" required>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_precio" class="form-label small fw-semibold text-muted">Precio (Q)</label>
                            <input type="number" step="0.01" name="txt_precio" id="txt_precio" class="form-control rounded-pill" value="<?= (float)$datos['precio']; ?>" required>
                        </div>
                        <div class="col-6">
                            <label for="txt_stock" class="form-label small fw-semibold text-muted">Stock</label>
                            <input type="number" name="txt_stock" id="txt_stock" class="form-control rounded-pill" value="<?= (int)$datos['stock']; ?>" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label for="txt_disponibilidad" class="form-label small fw-semibold text-muted">Disponibilidad</label>
                            <select name="txt_disponibilidad" id="txt_disponibilidad" class="form-select rounded-pill">
                                <option value="1" <?= (int)$datos['disponibilidad'] === 1 ? 'selected' : '' ?>>1 - En Stock</option>
                                <option value="0" <?= (int)$datos['disponibilidad'] === 0 ? 'selected' : '' ?>>0 - Agotado</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="txt_imagen" class="form-label small fw-semibold text-muted">Ícono / Imagen</label>
                            <select name="txt_imagen" id="txt_imagen" class="form-select rounded-pill">
                                <option value="bi-file-earmark-richtext" <?= $datos['imagen'] === 'bi-file-earmark-richtext' ? 'selected' : '' ?>>Hojas Papel</option>
                                <option value="bi-droplet-half" <?= $datos['imagen'] === 'bi-droplet-half' ? 'selected' : '' ?>>Tintas</option>
                                <option value="bi-camera" <?= $datos['imagen'] === 'bi-camera' ? 'selected' : '' ?>>Impresión Foto</option>
                                <option value="bi-printer" <?= $datos['imagen'] === 'bi-printer' ? 'selected' : '' ?>>Impresora</option>
                                <option value="bi-circle" <?= $datos['imagen'] === 'bi-circle' ? 'selected' : '' ?>>Discos Cupcake</option>
                                <option value="bi-wrench-adjustable" <?= $datos['imagen'] === 'bi-wrench-adjustable' ? 'selected' : '' ?>>Mantenimiento</option>
                                <option value="bi-box-seam" <?= $datos['imagen'] === 'bi-box-seam' ? 'selected' : '' ?>>Caja General</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="txt_descripcion" class="form-label small fw-semibold text-muted">Descripción</label>
                        <textarea name="txt_descripcion" id="txt_descripcion" rows="3" class="form-control rounded-3" required><?= esc($datos['descripcion']); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?= base_url('productos') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="bi bi-arrow-left me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-wine rounded-pill px-4 shadow-sm">
                            <i class="bi bi-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?php
$paginaActual = 'carrito';
$tituloPagina = 'Mi Carrito de Compras';
require_once "header.php";

$itemsCarrito = Carrito::obtenerItems();
$subtotal = Carrito::obtenerTotal();
$costoEnvio = $subtotal > 0 ? 25.00 : 0.00;
$totalPagar = $subtotal + $costoEnvio;
?>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="content-card">
            <h2 class="card-title-lg mb-1">Tu Carrito de Compras</h2>
            <p class="card-subtitle-muted mb-4">
                Revisa los productos comestibles seleccionados antes de confirmar tu compra
            </p>

            <?php if (empty($itemsCarrito)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-cart-x fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Tu carrito está actualmente vacío</h5>
                    <p class="text-muted small">Agrega hojas de azúcar, tintas comestibles o figuras desde nuestro catálogo.</p>
                    <a href="index.php" class="btn btn-pill-primary mt-3 px-4">
                        <i class="bi bi-grid me-1"></i> Explorar Catálogo
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-end">Precio</th>
                                <th class="text-end">Subtotal</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($itemsCarrito as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="product-image-box bg-rose p-2 rounded text-center" style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center;">
                                                <i class="bi <?= escapar($item['icono'] ?? 'bi-box-seam') ?> text-wine fs-4"></i>
                                            </div>
                                            <div>
                                                <strong class="d-block text-dark"><?= escapar($item['nombre']) ?></strong>
                                                <small class="text-muted">Insumo Comestible</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                                            <?= (int)$item['cantidad'] ?>
                                        </span>
                                    </td>
                                    <td class="text-end fw-semibold text-muted">
                                        Q <?= number_format((float)$item['precio'], 2) ?>
                                    </td>
                                    <td class="text-end fw-bold text-wine">
                                        Q <?= number_format((float)$item['subtotal'], 2) ?>
                                    </td>
                                    <td class="text-center">
                                        <form action="objetos/eliminarCarrito.php" method="post" class="d-inline">
                                            <input type="hidden" name="producto_id" value="<?= $item['id'] ?>">
                                            <button type="submit" class="btn btn-sm btn-outline-danger border-0" title="Eliminar">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                    <a href="index.php" class="btn btn-pill-outline">
                        <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <div class="col-lg-4">
        <div class="summary-card">
            <h3 class="summary-heading mb-3">Resumen de Compra</h3>

            <div class="summary-row d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Subtotal de Productos:</span>
                <span class="fw-bold">Q <?= number_format($subtotal, 2) ?></span>
            </div>

            <div class="summary-row d-flex justify-content-between py-2 border-bottom">
                <span class="text-muted">Envío Estimado:</span>
                <span class="fw-bold text-wine" id="lblEnvio">Q <?= number_format($costoEnvio, 2) ?></span>
            </div>

            <div class="summary-row total-row d-flex justify-content-between py-3 mb-4">
                <span class="fw-bold fs-5">Total a Pagar:</span>
                <span class="total-amount fs-4 fw-bold text-wine" id="lblTotal">Q <?= number_format($totalPagar, 2) ?></span>
            </div>

            <?php if (!empty($itemsCarrito)): ?>
                <form action="objetos/crearPedido.php" method="post" class="border-top pt-3">
                    <h5 class="fw-bold text-wine mb-3"><i class="bi bi-person-lines-fill me-1"></i> Datos para tu Pedido</h5>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Nombre Completo</label>
                        <input type="text" name="cliente" class="form-control form-control-sm rounded-pill" value="<?= escapar($_SESSION['nombre'] ?? 'Nohelia Barillas') ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Teléfono / WhatsApp</label>
                        <input type="text" name="telefono" class="form-control form-control-sm rounded-pill" placeholder="Ej: 5544-3322" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Tipo de Entrega</label>
                        <select name="tipo_entrega" id="selectTipoEntrega" class="form-select form-select-sm rounded-pill" onchange="cambiarTipoEntrega()">
                            <option value="Entrega a Domicilio" selected>Entrega Local en Ciudad (Q 25.00)</option>
                            <option value="Envío Departamental">Envío Nacional por Cargo Expreso (Q 25.00)</option>
                            <option value="Recoger en Tienda">Recoger en Tienda (Gratis - Sin Dirección)</option>
                        </select>
                    </div>

                    <div id="infoRecogerTienda" class="alert alert-info py-2 px-3 small rounded-3 mb-3 d-none">
                        <i class="bi bi-shop me-1 text-primary"></i> <strong>Recoger en Tienda:</strong> No requieres ingresar dirección. Podrás pasar a recoger tu pedido en nuestra sucursal una vez preparado.
                    </div>

                    <div class="mb-3" id="wrapperDireccion">
                        <label class="form-label small fw-semibold text-muted">Dirección de Entrega</label>
                        <input type="text" name="direccion" id="inputDireccion" class="form-control form-control-sm rounded-pill" placeholder="Zona, calle, número de casa..." required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-semibold text-muted">Método de Pago</label>
                        <select name="metodo_pago" class="form-select form-select-sm rounded-pill">
                            <option value="Efectivo contra entrega">Pago Contra Entrega</option>
                            <option value="Transferencia Bancaria">Transferencia Bancaria / Banrural / BI</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-pill-primary w-100 py-2 fs-6 shadow-sm">
                        <i class="bi bi-check2-circle me-1"></i> Confirmar y Registrar Pedido
                    </button>
                </form>
            <?php else: ?>
                <div class="alert alert-light border small text-center">
                    Agrega productos al carrito para habilitar el formulario de pedido.
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<script>
function cambiarTipoEntrega() {
    var select = document.getElementById('selectTipoEntrega');
    var wrapper = document.getElementById('wrapperDireccion');
    var input = document.getElementById('inputDireccion');
    var info = document.getElementById('infoRecogerTienda');
    var lblEnvio = document.getElementById('lblEnvio');
    var lblTotal = document.getElementById('lblTotal');
    var subtotal = <?= (float)$subtotal ?>;

    if (!select) return;

    if (select.value === 'Recoger en Tienda') {
        if (wrapper) wrapper.classList.add('d-none');
        if (input) {
            input.removeAttribute('required');
            input.value = '';
        }
        if (info) info.classList.remove('d-none');

        if (lblEnvio) lblEnvio.textContent = 'Gratis (Q 0.00)';
        if (lblTotal) lblTotal.textContent = 'Q ' + subtotal.toFixed(2);
    } else {
        if (wrapper) wrapper.classList.remove('d-none');
        if (input) input.setAttribute('required', 'required');
        if (info) info.classList.add('d-none');

        var envio = 25.00;
        if (lblEnvio) lblEnvio.textContent = 'Q ' + envio.toFixed(2);
        if (lblTotal) lblTotal.textContent = 'Q ' + (subtotal + envio).toFixed(2);
    }
}

document.addEventListener('DOMContentLoaded', cambiarTipoEntrega);
</script>

<?php require_once "footer.php"; ?>

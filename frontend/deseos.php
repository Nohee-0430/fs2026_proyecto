<?php
$paginaActual = 'deseos';
$tituloPagina = 'Mi Lista de Deseos';
require_once "header.php";
require_once "clases/Productos.php";

$idsDeseos = Deseos::obtenerIds();
$todosProductos = Productos::obtenerProductos($conexionMongo);

$productosDeseados = array_filter($todosProductos, function($p) use ($idsDeseos) {
    return in_array((int)$p['id'], $idsDeseos);
});
?>

<div class="row g-4">
    <div class="col-12">
        <div class="content-card">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                <div>
                    <h2 class="card-title-lg mb-1">Tu Lista de Deseos</h2>
                    <p class="card-subtitle-muted mb-0">
                        Guarda aquí los insumos, tintas o equipos que te interesan para comprarlos más adelante
                    </p>
                </div>
                <a href="index.php" class="btn btn-pill-outline btn-sm">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Catálogo
                </a>
            </div>

            <?php if (empty($productosDeseados)): ?>
                <div class="text-center py-5">
                    <i class="bi bi-heart fs-1 text-muted opacity-50 mb-3 d-block"></i>
                    <h5 class="fw-bold text-dark">Aún no has agregado productos a tu lista de deseos</h5>
                    <p class="text-muted small">Haz clic en el ícono de corazón de cualquier producto en el catálogo para guardarlo aquí.</p>
                    <a href="index.php" class="btn btn-pill-primary mt-2 px-4">
                        <i class="bi bi-grid me-1"></i> Explorar Catálogo
                    </a>
                </div>
            <?php else: ?>
                <div class="catalog-products-grid">
                    <?php foreach ($productosDeseados as $p): ?>
                        <div class="product-card">
                            <div class="product-card-top">
                                <span class="product-badge-tag <?= escapar($p['tag_class'] ?? 'badge-tag-popular') ?>">
                                    <?= escapar($p['tag'] ?? 'Deseo') ?>
                                </span>

                                <form action="objetos/toggleDeseo.php" method="post" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <button type="submit" class="product-fav-btn active" title="Quitar de deseos">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                </form>

                                <div class="product-image-box bg-rose">
                                    <i class="bi <?= escapar($p['icono'] ?? 'bi-file-earmark-richtext') ?> product-placeholder-icon"></i>
                                    <h4 class="product-placeholder-title"><?= escapar($p['nombre']) ?></h4>
                                </div>
                            </div>

                            <div class="product-info-body">
                                <h5 class="product-name" title="<?= escapar($p['nombre']) ?>"><?= escapar($p['nombre']) ?></h5>
                                <p class="product-desc"><?= escapar($p['descripcion']) ?></p>
                                <div class="product-price">Q <?= number_format((float)$p['precio'], 2) ?></div>
                                
                                <form action="objetos/agregarCarrito.php" method="post" class="mt-2">
                                    <input type="hidden" name="producto_id" value="<?= $p['id'] ?>">
                                    <input type="hidden" name="cantidad" value="1">
                                    <input type="hidden" name="ir_a_carrito" value="1">
                                    <button type="submit" class="btn-add-cart w-100">
                                        <i class="bi bi-cart-plus me-1"></i> Mover al Carrito
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>

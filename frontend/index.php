<?php
$paginaActual = 'catalogo';
$tituloPagina = 'Catálogo de Insumos';
require_once "header.php";
require_once "clases/Productos.php";

$listaProductos = Productos::obtenerProductos($conexionMongo);
?>

<div class="row g-4">
    <!-- Sidebar Izquierdo: Categorías y Filtros -->
    <aside class="col-lg-3 col-xl-2">
        <div class="sidebar-card">
            <h3 class="sidebar-heading">Categorías</h3>
            <ul class="sidebar-categories-list">
                <li>
                    <span class="category-link-item active" onclick="filtrarCategoria('all', this)">
                        Todas las Categorías
                    </span>
                </li>
                <li>
                    <span class="category-link-item" onclick="filtrarCategoria('Hojas Comestibles', this)">
                        Hojas Comestibles
                    </span>
                </li>
                <li>
                    <span class="category-link-item" onclick="filtrarCategoria('Tintas Comestibles', this)">
                        Tintas Comestibles
                    </span>
                </li>
                <li>
                    <span class="category-link-item" onclick="filtrarCategoria('Impresiones Personalizadas', this)">
                        Impresiones Foto
                    </span>
                </li>
                <li>
                    <span class="category-link-item" onclick="filtrarCategoria('Impresoras Adaptadas', this)">
                        Impresoras Adaptadas
                    </span>
                </li>
                <li>
                    <span class="category-link-item" onclick="filtrarCategoria('Soluciones de Limpieza', this)">
                        Soluciones de Limpieza
                    </span>
                </li>
            </ul>

            <!-- Banner Informativo de Servicio de Impresión -->            <div class="print-service-banner mt-4">
                <h5><i class="bi bi-magic text-wine"></i> ¡Servicio de Impresión!</h5>
                <p class="small mb-2">Envíanos tu foto o diseño para personalizar tu pastel o cupcakes.</p>
                <p class="small mb-1"><i class="bi bi-whatsapp text-success me-1"></i> +502 2602-1234</p>
                <p class="small mb-0"><i class="bi bi-envelope me-1"></i> dulceimpresion.gt@gmail.com</p>
            </div>

        </div>
    </aside>

    <div class="col-lg-9 col-xl-10">
        <div class="content-card">
            
            <?php if (isset($_GET['agregado'])): ?>
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center justify-content-between mb-4 rounded-pill px-4" role="alert">
                    <div>
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <span>¡Producto agregado al carrito con éxito!</span>
                    </div>
                    <div>
                        <a href="carrito.php" class="btn btn-sm btn-pill-primary">Ver Carrito</a>
                        <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            <?php endif; ?>

            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                <div>
                    <h2 class="card-title-lg mb-1">Catálogo de Productos para Repostería</h2>
                    <p id="catalogCountText" class="card-subtitle-muted mb-0">
                        Mostrando <?= count($listaProductos) ?> productos comestibles y herramientas para impresiones en alta calidad
                    </p>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-wine-subtle text-wine px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-truck me-1"></i> Envíos a todo el país
                    </span>
                </div>
            </div>

            <div id="catalogGrid" class="catalog-products-grid">
                <?php foreach ($listaProductos as $p): 
                    $esDeseado = Deseos::contiene((int)$p['id']);
                ?>
                    <div class="product-card" 
                         data-category="<?= escapar($p['categoria']) ?>" 
                         data-name="<?= strtolower(escapar($p['nombre'])) ?>">
                        
                        <div class="product-card-top">
                            <span class="product-badge-tag <?= escapar($p['tag_class'] ?? 'badge-tag-popular') ?>">
                                <?= escapar($p['tag'] ?? 'Disponible') ?>
                            </span>

                            <form action="objetos/toggleDeseo.php" method="post" class="d-inline">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button type="submit" class="product-fav-btn <?= $esDeseado ? 'active' : '' ?>" 
                                        title="<?= $esDeseado ? 'Quitar de lista de deseos' : 'Guardar en lista de deseos' ?>">
                                    <i class="bi <?= $esDeseado ? 'bi-heart-fill' : 'bi-heart' ?>"></i>
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
                                <button type="submit" class="btn-add-cart w-100">
                                    <i class="bi bi-cart-plus me-1"></i> + Agregar al Carrito
                                </button>
                            </form>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>

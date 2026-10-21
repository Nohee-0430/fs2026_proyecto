<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulce Impresión | Insumos & Papel Comestible</title>
    
    <!-- Bootstrap 5 CSS local -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Google Fonts & Bootstrap Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Quicksand:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Estilos personalizados Dulce Impresión -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- ====================================================================
            HEADER & BARRA DE NAVEGACIÓN SUPERIOR
            ==================================================================== -->
    <header class="header-wrapper">
        <div class="container-fluid px-3 px-lg-4 py-2">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                
                <!-- Logo & Marca -->
                <div class="brand-container cursor-pointer" onclick="switchView('catalogo')">
                    <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión Logo" class="brand-logo-img">
                    <div>
                        <h1 class="brand-title">DULCE IMPRESIÓN</h1>
                        <p class="brand-subtitle">Tienda de Impresiones & Papel Comestible </p>
                    </div>
                </div>

                <!-- Pestañas de Navegación Centrales (Desktop) -->
                <nav class="d-none d-lg-block">
                    <ul class="nav-pills-custom">
                        <li>
                            <button id="tab-catalogo" class="nav-link-tab active" onclick="switchView('catalogo')">
                                Catálogo
                            </button>
                        </li>
                        <li>
                            <button id="tab-carrito" class="nav-link-tab" onclick="switchView('carrito')">
                                Mi Carrito <span id="tabCartCount" class="tab-badge"></span>
                            </button>
                        </li>
                        <li>
                            <button id="tab-deseos" class="nav-link-tab" onclick="switchView('deseos')">
                                Lista de Deseos <span id="tabWishCount" class="tab-badge"></span>
                            </button>
                        </li>
                        <li>
                            <button id="tab-pedido" class="nav-link-tab" onclick="switchView('pedido')">
                                Estado de Pedido
                            </button>
                        </li>
                    </ul>
                </nav>

                <!-- Buscador y Perfil de Usuario -->
                <div class="d-flex align-items-center gap-3">
                    <!-- Buscador -->
                    <div class="search-input-wrapper d-none d-md-block">
                        <i class="bi bi-search search-icon"></i>
                        <input type="text" id="globalSearchInput" class="search-input-custom" 
                                placeholder="Buscar papel de azúcar, figuras recortadas...">
                    </div>

                    <!-- Botón de Perfil / Carrito Total -->
                    <div class="user-account-badge" data-bs-toggle="offcanvas" data-bs-target="#userProfileOffcanvas">
                        <i class="bi bi-person-circle fs-6 text-wine"></i>
                        <span class="account-name">Nohelia Barillas</span>
                        <span class="account-separator">|</span>
                        <span id="headerUserTotal" class="account-total">Q 190.00</span>
                    </div>

                    <!-- Botón Hamburguesa para Móviles -->
                    <button class="btn btn-sm d-lg-none border-0" type="button" 
                            data-bs-toggle="offcanvas" data-bs-target="#mobileMenuOffcanvas">
                        <i class="bi bi-list fs-2 text-dark"></i>
                    </button>
                </div>

            </div>

            <!-- Buscador para pantallas móviles -->
            <div class="d-md-none mt-2">
                <div class="search-input-wrapper w-100">
                    <i class="bi bi-search search-icon"></i>
                    <input type="text" class="search-input-custom" 
                           placeholder="Buscar papel de azúcar, tintas..." 
                           oninput="handleSearch(this.value)">
                </div>
            </div>
        </div>
    </header>

    <!-- ====================================================================
         CONTENIDO PRINCIPAL: VISTAS INTERACTIVAS
         ==================================================================== -->
    <main class="main-wrapper">
        <div class="container-fluid px-3 px-lg-4">

            <!-- ------------------------------------------------------------
                 VISTA 1: CATÁLOGO DE PRODUCTOS (#catalogo)
                 ------------------------------------------------------------ -->
            <section id="view-catalogo" class="app-view active-view">
                <div class="row g-4">
                    
                    <!-- Sidebar Izquierdo: Categorías y Filtros -->
                    <aside class="col-lg-3 col-xl-2">
                        <div class="sidebar-card">
                            <h3 class="sidebar-heading">Categorías</h3>
                            <ul class="sidebar-categories-list">
                                <li>
                                    <span class="category-link-item active" onclick="setCategory('all', this)">
                                        Todas las Categorías
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="setCategory(1, this)">
                                        Hojas Comestibles (Azúcar/Arroz)
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="setCategory(2, this)">
                                        Kit Tintas Comestibles CMYK
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="setCategory(3, this)">
                                        Impresiones Personalizadas
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="setCategory(4, this)">
                                        Impresoras Adaptadas
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="setCategory(5, this)">
                                        Limpieza y Accesorios
                                    </span>
                                </li>
                            </ul>

                            <!-- Filtro de Precio -->
                            <div class="price-slider-wrapper">
                                <h4 class="sidebar-heading">Filtrar por Precio</h4>
                                <input type="range" class="price-range-input" id="priceRangeInput" 
                                       min="35" max="1850" step="10" value="1850" 
                                       oninput="handlePriceFilter(this.value)">
                                <div id="priceRangeLabel" class="price-range-label">
                                    Rango: Q 35.00 — Q 1,850.00
                                </div>
                            </div>

                            <!-- Filtro de Disponibilidad -->
                            <div class="availability-options">
                                <h4 class="sidebar-heading">Disponibilidad</h4>
                                <label class="custom-checkbox-label">
                                    <input type="checkbox" id="chkInStock" checked onchange="handleStockFilter(this)">
                                    <span>En Stock Disponible</span>
                                </label>
                                <label class="custom-checkbox-label">
                                    <input type="checkbox" id="chkImmediate" onchange="handleImmediateFilter(this)">
                                    <span>Entrega Inmediata</span>
                                </label>
                            </div>

                            <!-- Banner Servicio de Impresión -->
                            <div class="print-service-banner">
                                <h5><i class="bi bi-magic text-wine"></i> ¡Servicio de Impresión!</h5>
                                <p>Envíanos tu foto o diseño y te la entregamos lista en papel de azúcar para pastel.</p>
                                <button class="btn-upload-photo" data-bs-toggle="modal" data-bs-target="#uploadPhotoModal">
                                    <i class="bi bi-cloud-arrow-up-fill"></i> Subir Imagen Foto
                                </button>
                            </div>

                        </div>
                    </aside>

                    <!-- Columna Derecha: Catálogo y Grid de Productos -->
                    <div class="col-lg-9 col-xl-10">
                        <div class="content-card">
                            <h2 class="card-title-lg">Catálogo de Productos para Repostería</h2>
                            <p id="catalogCountText" class="card-subtitle-muted">
                                Mostrando 8 productos comestibles y herramientas para impresiones en alta calidad
                            </p>

                            <!-- Grid Dinámico de Productos -->
                            <div id="catalogGrid" class="catalog-products-grid">
                                <!-- Generado por app.js -->
                            </div>
                        </div>
                    </div>

                </div>
            </section>

            <!-- ------------------------------------------------------------
                 VISTA 2: CARRITO DE COMPRAS (#carrito)
                 ------------------------------------------------------------ -->
            <section id="view-carrito" class="app-view">
                <div class="row g-4">
                    
                    <!-- Columna Izquierda: Tabla del Carrito -->
                    <div class="col-lg-8">
                        <div class="content-card">
                            <h2 class="card-title-lg">Tu Carrito de Compras</h2>
                            <p class="card-subtitle-muted">
                                Revisa los productos comestibles seleccionados antes de confirmar la compra
                            </p>

                            <!-- Encabezado de la tabla -->
                            <div class="table-custom-container">
                                <div class="table-custom-header">
                                    <div class="col-cart-product">Producto Comestible</div>
                                    <div class="col-cart-qty text-center">Cantidad</div>
                                    <div class="col-cart-price">Precio Unitario</div>
                                    <div class="col-cart-subtotal">Subtotal</div>
                                </div>

                                <!-- Filas dinámicas del carrito -->
                                <div id="cartItemsList">
                                    <!-- Renderizado por app.js -->
                                </div>
                            </div>

                            <!-- Botón Continuar Comprando -->
                            <div class="mt-4 pt-2">
                                <button class="btn-pill-outline" onclick="switchView('catalogo')">
                                    <i class="bi bi-arrow-left me-1"></i> Continuar Comprando
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Columna Derecha: Resumen de Compra -->
                    <div class="col-lg-4">
                        <div class="summary-card">
                            <h3 class="summary-heading">Resumen de Compra</h3>

                            <div class="summary-row">
                                <span class="text-muted">Subtotal de Productos:</span>
                                <span id="summarySubtotal" class="fw-bold">Q 180.00</span>
                            </div>

                            <div class="summary-row">
                                <span class="text-muted">Envío Estimado (Local):</span>
                                <span id="summaryShipping" class="fw-bold">Q 25.00</span>
                            </div>

                            <div class="summary-row">
                                <span class="text-muted">Descuento Cupón:</span>
                                <span id="summaryDiscount" class="coupon-discount-text">- Q 15.00</span>
                            </div>

                            <div class="summary-row total-row">
                                <span>Total General:</span>
                                <span id="summaryTotal" class="total-amount">Q 190.00</span>
                            </div>

                            <!-- Código de Descuento -->
                            <div class="coupon-section">
                                <label for="couponInput">¿Tienes un Código de Descuento?</label>
                                <div class="coupon-input-group">
                                    <input type="text" id="couponInput" class="coupon-input" value="DULCE2026">
                                    <button class="btn-apply-coupon" onclick="applyCoupon()">Aplicar</button>
                                </div>
                            </div>

                            <!-- Dirección de Entrega -->
                            <div class="mb-3">
                                <label class="sidebar-heading fs-6 mb-2">Dirección de Entrega:</label>
                                <div class="delivery-address-card">
                                    <div class="delivery-client-name">
                                        <i class="bi bi-geo-alt-fill text-wine"></i>
                                        <span>Nohelia Mishelle Barillas</span>
                                    </div>
                                    <div class="delivery-address-text">5ta Calle 12-45 Zona 10, Guatemala</div>
                                    <div class="delivery-phone-text">Teléfono: +502 5555-1234</div>
                                </div>
                            </div>

                            <!-- Método de Pago -->
                            <div class="payment-methods-wrapper">
                                <div class="payment-methods-heading">Método de Pago:</div>
                                <label class="payment-radio-option">
                                    <input type="radio" name="paymentMethod" value="transferencia" checked>
                                    <span>Transferencia Bancaria / Depósito</span>
                                </label>
                                <label class="payment-radio-option">
                                    <input type="radio" name="paymentMethod" value="tarjeta">
                                    <span>Tarjeta de Crédito / Débito</span>
                                </label>
                            </div>

                            <!-- Botón Confirmar Compra -->
                            <button class="btn-checkout-confirm" onclick="confirmCheckoutOrder()">
                                Confirmar y Realizar Pedido <i class="bi bi-arrow-right"></i>
                            </button>

                        </div>
                    </div>

                </div>
            </section>

            <!-- ------------------------------------------------------------
                 VISTA 3: LISTA DE DESEOS (#deseos)
                 ------------------------------------------------------------ -->
            <section id="view-deseos" class="app-view">
                <div class="content-card">
                    <h2 id="wishlistCountText" class="card-title-lg">Mi Lista de Deseos (2 productos guardados)</h2>
                    <p class="card-subtitle-muted">
                        Guarda aquí los insumos y papeles comestibles que deseas comprar más adelante
                    </p>

                    <!-- Encabezados de tabla de deseos -->
                    <div class="table-custom-container">
                        <div class="table-custom-header">
                            <div class="col-wishlist-product">Producto Comestible</div>
                            <div class="col-wishlist-price">Precio</div>
                            <div class="col-wishlist-stock">Estado de Stock</div>
                            <div class="col-wishlist-actions text-end pe-3">Acciones</div>
                        </div>

                        <!-- Filas dinámicas de deseos -->
                        <div id="wishlistItemsList">
                            <!-- Renderizado por app.js -->
                        </div>
                    </div>

                    <!-- Banner Informativo de Lista de Deseos -->
                    <div class="tip-banner-card">
                        <div class="tip-banner-content">
                            <h6>
                                <i class="bi bi-lightbulb text-wine"></i>
                                ¿Sabías que puedes compartir tu Lista de Deseos?
                            </h6>
                            <p>Guarda los materiales que utilizas frecuentemente para tus pedidos de repostería y compártelos con tu equipo o clientes.</p>
                        </div>
                        <button class="btn-pill-outline" onclick="copyWishlistLink()">
                            <i class="bi bi-share me-1"></i> Compartir Lista
                        </button>
                    </div>

                </div>
            </section>

            <!-- ------------------------------------------------------------
                 VISTA 4: ESTADO DE PEDIDO / TRACKING (#pedido)
                 ------------------------------------------------------------ -->
            <section id="view-pedido" class="app-view">
                <div class="row g-4">
                    
                    <!-- Sidebar con Seguimiento Rápido y Categorías -->
                    <aside class="col-lg-3 col-xl-2">
                        <div class="sidebar-card">
                            <h3 class="sidebar-heading">Categorías</h3>
                            <ul class="sidebar-categories-list">
                                <li>
                                    <span class="category-link-item active" onclick="switchView('catalogo'); setCategory(1);">
                                        Hojas Comestibles (Azúcar/Arroz)
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="switchView('catalogo'); setCategory(2);">
                                        Kit Tintas Comestibles CMYK
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="switchView('catalogo'); setCategory(3);">
                                        Impresiones Personalizadas
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="switchView('catalogo'); setCategory(4);">
                                        Impresoras Adaptadas
                                    </span>
                                </li>
                                <li>
                                    <span class="category-link-item" onclick="switchView('catalogo'); setCategory(5);">
                                        Soluciones de Limpieza
                                    </span>
                                </li>
                            </ul>

                            <!-- Card de Seguimiento Rápido -->
                            <div class="quick-tracking-card">
                                <h6>Seguimiento Rápido</h6>
                                <p class="small text-muted mb-1">Pedido #PED-2026-04</p>
                                <span class="badge-state">Estado: En Preparación</span>
                                
                                <div class="mini-progress-bar">
                                    <div class="mini-progress-fill"></div>
                                </div>

                                <ul class="quick-tracking-items">
                                    <li>1x Hoja de Azúcar Foto A4</li>
                                    <li>1x Discos Cupcake 5cm (x12)</li>
                                    <li>1x Solución Limpiadora 100ml</li>
                                </ul>

                                <button class="btn-upload-photo" onclick="switchView('pedido')">
                                    Ver Estado Completo
                                </button>
                            </div>
                        </div>
                    </aside>

                    <!-- Detalle del Estado de Pedido y Timeline -->
                    <div class="col-lg-9 col-xl-10">
                        <div class="order-tracking-card">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                <div>
                                    <h2 id="orderStatusTitle" class="card-title-lg mb-1">Estado del Pedido #PED-2026-04</h2>
                                    <p id="orderStatusClient" class="card-subtitle-muted mb-0">
                                        Cliente: Nohelia Barillas | Dirección: Guatemala
                                    </p>
                                </div>
                                <span class="badge-stock bg-lavender text-wine fs-6 px-3 py-2">
                                    <i class="bi bi-clock-history me-1"></i> En Preparación
                                </span>
                            </div>

                            <!-- Stepper / Línea de Progreso de 4 Pasos -->
                            <div class="order-stepper-wrapper">
                                <div id="stepperProgressBar" class="order-stepper-progress"></div>

                                <!-- Paso 1 -->
                                <div class="step-node completed">
                                    <div class="step-circle"><i class="bi bi-check-lg"></i></div>
                                    <div class="step-title">1. Pedido Recibido</div>
                                    <div class="step-desc">Aprobado</div>
                                </div>

                                <!-- Paso 2 -->
                                <div class="step-node active">
                                    <div class="step-circle"><i class="bi bi-printer"></i></div>
                                    <div class="step-title">2. En Impresión</div>
                                    <div class="step-desc">En Proceso</div>
                                </div>

                                <!-- Paso 3 -->
                                <div class="step-node">
                                    <div class="step-circle">3</div>
                                    <div class="step-title">3. Despachado</div>
                                    <div class="step-desc">En Camino</div>
                                </div>

                                <!-- Paso 4 -->
                                <div class="step-node">
                                    <div class="step-circle">4</div>
                                    <div class="step-title">4. Entregado</div>
                                    <div class="step-desc">Pendiente</div>
                                </div>
                            </div>

                            <!-- Detalles de Envío y Mensajería -->
                            <div class="shipping-info-card">
                                <h6>Detalles de Envío y Mensajería</h6>
                                <div class="shipping-detail-item">
                                    <span>Guía de Rastreo:</span>
                                    <strong id="orderTrackingGuide" class="ms-1">GT-EXPRESS-88921</strong>
                                </div>
                                <div class="shipping-detail-item">
                                    <span>Método de Envío:</span>
                                    <span id="orderShippingMethod" class="ms-1">Entrega Local Ciudad de Guatemala</span>
                                </div>
                                <div class="shipping-detail-item highlight">
                                    <span>Fecha Estimada de Entrega:</span>
                                    <span id="orderEstimatedDate" class="ms-1">Hoy a las 3:30 PM</span>
                                </div>
                            </div>

                            <!-- Resumen de Productos del Pedido -->
                            <div class="mt-4">
                                <h3 class="sidebar-heading">Productos en este pedido</h3>
                                <div class="table-custom-container">
                                    <div class="table-custom-header">
                                        <div class="col-cart-product">Producto Comestible</div>
                                        <div class="col-cart-qty text-center">Cantidad</div>
                                        <div class="col-cart-price">Precio Unit.</div>
                                        <div class="col-cart-subtotal">Subtotal</div>
                                    </div>

                                    <div class="table-custom-row">
                                        <div class="col-cart-product">
                                            <div class="thumb-box"><i class="bi bi-camera"></i></div>
                                            <div>
                                                <h6 class="item-info-title">Impresión Foto Pastel A4 (Hoja de Azúcar)</h6>
                                                <p class="item-info-desc">Diseño personalizado para pastel temático</p>
                                            </div>
                                        </div>
                                        <div class="col-cart-qty text-center"><span class="qty-number">1</span></div>
                                        <div class="col-cart-price">Q 45.00</div>
                                        <div class="col-cart-subtotal">Q 45.00</div>
                                    </div>

                                    <div class="table-custom-row">
                                        <div class="col-cart-product">
                                            <div class="thumb-box"><i class="bi bi-circle"></i></div>
                                            <div>
                                                <h6 class="item-info-title">Discos Comestibles Cupcakes 5cm (Pack x12)</h6>
                                                <p class="item-info-desc">12 toppers precortados en azúcar</p>
                                            </div>
                                        </div>
                                        <div class="col-cart-qty text-center"><span class="qty-number">2</span></div>
                                        <div class="col-cart-price">Q 35.00</div>
                                        <div class="col-cart-subtotal">Q 70.00</div>
                                    </div>

                                    <div class="table-custom-row">
                                        <div class="col-cart-product">
                                            <div class="thumb-box"><i class="bi bi-wrench-adjustable"></i></div>
                                            <div>
                                                <h6 class="item-info-title">Solución Limpiadora de Cabezales 100ml</h6>
                                                <p class="item-info-desc">Mantenimiento de inyectores grado alimenticio</p>
                                            </div>
                                        </div>
                                        <div class="col-cart-qty text-center"><span class="qty-number">1</span></div>
                                        <div class="col-cart-price">Q 65.00</div>
                                        <div class="col-cart-subtotal">Q 65.00</div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end align-items-center mt-3 pt-3 border-top gap-3">
                                    <span class="fs-6 fw-bold">Total Pagado:</span>
                                    <span class="fs-4 fw-bold text-wine">Q 190.00</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </section>

        </div>
    </main>

    <!-- ====================================================================
         FOOTER
         ==================================================================== -->
    <footer class="footer-wrapper">
        <div class="container text-center">
            <p class="footer-copy">
                <strong>DULCE IMPRESIÓN</strong> &copy; 2026 &mdash; 
                <span class="footer-tag">Tienda de Insumos & Papel Comestible | Repostería Creativa</span>
            </p>
            <p class="small text-muted mt-1 mb-0">
                Insumos 100% de grado alimenticio aprobados para repostería &bull; Impresiones en alta definición para pasteles &bull; Guatemala
            </p>
        </div>
    </footer>

    <!-- ====================================================================
         MODALES Y ELEMENTOS INTERACTIVOS
         ==================================================================== -->

    <!-- Modal 1: Subir Foto para Servicio de Impresión -->
    <div class="modal fade" id="uploadPhotoModal" tabindex="-1" aria-labelledby="uploadPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom">
                    <h5 class="modal-title fw-bold text-wine" id="uploadPhotoModalLabel">
                        <i class="bi bi-printer me-2"></i> Servicio de Impresión Personalizada
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body modal-body-custom">
                    <p class="small text-muted mb-3">
                        Sube tu fotografía, logotipo o diseño para imprimirlo en papel comestible con tintas vegetales certificadas.
                    </p>

                    <!-- Zona Drag & Drop -->
                    <div id="dropzoneUpload" class="dropzone-upload mb-3">
                        <i class="bi bi-cloud-arrow-up fs-1 text-wine opacity-75"></i>
                        <p id="dropzoneText" class="small fw-semibold mt-2 mb-1">
                            Arrastra y suelta tu imagen aquí o haz clic para explorar
                        </p>
                        <span class="badge bg-light text-muted border">Formatos: JPG, PNG, WEBP (Max 10MB)</span>
                        <input type="file" id="printFileInput" class="d-none" accept="image/*" onchange="handleFileSelect(event)">
                        <img id="photoPreview" class="preview-print-img" alt="Vista previa del pastel">
                    </div>

                    <!-- Tipo de Papel Comestible -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-wine">Tipo de Papel Comestible:</label>
                        <select id="customPaperType" class="form-select form-select-sm rounded-pill">
                            <option value="Hoja de Azúcar A4 (Q45.00)" selected>Hoja de Azúcar A4 (Q 45.00) - Máxima Nitidez</option>
                            <option value="Papel de Arroz Oblea A4 (Q35.00)">Papel de Arroz Oblea A4 (Q 35.00) - Económico</option>
                            <option value="Discos Cupcake precortados x12 (Q40.00)">Discos Cupcake precortados x12 (Q 40.00)</option>
                        </select>
                    </div>

                    <!-- Dedicatoria o Texto en el Diseño -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-wine">Dedicatoria o frase a incluir (Opcional):</label>
                        <input type="text" id="customDedication" class="form-control form-control-sm rounded-pill" 
                               placeholder="Ej: ¡Feliz Cumpleaños Valentina!">
                    </div>

                    <!-- Cantidad de hojas -->
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-wine">Cantidad de hojas:</label>
                        <input type="number" id="customQuantity" class="form-control form-control-sm rounded-pill" 
                               value="1" min="1" max="50">
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn-pill-outline" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn-pill-primary" onclick="submitCustomPrint()">
                        <i class="bi bi-cart-plus me-1"></i> Agregar al Carrito
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: Pedido Confirmado con Éxito -->
    <div class="modal fade" id="orderConfirmedModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex p-3 rounded-circle bg-mint text-success">
                        <i class="bi bi-check-circle-fill fs-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-wine mb-2">¡Pedido Confirmado con Éxito!</h4>
                <p class="text-muted small mb-3">
                    Hemos registrado tu orden <strong id="modalConfirmedOrderNumber" class="text-wine">#PED-2026-05</strong>. 
                    Nuestro equipo repostero está preparando tus materiales comestibles.
                </p>
                <div class="p-3 bg-light rounded-3 text-start mb-3 small">
                    <div><strong>Cliente:</strong> Nohelia Mishelle Barillas</div>
                    <div><strong>Entrega:</strong> 5ta Calle 12-45 Zona 10, Guatemala</div>
                    <div><strong>Método:</strong> Transferencia Bancaria (Envía tu comprobante)</div>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn-pill-outline" data-bs-dismiss="modal" onclick="switchView('catalogo')">
                        Seguir Comprando
                    </button>
                    <button type="button" class="btn-pill-primary" data-bs-dismiss="modal" onclick="switchView('pedido')">
                        <i class="bi bi-truck me-1"></i> Rastrear Pedido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Offcanvas Perfil de Usuario -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="userProfileOffcanvas" aria-labelledby="userProfileLabel">
        <div class="offcanvas-header bg-pink-subtle border-bottom">
            <h5 class="offcanvas-title fw-bold text-wine" id="userProfileLabel">
                <i class="bi bi-person-circle me-2"></i> Mi Cuenta de Cliente
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="text-center py-3 border-bottom mb-3">
                <div class="d-inline-flex p-3 rounded-circle bg-pink-soft text-wine fs-2 mb-2">
                    <i class="bi bi-person"></i>
                </div>
                <h5 class="fw-bold mb-0 text-wine">Nohelia Mishelle Barillas</h5>
                <p class="small text-muted">nohelia.barillas@ejemplo.com</p>
                <span class="badge bg-success-subtle text-success border border-success-subtle">Cliente Frecuente</span>
            </div>

            <div class="mb-3">
                <label class="small fw-bold text-muted">DIRECCIÓN PREDETERMINADA</label>
                <p class="small mb-1">5ta Calle 12-45 Zona 10, Edificio Las Flores</p>
                <p class="small text-muted">Ciudad de Guatemala, Guatemala</p>
                <p class="small text-muted"><i class="bi bi-telephone me-1"></i> +502 5555-1234</p>
            </div>

            <div class="mb-4">
                <label class="small fw-bold text-muted">ACCESOS RÁPIDOS</label>
                <div class="d-grid gap-2 mt-2">
                    <button class="btn btn-sm btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('carrito')">
                        <i class="bi bi-cart3 me-2"></i> Ver Mi Carrito
                    </button>
                    <button class="btn btn-sm btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('deseos')">
                        <i class="bi bi-heart me-2"></i> Ver Mi Lista de Deseos
                    </button>
                    <button class="btn btn-sm btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('pedido')">
                        <i class="bi bi-box-seam me-2"></i> Estado de Mis Pedidos
                    </button>
                </div>
            </div>

            <div class="p-3 bg-pink-subtle rounded-3 small">
                <strong class="text-wine"><i class="bi bi-shield-check me-1"></i> Conexión con Backend</strong>
                <p class="mb-0 text-muted mt-1">
                    Esta vista está vinculada a los controladores de CodeIgniter 4: <code>ClientesController</code>, <code>CarritosController</code> y <code>PedidosController</code>.
                </p>
            </div>
        </div>
    </div>

    <!-- Offcanvas Menú Móvil -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenuOffcanvas" aria-labelledby="mobileMenuLabel">
        <div class="offcanvas-header bg-pink-subtle border-bottom">
            <h5 class="offcanvas-title fw-bold text-wine" id="mobileMenuLabel">Dulce Impresión</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="d-grid gap-2">
                <button class="btn btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('catalogo')">
                    <i class="bi bi-grid me-2"></i> Catálogo
                </button>
                <button class="btn btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('carrito')">
                    <i class="bi bi-cart3 me-2"></i> Mi Carrito
                </button>
                <button class="btn btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('deseos')">
                    <i class="bi bi-heart me-2"></i> Lista de Deseos
                </button>
                <button class="btn btn-pill-outline text-start" data-bs-dismiss="offcanvas" onclick="switchView('pedido')">
                    <i class="bi bi-truck me-2"></i> Estado de Pedido
                </button>
            </div>
        </div>
    </div>

    <!-- Contenedor de Toasts de Notificación -->
    <div id="toastAlertContainer" class="toast-container-custom"></div>

    <!-- Scripts: Bootstrap Bundle & Lógica de Dulce Impresión -->
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>

</body>
</html>

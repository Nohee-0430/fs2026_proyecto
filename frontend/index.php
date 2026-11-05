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

                    <!-- Estado: USUARIO AUTENTICADO -->
                    <div id="headerUserLogged" class="user-account-badge" data-bs-toggle="offcanvas" data-bs-target="#userProfileOffcanvas" role="button" title="Ver mi cuenta">
                        <i class="bi bi-person-circle fs-6 text-wine"></i>
                        <span class="account-name" id="headerUserName">Nohelia Barillas</span>
                        <span class="account-separator">|</span>
                        <span id="headerUserTotal" class="account-total">Q 190.00</span>
                    </div>

                    <!-- Estado: USUARIO INVITADO (INICIAR SESIÓN / CREAR CUENTA) -->
                    <div id="headerUserGuest" class="d-none align-items-center gap-2">
                        <button type="button" class="btn-pill-outline btn-sm fw-semibold" onclick="openLoginModal()">
                            <i class="bi bi-box-arrow-in-right me-1 text-wine"></i> Iniciar Sesión
                        </button>
                        <button type="button" class="btn-pill-primary btn-sm fw-semibold d-none d-sm-inline-flex" onclick="openRegisterModal()">
                            <i class="bi bi-person-plus me-1"></i> Crear Cuenta
                        </button>
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
                                <p>Envíanos tu foto o diseño a nuestro WhatsApp o correo electrónico.</p>
                                <p>WhatsApp: +502 2602-1234</p>
                                <p>Correo: dulceimpresión.gt@gmail.com</p>
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

                    
                    <div class="col-lg-4">
                        <div class="summary-card">
                            <h3 class="summary-heading">Resumen de Compra</h3>

                            <div class="summary-row">
                                <span class="text-muted">Subtotal de Productos:</span>
                                <span id="summarySubtotal" class="fw-bold">Q 180.00</span>
                            </div>

                            <div class="summary-row">
                                <span class="text-muted">Envío Estimado:</span>
                                <span id="summaryShipping" class="fw-bold">Q 25.00</span>
                            </div>

                            <div class="summary-row d-none" id="summaryCodFeeRow">
                                <span class="text-danger small"><i class="bi bi-cash-coin me-1"></i>Comisión Contra Entrega (5%):</span>
                                <span id="summaryCodFee" class="fw-bold text-danger">+ Q 0.00</span>
                            </div>

                            <div class="summary-row total-row">
                                <span>Total General:</span>
                                <span id="summaryTotal" class="total-amount">Q 190.00</span>
                            </div>

                            <!-- Selector de Tipo de Entrega y Envío -->
                            <div class="mb-3">
                                <label class="sidebar-heading fs-6 mb-2">
                                    <i class="bi bi-truck text-wine me-1"></i> Tipo de Entrega:
                                </label>
                                <div class="delivery-type-selector mb-2">
                                    
                                    <!-- Opción 1: Mensajería Local a Domicilio -->
                                    <div class="delivery-option-card mb-2 selected" id="cardOptionDomicilio" onclick="selectShippingOption('domicilio')">
                                        <div class="d-flex align-items-start gap-2">
                                            <input type="radio" name="shippingTypeRadio" id="shipDomicilio" value="domicilio" checked class="mt-1">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong class="text-wine small">Mensajería Local (Ciudad)</strong>
                                                    <span class="badge bg-pink-soft text-wine" id="domicilioCostBadge">Q 25.00</span>
                                                </div>
                                                <p class="small text-muted mb-0" style="font-size: 0.74rem;">
                                                    Entrega en el día por mensajero en sectores autorizados.
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Selector de Zona y Alerta de Seguridad -->
                                        <div id="zoneSelectorContainer" class="mt-2 pt-2 border-top">
                                            <label for="deliveryZoneSelect" class="form-label small fw-bold text-wine mb-1" style="font-size: 0.75rem;">
                                                Sector / Zona de Entrega:
                                            </label>
                                            <select id="deliveryZoneSelect" class="form-select form-select-sm rounded-pill" onchange="handleZoneChange()">
                                                <optgroup label="Zonas Centrales (Tarifa Estándar - Q 25.00)">
                                                    <option value="central_z10" data-cost="25" data-safe="true" selected>Zona 10 (Zona Viva / Las Flores) - Q25.00</option>
                                                    <option value="central_z1" data-cost="25" data-safe="true">Zona 1 (Centro Histórico) - Q25.00</option>
                                                    <option value="central_z4" data-cost="25" data-safe="true">Zona 4 (Cuatro Grados Norte) - Q25.00</option>
                                                    <option value="central_z9" data-cost="25" data-safe="true">Zona 9 (Plaza España) - Q25.00</option>
                                                    <option value="central_z13" data-cost="25" data-safe="true">Zona 13 (Aurora / Aeropuerto) - Q25.00</option>
                                                    <option value="central_z14" data-cost="25" data-safe="true">Zona 14 (La Cañada) - Q25.00</option>
                                                    <option value="central_z15" data-cost="25" data-safe="true">Zona 15 (Vista Hermosa) - Q25.00</option>
                                                </optgroup>
                                                <optgroup label="Zonas Intermedias / Municipios (Q 35.00)">
                                                    <option value="inter_z2" data-cost="35" data-safe="true">Zona 2 (Ciudad Nueva / Hipódromo) - Q35.00</option>
                                                    <option value="inter_z5" data-cost="35" data-safe="true">Zona 5 (Jardines de la Asunción) - Q35.00</option>
                                                    <option value="inter_z7" data-cost="35" data-safe="true">Zona 7 (Landívar / Tikal Futura) - Q35.00</option>
                                                    <option value="inter_z11" data-cost="35" data-safe="true">Zona 11 (Mariscal / Miraflores) - Q35.00</option>
                                                    <option value="inter_z12" data-cost="35" data-safe="true">Zona 12 (Reformita / Petapa) - Q35.00</option>
                                                    <option value="inter_z16" data-cost="35" data-safe="true">Zona 16 (San Isidro / Cayalá) - Q35.00</option>
                                                    <option value="inter_mixco" data-cost="35" data-safe="true">Mixco (San Cristóbal / Naranjo) - Q35.00</option>
                                                    <option value="inter_pinula" data-cost="35" data-safe="true">Santa Catarina Pinula - Q35.00</option>
                                                </optgroup>
                                                <optgroup label="Zonas Periféricas (Q 45.00)">
                                                    <option value="peri_villanueva" data-cost="45" data-safe="true">Villa Nueva (Área central) - Q45.00</option>
                                                    <option value="peri_petapa" data-cost="45" data-safe="true">San Miguel Petapa - Q45.00</option>
                                                    <option value="peri_salvador" data-cost="45" data-safe="true">Carretera a El Salvador (hasta Km 18) - Q45.00</option>
                                                    <option value="peri_amatitlan" data-cost="45" data-safe="true">Amatitlán - Q45.00</option>
                                                </optgroup>
                                                <optgroup label="Sectores con Cobertura Restringida (Zonas Rojas)">
                                                    <option value="restr_z6" data-cost="35" data-safe="false">Zona 6 (Áreas rojas / riesgo) - Restringido</option>
                                                    <option value="restr_z18" data-cost="35" data-safe="false">Zona 18 (Paraíso / Limonada / Maya) - Restringido</option>
                                                    <option value="restr_z21" data-cost="35" data-safe="false">Zona 21 (Nimajuyú / Loma Blanca) - Restringido</option>
                                                    <option value="restr_milagro" data-cost="45" data-safe="false">Mixco (El Milagro / La Florida alta) - Restringido</option>
                                                    <option value="restr_bucaro" data-cost="45" data-safe="false">Villa Nueva (El Búcaro / Mezquital) - Restringido</option>
                                                </optgroup>
                                            </select>

                                            <!-- Alerta de Sector Peligroso / Zona Roja -->
                                            <div id="dangerZoneWarning" class="alert alert-warning p-2 mt-2 mb-0 rounded-3 small d-none" style="font-size: 0.72rem;">
                                                <div class="d-flex align-items-start gap-1">
                                                    <i class="bi bi-shield-exclamation text-danger fs-6 flex-shrink-0"></i>
                                                    <div>
                                                        <strong class="text-danger d-block">Cobertura Restringida por Seguridad</strong>
                                                        Por seguridad de los mensajeros, no ingresamos a este sector. Puedes elegir <strong>Envío Departamental (Guatex/Forza)</strong> o <strong>Mandar tu propio Uber/Mensajero</strong> previo depósito.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Opción 2: Pasar a Recoger / Mandar Uber Propio -->
                                    <div class="delivery-option-card mb-2" id="cardOptionTienda" onclick="selectShippingOption('tienda')">
                                        <div class="d-flex align-items-start gap-2">
                                            <input type="radio" name="shippingTypeRadio" id="shipTienda" value="tienda" class="mt-1">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong class="text-wine small">Pasar a Recoger / Mandar Uber Propio</strong>
                                                    <span class="badge bg-success-subtle text-success">Gratis (Q 0.00)</span>
                                                </div>
                                                <p class="small text-muted mb-0" style="font-size: 0.74rem;">
                                                    Pasa al taller en Zona 10 o manda a tu propio conductor de Uber/Indriver.
                                                </p>
                                                <div id="tiendaNotice" class="alert alert-info p-2 mt-2 mb-0 rounded-3 small d-none" style="font-size: 0.72rem;">
                                                    <i class="bi bi-info-circle me-1"></i>
                                                    <strong>Importante:</strong> Si mandas Uber o mensajero propio, debes transferir/depositar previamente el pago de tu pedido para autorizar la entrega.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Opción 3: Envío Departamental (Guatex / Forza) -->
                                    <div class="delivery-option-card" id="cardOptionDepartamental" onclick="selectShippingOption('departamental')">
                                        <div class="d-flex align-items-start gap-2">
                                            <input type="radio" name="shippingTypeRadio" id="shipDepartamental" value="departamental" class="mt-1">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <strong class="text-wine small">Envío Departamental (Guatex / Forza)</strong>
                                                    <span class="badge bg-pink-soft text-wine" id="deptCostBadge">Desde Q 35.00</span>
                                                </div>
                                                <p class="small text-muted mb-0" style="font-size: 0.74rem;">
                                                    Envíos a los 22 departamentos de Guatemala con Guatex o Forza Delivery (1 a 2 días hábiles).
                                                </p>
                                            </div>
                                        </div>

                                        <!-- Sub-panel Departamental -->
                                        <div id="departamentalOptionsContainer" class="mt-2 pt-2 border-top d-none" onclick="event.stopPropagation()">
                                            <!-- Destino -->
                                            <div class="row g-2 mb-2">
                                                <div class="col-6">
                                                    <label for="departamentoSelect" class="form-label small fw-bold text-wine mb-1" style="font-size: 0.72rem;">
                                                        Departamento:
                                                    </label>
                                                    <select id="departamentoSelect" class="form-select form-select-sm rounded-pill" onchange="handleDepartamentoChange()">
                                                        <option value="Quetzaltenango" selected>Quetzaltenango</option>
                                                        <option value="Escuintla">Escuintla</option>
                                                        <option value="Sacatepéquez">Sacatepéquez (Antigua)</option>
                                                        <option value="Chimaltenango">Chimaltenango</option>
                                                        <option value="San Marcos">San Marcos</option>
                                                        <option value="Huehuetenango">Huehuetenango</option>
                                                        <option value="Alta Verapaz">Alta Verapaz (Cobán)</option>
                                                        <option value="Baja Verapaz">Baja Verapaz (Salamá)</option>
                                                        <option value="Petén">Petén (Flores/Santa Elena)</option>
                                                        <option value="Izabal">Izabal (Puerto Barrios)</option>
                                                        <option value="Zacapa">Zacapa</option>
                                                        <option value="Chiquimula">Chiquimula</option>
                                                        <option value="Jalapa">Jalapa</option>
                                                        <option value="Jutiapa">Jutiapa</option>
                                                        <option value="Santa Rosa">Santa Rosa</option>
                                                        <option value="Suchitepéquez">Suchitepéquez (Mazate)</option>
                                                        <option value="Retalhuleu">Retalhuleu</option>
                                                        <option value="Sololá">Sololá (Panajachel)</option>
                                                        <option value="Totonicapán">Totonicapán</option>
                                                        <option value="Quiché">Quiché (Santa Cruz)</option>
                                                        <option value="El Progreso">El Progreso (Guastatoya)</option>
                                                        <option value="Guatemala Departamental">Guatemala (Municipios)</option>
                                                    </select>
                                                </div>
                                                <div class="col-6">
                                                    <label for="municipioInput" class="form-label small fw-bold text-wine mb-1" style="font-size: 0.72rem;">
                                                        Municipio / Caserío:
                                                    </label>
                                                    <input type="text" id="municipioInput" class="form-control form-control-sm rounded-pill" 
                                                           placeholder="Ej: Salcajá / Agencia" oninput="handleMunicipioChange(this.value)">
                                                </div>
                                            </div>

                                            <!-- Modalidades de Envío y Cobro -->
                                            <div class="mb-1">
                                                <span class="small fw-bold text-wine d-block mb-1" style="font-size: 0.72rem;">
                                                    Modalidad y Tarifa de Encomienda:
                                                </span>
                                            </div>

                                            <!-- Sub-opción 1: Guía Prepago Forza -->
                                            <div class="dept-sub-card p-2 rounded-3 bg-white mb-2 selected" id="deptCardForza" onclick="selectDeptMode('forza_prepago')">
                                                <div class="d-flex align-items-start gap-2">
                                                    <input type="radio" name="deptModeRadio" id="radioDeptForza" value="forza_prepago" checked class="mt-1">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <strong class="text-wine small" style="font-size: 0.76rem;">Guía Prepago Forza Express</strong>
                                                            <span class="badge bg-success-subtle text-success">Q 35.00</span>
                                                        </div>
                                                        <p class="small text-muted mb-1" style="font-size: 0.70rem;">
                                                            Tarifa económica preferencial con número de guía oficial rastreable.
                                                        </p>
                                                        <div class="alert alert-info py-1 px-2 m-0 rounded-2" style="font-size: 0.68rem; line-height: 1.2;">
                                                            <i class="bi bi-shield-check text-primary me-1"></i>
                                                            <strong>Requiere Previo Depósito:</strong> Para utilizar guía prepago Forza, se debe depositar el total del pedido + envío previo al despacho.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-opción 2: Pago Contra Entrega COD -->
                                            <div class="dept-sub-card p-2 rounded-3 bg-white mb-2" id="deptCardContraEntrega" onclick="selectDeptMode('contra_entrega')">
                                                <div class="d-flex align-items-start gap-2">
                                                    <input type="radio" name="deptModeRadio" id="radioDeptContraEntrega" value="contra_entrega" class="mt-1">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <strong class="text-wine small" style="font-size: 0.76rem;">Pago Contra Entrega (Guatex / Forza COD)</strong>
                                                            <span class="badge bg-pink-soft text-wine">Q 45.00 + 5% comisión</span>
                                                        </div>
                                                        <p class="small text-muted mb-1" style="font-size: 0.70rem;">
                                                            Pagas en efectivo al mensajero de Guatex o Forza al recibir en tu dirección o agencia.
                                                        </p>
                                                        <div class="alert alert-warning py-1 px-2 m-0 rounded-2 text-dark" style="font-size: 0.68rem; line-height: 1.2;">
                                                            <i class="bi bi-cash-coin text-danger me-1"></i>
                                                            <strong>Comisión de Agencia:</strong> La empresa de transporte cobra una comisión del <strong>5%</strong> por recaudación y retorno del dinero.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sub-opción 3: Flete por Cobrar / Agencia -->
                                            <div class="dept-sub-card p-2 rounded-3 bg-white" id="deptCardPorCobrar" onclick="selectDeptMode('por_cobrar')">
                                                <div class="d-flex align-items-start gap-2">
                                                    <input type="radio" name="deptModeRadio" id="radioDeptPorCobrar" value="por_cobrar" class="mt-1">
                                                    <div class="flex-grow-1">
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <strong class="text-wine small" style="font-size: 0.76rem;">Por Cotizar / Flete por Cobrar en Agencia</strong>
                                                            <span class="badge bg-secondary-subtle text-secondary">Flete en destino</span>
                                                        </div>
                                                        <p class="small text-muted mb-0" style="font-size: 0.70rem;">
                                                            Para aldeas o zonas lejanas. Se verifica el costo en la agencia y tú pagas el costo exacto del flete directamente a Guatex/Forza al recibir.
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- Dirección y Datos de Entrega -->
                            <div class="mb-3">
                                <label class="sidebar-heading fs-6 mb-2">Datos y Dirección de Entrega:</label>
                                <div class="delivery-address-card">
                                    <div class="delivery-client-name">
                                        <i class="bi bi-geo-alt-fill text-wine"></i>
                                        <span id="checkoutClientName">Nohelia Mishelle Barillas</span>
                                    </div>
                                    <div class="delivery-address-text" id="checkoutClientAddress">5ta Calle 12-45 Zona 10, Guatemala</div>
                                    <div class="delivery-phone-text" id="checkoutClientPhone">Teléfono: +502 5555-1234</div>
                                </div>
                                <div class="mt-2">
                                    <input type="text" id="checkoutCustomAddressInput" class="form-control form-control-sm rounded-pill" 
                                            placeholder="Aclaración de dirección, no. de casa o indicaciones..." oninput="handleAddressNotesChange(this.value)">
                                </div>
                            </div>

                            <!-- Método de Pago -->
                            <div class="payment-methods-wrapper">
                                <div class="payment-methods-heading">Método de Pago:</div>
                                <label class="payment-radio-option" id="labelPaymentTransfer">
                                    <input type="radio" name="paymentMethod" id="paymentTransfer" value="transferencia" checked>
                                    <span>Transferencia Bancaria / Depósito</span>
                                </label>
                                <label class="payment-radio-option" id="labelPaymentCash">
                                    <input type="radio" name="paymentMethod" id="paymentCash" value="efectivo">
                                    <span>Efectivo Contra Entrega</span>
                                </label>
                                <div id="paymentMethodNotice" class="alert alert-light p-2 mt-2 mb-0 rounded-3 small border" style="font-size: 0.72rem;">
                                    <i class="bi bi-info-circle text-wine me-1"></i>
                                    <span id="paymentMethodNoticeText">Para confirmar tu pedido por transferencia, te enviaremos nuestra cuenta de ahorro del Banco Banrural.</span>
                                </div>
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

                            <!-- Card de Seguimiento Rápido y Mis Pedidos en Sidebar -->
                            <div class="sidebar-card">
                                <h6 class="sidebar-heading d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="bi bi-truck me-1 text-wine"></i> Tus Pedidos</span>
                                    <span class="badge bg-pink-soft text-wine rounded-pill" id="sidebarOrdersCount">2</span>
                                </h6>
                                <div id="sidebarOrdersContainer" class="d-flex flex-column gap-2">
                                    <!-- Generado dinámicamente por app.js -->
                                </div>
                            </div>
                        </div>
                    </aside>

                    <!-- Detalle del Estado de Pedido y Timeline -->
                    <div class="col-lg-9 col-xl-10">

                        <!-- Selector de Pedidos Múltiples (Multi-Pedido) -->
                        <div class="orders-management-header mb-4" id="ordersSelectorWrapper">
                            <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
                                <div class="d-flex align-items-center gap-2">
                                    <h3 class="card-title-lg mb-0 text-wine">
                                        <i class="bi bi-box-seam me-2"></i> Mis Pedidos
                                    </h3>
                                    <span class="badge bg-pink-soft text-wine border rounded-pill px-3 py-2 fw-bold" id="ordersTotalCountBadge">
                                        2 Pedidos Activos
                                    </span>
                                </div>
                                <span class="small text-muted">Haz clic en un pedido para ver su seguimiento, detalle o cancelarlo:</span>
                            </div>
                            <div id="ordersListTabs" class="d-flex gap-2 flex-wrap">
                                <!-- Renderizado dinámicamente por app.js con tabs para cada pedido -->
                            </div>
                        </div>

                        <!-- Estado Vacío (cuando no hay ningún pedido activo) -->
                        <div class="order-tracking-card text-center py-5 d-none" id="orderEmptyState">
                            <div class="d-inline-flex p-4 rounded-circle bg-pink-subtle text-wine mb-3">
                                <i class="bi bi-bag-x fs-1"></i>
                            </div>
                            <h3 class="fw-bold text-wine mb-2">No tienes pedidos activos</h3>
                            <p class="text-muted small mb-4 mx-auto" style="max-width: 460px;">
                                Actualmente no tienes ningún pedido en proceso ni en seguimiento. Puedes explorar nuestro catálogo y realizar un pedido de insumos o impresiones comestibles cuando lo desees.
                            </p>
                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                <button class="btn-pill-primary px-4 py-2" onclick="switchView('catalogo')">
                                    <i class="bi bi-bag-plus me-1"></i> Explorar Catálogo
                                </button>
                                <button class="btn-pill-outline px-4 py-2" onclick="restoreDemoOrders()">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i> Restaurar Pedidos de Demostración
                                </button>
                            </div>
                        </div>

                        <!-- Tarjeta Principal de Seguimiento -->
                        <div class="order-tracking-card" id="orderTrackingCard">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                <div>
                                    <h2 id="orderStatusTitle" class="card-title-lg mb-1">Estado del Pedido #PED-2026-04</h2>
                                    <p id="orderStatusClient" class="card-subtitle-muted mb-0">
                                        Cliente: Nohelia Barillas | Dirección: Guatemala
                                    </p>
                                </div>
                                <span id="orderStatusBadge" class="badge-stock bg-lavender text-wine fs-6 px-3 py-2">
                                    <i class="bi bi-clock-history me-1"></i> En Preparación
                                </span>
                            </div>

                            <!-- Contenedor dinámico de alertas (ej: aviso de pedido cancelado) -->
                            <div id="orderStatusNotice"></div>

                            <!-- Stepper / Línea de Progreso de 4 Pasos -->
                            <div class="order-stepper-wrapper" id="orderStepperWrapper">
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

                                    <!-- Filas dinámicas de productos según el pedido seleccionado -->
                                    <div id="orderItemsTableBody"></div>
                                </div>

                                <div class="d-flex justify-content-end align-items-center mt-3 pt-3 border-top gap-3">
                                    <span class="fs-6 fw-bold">Total Pagado:</span>
                                    <span class="fs-4 fw-bold text-wine" id="orderTotalPaid">Q 190.00</span>
                                </div>
                            </div>

                            <!-- Barra de Acciones del Pedido -->
                            <div id="orderActionsToolbar" class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top flex-wrap gap-2">
                                <div class="text-muted small">
                                    <i class="bi bi-shield-check text-wine me-1"></i>
                                    <span id="orderActionNote">Gestión del pedido: Puedes cancelar o eliminar este pedido.</span>
                                </div>
                                <div class="d-flex gap-2" id="orderActionButtons">
                                    <button type="button" class="btn btn-sm btn-outline-warning rounded-pill px-3 fw-semibold" id="btnCancelOrder" onclick="openCancelOrderModal()">
                                        <i class="bi bi-x-circle me-1"></i> Cancelar Pedido
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3 fw-semibold" id="btnDeleteOrder" onclick="openDeleteOrderModal()">
                                        <i class="bi bi-trash3 me-1"></i> Eliminar Registro
                                    </button>
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

    <!-- Modal 3: Cancelar Pedido con Motivo Interactivo -->
    <div class="modal fade" id="cancelOrderModal" tabindex="-1" aria-labelledby="cancelOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom border-bottom pb-3">
                    <h5 class="modal-title fw-bold text-wine" id="cancelOrderModalLabel">
                        <i class="bi bi-x-circle text-danger me-2"></i> Cancelar Pedido <span id="cancelModalOrderCode" class="badge bg-pink-subtle text-wine border ms-1">#PED-2026-04</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body modal-body-custom pt-3">
                    <div class="alert alert-warning d-flex align-items-center p-3 rounded-3 small mb-3 border-warning">
                        <i class="bi bi-exclamation-triangle-fill fs-4 text-warning me-2 flex-shrink-0"></i>
                        <div>
                            <strong>¿Seguro que deseas cancelar?</strong> Se detendrá la impresión y preparación de tus insumos comestibles.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="cancelReasonSelect" class="form-label small fw-bold text-wine">
                            Motivo de la cancelación <span class="text-danger">*</span>
                        </label>
                        <select id="cancelReasonSelect" class="form-select form-select-sm rounded-pill" onchange="document.getElementById('cancelReasonValidationMsg').classList.add('d-none')">
                            <option value="" disabled selected>Selecciona un motivo...</option>
                            <option value="Error en medidas, diseño o dedicatoria de la impresión">Error en medidas, diseño o dedicatoria de la impresión</option>
                            <option value="Tiempo de entrega estimado no se ajusta a mi evento">Tiempo de entrega estimado no se ajusta a mi evento</option>
                            <option value="Cambié de opinión o ya no requiero los productos">Cambié de opinión o ya no requiero los productos</option>
                            <option value="Problemas con la transferencia o comprobante de pago">Problemas con la transferencia o comprobante de pago</option>
                            <option value="Pedido duplicado por error">Pedido duplicado por error</option>
                            <option value="Otro motivo">Otro motivo</option>
                        </select>
                        <div id="cancelReasonValidationMsg" class="text-danger small mt-1 d-none">
                            <i class="bi bi-exclamation-circle me-1"></i> Por favor selecciona un motivo para continuar.
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="cancelModalNotes" class="form-label small fw-bold text-wine">
                            Comentarios adicionales (Opcional):
                        </label>
                        <textarea id="cancelModalNotes" class="form-control rounded-3 small" rows="3" placeholder="Explícanos brevemente para que podamos mejorar tu experiencia repostera..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4 d-flex justify-content-end gap-2">
                    <button type="button" class="btn-pill-outline" data-bs-dismiss="modal">
                        Volver / No Cancelar
                    </button>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold" onclick="confirmOrderCancellation()">
                        <i class="bi bi-x-circle me-1"></i> Confirmar Cancelación
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4: Eliminar Pedido Definitivamente -->
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom text-center p-4">
                <div class="mb-3">
                    <div class="d-inline-flex p-3 rounded-circle bg-danger-subtle text-danger">
                        <i class="bi bi-trash3-fill fs-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold text-wine mb-2" id="deleteOrderModalLabel">¿Eliminar Registro de Pedido?</h4>
                <p class="text-muted small mb-3">
                    Estás a punto de eliminar el pedido <strong id="deleteModalOrderCode" class="text-wine">#PED-2026-04</strong> de tu pantalla y seguimiento.
                </p>
                <div class="p-3 bg-light rounded-3 text-start mb-3 small text-muted border">
                    <i class="bi bi-info-circle text-danger me-1"></i>
                    Esta acción removerá el pedido de tu sesión activa. No podrás volver a rastrear este código salvo que crees un nuevo pedido.
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn-pill-outline" data-bs-dismiss="modal">
                        Conservar Pedido
                    </button>
                    <button type="button" class="btn btn-danger btn-sm rounded-pill px-4 fw-bold" onclick="confirmOrderDeletion()">
                        <i class="bi bi-trash3 me-1"></i> Eliminar Definitivamente
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 5: Iniciar Sesión -->
    <div class="modal fade" id="authLoginModal" tabindex="-1" aria-labelledby="authLoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom border-bottom pb-3">
                    <h5 class="modal-title fw-bold text-wine" id="authLoginModalLabel">
                        <i class="bi bi-box-arrow-in-right text-wine me-2"></i> Iniciar Sesión
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body modal-body-custom pt-3">
                    <p class="small text-muted mb-3">
                        Ingresa tus credenciales para acceder a tus pedidos, lista de deseos y comprar más rápido.
                    </p>

                    <!-- Lista de Cuentas Guardadas en este Navegador -->
                    <div id="savedAccountsContainer" class="mb-3"></div>

                    <form id="formLogin" onsubmit="handleLogin(event)">
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label small fw-bold text-wine">Correo Electrónico:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill text-muted">
                                    <i class="bi bi-envelope"></i>
                                </span>
                                <input type="email" id="loginEmail" class="form-control rounded-end-pill border-start-0" 
                                       placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="loginPassword" class="form-label small fw-bold text-wine">Contraseña:</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 rounded-start-pill text-muted">
                                    <i class="bi bi-lock"></i>
                                </span>
                                <input type="password" id="loginPassword" class="form-control rounded-end-pill border-start-0" 
                                       placeholder="••••••••" required>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3 small">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="loginRememberMe" checked>
                                <label class="form-check-label text-muted" for="loginRememberMe">Recordarme</label>
                            </div>
                            <a href="javascript:void(0)" class="text-wine text-decoration-none fw-semibold" onclick="openForgotPasswordModal()">¿Olvidaste tu contraseña?</a>
                        </div>

                        <button type="submit" class="btn-pill-primary w-100 py-2 fs-6 fw-bold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                        </button>
                    </form>

                    <div class="my-3 text-center position-relative">
                        <hr class="text-muted opacity-25">
                        <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 small text-muted">o</span>
                    </div>

                    <button type="button" class="btn btn-sm btn-outline-secondary w-100 rounded-pill py-2 fw-semibold" onclick="loginDemoAccount()">
                        <i class="bi bi-lightning-charge me-1 text-warning"></i> Acceso Rápido como <strong>Nohelia Barillas (Demo)</strong>
                    </button>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4 justify-content-center">
                    <span class="small text-muted">
                        ¿No tienes una cuenta aún? 
                        <a href="javascript:void(0)" class="text-wine fw-bold text-decoration-none ms-1" onclick="switchToRegisterModal()">
                            Crear cuenta gratis
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 6: Crear Nueva Cuenta -->
    <div class="modal fade" id="authRegisterModal" tabindex="-1" aria-labelledby="authRegisterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom border-bottom pb-3">
                    <h5 class="modal-title fw-bold text-wine" id="authRegisterModalLabel">
                        <i class="bi bi-person-plus text-wine me-2"></i> Crear Nueva Cuenta
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body modal-body-custom pt-3">
                    <p class="small text-muted mb-3">
                        Regístrate en <strong>Dulce Impresión</strong> para comprar insumos comestibles, guardar impresiones y gestionar tus pedidos.
                    </p>

                    <form id="formRegister" onsubmit="handleRegister(event)">
                        <div class="mb-2">
                            <label for="registerName" class="form-label small fw-bold text-wine">Nombre Completo <span class="text-danger">*</span>:</label>
                            <input type="text" id="registerName" class="form-control form-control-sm rounded-pill" 
                                   placeholder="Ej: Sofía López" required>
                        </div>

                        <div class="mb-2">
                            <label for="registerEmail" class="form-label small fw-bold text-wine">Correo Electrónico <span class="text-danger">*</span>:</label>
                            <input type="email" id="registerEmail" class="form-control form-control-sm rounded-pill" 
                                   placeholder="sofia@ejemplo.com" required>
                        </div>

                        <div class="row g-2 mb-2">
                            <div class="col-sm-6">
                                <label for="registerPhone" class="form-label small fw-bold text-wine">Teléfono / WhatsApp:</label>
                                <input type="tel" id="registerPhone" class="form-control form-control-sm rounded-pill" 
                                       placeholder="+502 5555-1234">
                            </div>
                            <div class="col-sm-6">
                                <label for="registerAddress" class="form-label small fw-bold text-wine">Dirección de Entrega:</label>
                                <input type="text" id="registerAddress" class="form-control form-control-sm rounded-pill" 
                                       placeholder="Zona 10, Guatemala">
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-sm-6">
                                <label for="registerPassword" class="form-label small fw-bold text-wine">Contraseña <span class="text-danger">*</span>:</label>
                                <input type="password" id="registerPassword" class="form-control form-control-sm rounded-pill" 
                                       placeholder="Mínimo 6 caracteres" minlength="6" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="registerPasswordConfirm" class="form-label small fw-bold text-wine">Confirmar <span class="text-danger">*</span>:</label>
                                <input type="password" id="registerPasswordConfirm" class="form-control form-control-sm rounded-pill" 
                                       placeholder="Repite contraseña" minlength="6" required>
                            </div>
                        </div>

                        <button type="submit" class="btn-pill-primary w-100 py-2 fs-6 fw-bold">
                            <i class="bi bi-person-check me-1"></i> Registrarme y Crear Cuenta
                        </button>
                    </form>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4 justify-content-center">
                    <span class="small text-muted">
                        ¿Ya tienes una cuenta registrada? 
                        <a href="javascript:void(0)" class="text-wine fw-bold text-decoration-none ms-1" onclick="switchToLoginModal()">
                            Inicia sesión aquí
                        </a>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 7: Restablecer Contraseña -->
    <div class="modal fade" id="authForgotPasswordModal" tabindex="-1" aria-labelledby="authForgotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-custom">
                <div class="modal-header modal-header-custom border-bottom pb-3">
                    <h5 class="modal-title fw-bold text-wine" id="authForgotModalLabel">
                        <i class="bi bi-key text-wine me-2"></i> Restablecer Contraseña
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body modal-body-custom pt-3">
                    <!-- Paso 1: Solicitar correo -->
                    <div id="forgotStep1">
                        <p class="small text-muted mb-3">
                            Ingresa el correo electrónico asociado a tu cuenta. Te enviaremos un código de seguridad para crear una nueva contraseña.
                        </p>
                        <form onsubmit="handleSendResetCode(event)">
                            <div class="mb-3">
                                <label for="forgotEmail" class="form-label small fw-bold text-wine">Correo Electrónico:</label>
                                <input type="email" id="forgotEmail" class="form-control rounded-pill" placeholder="ejemplo@correo.com" required>
                            </div>
                            <button type="submit" class="btn-pill-primary w-100 py-2 fs-6 fw-bold">
                                <i class="bi bi-send me-1"></i> Enviar Código de Verificación
                            </button>
                        </form>
                    </div>

                    <!-- Paso 2: Ingresar código y nueva contraseña -->
                    <div id="forgotStep2" class="d-none">
                        <div class="alert alert-success p-2 rounded-3 small mb-3">
                            <i class="bi bi-check-circle me-1"></i>
                            Hemos simulado el envío a <strong id="forgotEmailDisplay">tu correo</strong>.
                            Usa el código temporal: <strong class="badge bg-wine text-white">582419</strong>
                        </div>
                        <form onsubmit="handleSaveNewPassword(event)">
                            <div class="mb-2">
                                <label for="resetVerificationCode" class="form-label small fw-bold text-wine">Código de 6 dígitos:</label>
                                <input type="text" id="resetVerificationCode" class="form-control rounded-pill text-center fw-bold fs-5 letter-spacing-1" 
                                       placeholder="582419" maxlength="6" required>
                            </div>
                            <div class="mb-2">
                                <label for="resetNewPassword" class="form-label small fw-bold text-wine">Nueva Contraseña:</label>
                                <input type="password" id="resetNewPassword" class="form-control form-control-sm rounded-pill" 
                                       placeholder="Mínimo 6 caracteres" minlength="6" required>
                            </div>
                            <div class="mb-3">
                                <label for="resetConfirmPassword" class="form-label small fw-bold text-wine">Confirmar Nueva Contraseña:</label>
                                <input type="password" id="resetConfirmPassword" class="form-control form-control-sm rounded-pill" 
                                       placeholder="Repite la contraseña" minlength="6" required>
                            </div>
                            <button type="submit" class="btn-pill-primary w-100 py-2 fs-6 fw-bold">
                                <i class="bi bi-shield-check me-1"></i> Guardar Nueva Contraseña
                            </button>
                        </form>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 px-4 pb-4 justify-content-center">
                    <span class="small text-muted">
                        ¿Recordaste tu contraseña? 
                        <a href="javascript:void(0)" class="text-wine fw-bold text-decoration-none ms-1" onclick="switchToLoginModal()">
                            Volver a Iniciar Sesión
                        </a>
                    </span>
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
        <div class="offcanvas-body d-flex flex-column">

            <!-- Sección: Usuario con Sesión Activa -->
            <div id="offcanvasUserLoggedSection">
                <div class="text-center py-3 border-bottom mb-3">
                    <div class="d-inline-flex p-3 rounded-circle bg-pink-soft text-wine fs-2 mb-2">
                        <i class="bi bi-person-check-fill"></i>
                    </div>
                    <h5 class="fw-bold mb-0 text-wine" id="profileOffcanvasName">Nohelia Mishelle Barillas</h5>
                    <p class="small text-muted mb-2" id="profileOffcanvasEmail">nohelia.barillas@ejemplo.com</p>
                    <span class="badge bg-success-subtle text-success border border-success-subtle">Cliente Frecuente</span>
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-muted">DIRECCIÓN PREDETERMINADA</label>
                    <p class="small mb-1 text-dark" id="profileOffcanvasAddress">5ta Calle 12-45 Zona 10, Edificio Las Flores</p>
                    <p class="small text-muted mb-0" id="profileOffcanvasPhone"><i class="bi bi-telephone me-1"></i> +502 5555-1234</p>
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

                <!-- Botón Cerrar Sesión -->
                <div class="mb-4">
                    <button type="button" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-semibold" onclick="handleLogout()">
                        <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                    </button>
                </div>
            </div>

            <!-- Sección: Usuario Invitado (Sin Sesión) -->
            <div id="offcanvasUserGuestSection" class="d-none text-center py-4 my-auto">
                <div class="d-inline-flex p-4 rounded-circle bg-pink-soft text-wine fs-1 mb-3">
                    <i class="bi bi-person-x"></i>
                </div>
                <h5 class="fw-bold text-wine mb-2">No has iniciado sesión</h5>
                <p class="small text-muted mb-4 px-2">
                    Inicia sesión o regístrate para acceder a tus pedidos, historial y listas guardadas de insumos comestibles.
                </p>
                <div class="d-grid gap-2 px-3">
                    <button type="button" class="btn-pill-primary py-2 fw-bold" data-bs-dismiss="offcanvas" onclick="openLoginModal()">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                    </button>
                    <button type="button" class="btn-pill-outline py-2 fw-bold" data-bs-dismiss="offcanvas" onclick="openRegisterModal()">
                        <i class="bi bi-person-plus me-2"></i> Crear Nueva Cuenta
                    </button>
                </div>
            </div>

            <div class="p-3 bg-pink-subtle rounded-3 small mt-auto border">
                <strong class="text-wine"><i class="bi bi-shield-check me-1"></i> Conexión con Backend</strong>
                <p class="mb-0 text-muted mt-1">
                    Gestión vinculada a <code>ClientesController</code> y <code>PedidosController</code> en CodeIgniter 4.
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
        <div class="offcanvas-body d-flex flex-column">
            <!-- Info usuario móvil -->
            <div id="mobileUserLoggedSection" class="p-3 bg-light rounded-3 mb-3 border">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-person-circle fs-4 text-wine"></i>
                    <div>
                        <strong class="d-block text-wine small" id="mobileUserName">Nohelia Barillas</strong>
                        <span class="text-muted" style="font-size: 0.72rem;">Sesión Activa</span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-danger w-100 rounded-pill py-1" onclick="handleLogout()">
                    <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                </button>
            </div>

            <div id="mobileUserGuestSection" class="d-none p-3 bg-pink-subtle rounded-3 mb-3 border text-center">
                <p class="small text-wine fw-bold mb-2">¿Tienes una cuenta?</p>
                <div class="d-flex gap-2 justify-content-center">
                    <button type="button" class="btn-pill-primary btn-sm flex-fill" data-bs-dismiss="offcanvas" onclick="openLoginModal()">
                        Iniciar Sesión
                    </button>
                    <button type="button" class="btn-pill-outline btn-sm flex-fill" data-bs-dismiss="offcanvas" onclick="openRegisterModal()">
                        Crear Cuenta
                    </button>
                </div>
            </div>

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
    <script src="js/app.js?v=<?= time() ?>"></script>

</body>
</html>

/**
 * ============================================================================
 * DULCE IMPRESIÓN - Frontend App Logic
 * Gestión interactiva del cliente: Catálogo, Carrito, Lista de Deseos y Pedidos
 * ============================================================================
 */

// Objeto de Servicio para conectar con el backend de CodeIgniter 4 más adelante
const BackendService = {
    // URL base de tu backend CodeIgniter 4
    baseUrl: '../backend/public',

    // Métodos preparados para cuando actives las conexiones:
    async fetchProductos() {
        // Ejemplo de conexión real:
        // const res = await fetch(`${this.baseUrl}/productos`);
        // return await res.json();
        return null; // Retorna null para usar los datos locales por defecto
    },

    async fetchCategorias() {
        // const res = await fetch(`${this.baseUrl}/categorias`);
        // return await res.json();
        return null;
    },

    async guardarCarritoEnServidor(carritoItems) {
        // fetch(`${this.baseUrl}/detalle_carritos/insertar`, { method: 'POST', body: JSON.stringify(carritoItems) })
    },

    async registrarPedido(datosPedido) {
        // fetch(`${this.baseUrl}/pedidos/insertar`, { method: 'POST', body: JSON.stringify(datosPedido) })
    }
};

// ============================================================================
// DATOS MOCK INICIALES (Fieles a los prototipos de la tienda)
// ============================================================================
const INITIAL_PRODUCTS = [
    {
        id: 1,
        categoriaId: 1,
        categoriaNombre: "Hojas Comestibles (Azúcar/Arroz)",
        nombre: "Hojas Papel de Azúcar A4",
        descripcion: "Pack x 24 hojas flexibles con acabado de gran nitidez para repostería",
        precio: 210.00,
        stock: 35,
        disponibilidad: "en_stock",
        tag: "Más Vendido",
        tagClass: "badge-tag-mas-vendido",
        bgClass: "bg-rose",
        placeholder: "Hojas Papel",
        icon: "bi-file-earmark-richtext"
    },
    {
        id: 2,
        categoriaId: 2,
        categoriaNombre: "Kit Tintas Comestibles CMYK",
        nombre: "Kit Tintas Comestibles CMYK",
        descripcion: "4 botellas 100ml c/u (Cian, Magenta, Amarillo, Negro) grado alimenticio",
        precio: 350.00,
        stock: 18,
        disponibilidad: "en_stock",
        tag: "Oferta",
        tagClass: "badge-tag-oferta",
        bgClass: "bg-mint",
        placeholder: "Kit Tintas",
        icon: "bi-droplet-half"
    },
    {
        id: 3,
        categoriaId: 3,
        categoriaNombre: "Impresiones Personalizadas",
        nombre: "Impresión Foto Pastel A4",
        descripcion: "Servicio personalizado con envío de foto en hoja de azúcar de alta resolución",
        precio: 45.00,
        stock: 99,
        disponibilidad: "entrega_inmediata",
        tag: "Servicio",
        tagClass: "badge-tag-servicio",
        bgClass: "bg-lavender",
        placeholder: "Impresión Foto",
        icon: "bi-camera"
    },
    {
        id: 4,
        categoriaId: 1,
        categoriaNombre: "Hojas Comestibles (Azúcar/Arroz)",
        nombre: "Hojas Papel de Arroz A4",
        descripcion: "Pack x 24 obleas comestibles para galletas, merengues y turrón",
        precio: 125.00,
        stock: 24,
        disponibilidad: "en_stock",
        tag: "Insumo Base",
        tagClass: "badge-tag-insumo-base",
        bgClass: "bg-sand",
        placeholder: "Hojas Papel",
        icon: "bi-file-earmark"
    },
    {
        id: 5,
        categoriaId: 3,
        categoriaNombre: "Impresiones Personalizadas",
        nombre: "Discos Cupcake (x12 5cm)",
        descripcion: "12 toppers redondos precortados impresos en azúcar para cupcakes",
        precio: 35.00,
        stock: 50,
        disponibilidad: "entrega_inmediata",
        tag: "Popular",
        tagClass: "badge-tag-popular",
        bgClass: "bg-rose",
        placeholder: "Discos Cupcake",
        icon: "bi-circle"
    },
    {
        id: 6,
        categoriaId: 2,
        categoriaNombre: "Kit Tintas Comestibles CMYK",
        nombre: "Tinta Comestible Negra 100ml",
        descripcion: "Alta densidad para bordes definidos y textos nítidos en pasteles",
        precio: 95.00,
        stock: 40,
        disponibilidad: "en_stock",
        tag: "Stock Alto",
        tagClass: "badge-tag-stock-alto",
        bgClass: "bg-mint",
        placeholder: "Tinta Comestible",
        icon: "bi-paint-bucket"
    },
    {
        id: 7,
        categoriaId: 4,
        categoriaNombre: "Impresoras Adaptadas",
        nombre: "Impresora Canon Adaptada",
        descripcion: "Equipada y lista para uso exclusivo con tintas comestibles alimentarias",
        precio: 1850.00,
        stock: 5,
        disponibilidad: "en_stock",
        tag: "Equipo",
        tagClass: "badge-tag-equipo",
        bgClass: "bg-lavender",
        placeholder: "Impresora Canon",
        icon: "bi-printer"
    },
    {
        id: 8,
        categoriaId: 5,
        categoriaNombre: "Soluciones de Limpieza",
        nombre: "Limpiador Cabezales 100ml",
        descripcion: "Líquido grado alimentario para mantenimiento y destape de inyectores",
        precio: 65.00,
        stock: 15,
        disponibilidad: "en_stock",
        tag: "Mantenimiento",
        tagClass: "badge-tag-mantenimiento",
        bgClass: "bg-sand",
        placeholder: "Limpiador Cabezales",
        icon: "bi-wrench-adjustable"
    }
];

// Estado Inicial de la Aplicación en localStorage
const AppState = {
    products: INITIAL_PRODUCTS,
    activeCategory: 'all',
    searchQuery: '',
    maxPrice: 1850,
    filterInStock: true,
    filterImmediate: false,
    
    // Carrito de compras precargado según Mockup 2
    cart: JSON.parse(localStorage.getItem('dulce_cart')) || [
        { id: 3, qty: 1, customNote: "Servicio personalizado con envío de foto" },
        { id: 5, qty: 2, customNote: "12 toppers redondos precortados en azúcar" },
        { id: 8, qty: 1, customNote: "Mantenimiento grado alimenticio para impresoras" }
    ],

    // Lista de Deseos precargada según Mockup 1
    wishlist: JSON.parse(localStorage.getItem('dulce_wishlist')) || [7, 1],

    // Cupón de descuento aplicado
    coupon: localStorage.getItem('dulce_coupon') || 'DULCE2026',
    discountAmount: 15.00,
    shippingCost: 25.00,

    // Datos del cliente autenticado
    client: {
        id: 1,
        name: "Nohelia Mishelle Barillas",
        shortName: "Nohelia Barillas",
        email: "nohelia.barillas@ejemplo.com",
        address: "5ta Calle 12-45 Zona 10, Guatemala",
        phone: "+502 5555-1234",
        paymentMethod: "transferencia"
    },

    // Pedido activo de seguimiento según Mockup 4
    currentOrder: {
        id: "PED-2026-04",
        status: "En Preparación",
        step: 2, // 1: Recibido, 2: En Impresión, 3: Despachado, 4: Entregado
        trackingGuide: "GT-EXPRESS-88921",
        shippingMethod: "Entrega Local Ciudad de Guatemala",
        estimatedDelivery: "Hoy a las 3:30 PM",
        date: "2026-10-21",
        total: 190.00
    }
};

// ============================================================================
// FUNCIONES DE ALMACENAMIENTO Y PERSISTENCIA
// ============================================================================
function saveCart() {
    localStorage.setItem('dulce_cart', JSON.stringify(AppState.cart));
}

function saveWishlist() {
    localStorage.setItem('dulce_wishlist', JSON.stringify(AppState.wishlist));
}

// ============================================================================
// NAVEGACIÓN Y CAMBIO DE VISTAS (SPA & Hash Support)
// ============================================================================
function switchView(viewName) {
    // Ocultar todas las vistas
    const views = document.querySelectorAll('.app-view');
    views.forEach(v => v.classList.remove('active-view'));

    // Desactivar pestañas de navegación
    const tabLinks = document.querySelectorAll('.nav-link-tab');
    tabLinks.forEach(t => t.classList.remove('active'));

    // Activar vista objetivo
    const targetView = document.getElementById(`view-${viewName}`);
    const targetTab = document.getElementById(`tab-${viewName}`);

    if (targetView) {
        targetView.classList.add('active-view');
    }
    if (targetTab) {
        targetTab.classList.add('active');
    }

    // Actualizar hash de la URL sin recargar
    window.location.hash = viewName;

    // Scroll suave arriba
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Renderizar contenidos específicos si es necesario
    if (viewName === 'catalogo') renderCatalog();
    if (viewName === 'carrito') renderCart();
    if (viewName === 'deseos') renderWishlist();
    if (viewName === 'pedido') renderOrderStatus();
    if (viewName === 'resumen') renderDashboardView();
}

// Escuchar cambios de hash (ej: #carrito, #catalogo, #deseos, #pedido)
window.addEventListener('hashchange', () => {
    const hash = window.location.hash.replace('#', '') || 'catalogo';
    switchView(hash);
});

// ============================================================================
// RENDERIZADO DEL CATÁLOGO DE PRODUCTOS
// ============================================================================
function renderCatalog() {
    const grid = document.getElementById('catalogGrid');
    if (!grid) return;

    // Filtrar productos por búsqueda, categoría, precio y stock
    const filtered = AppState.products.filter(p => {
        const matchesCategory = (AppState.activeCategory === 'all' || p.categoriaId == AppState.activeCategory);
        const matchesSearch = p.nombre.toLowerCase().includes(AppState.searchQuery.toLowerCase()) ||
                              p.descripcion.toLowerCase().includes(AppState.searchQuery.toLowerCase());
        const matchesPrice = p.precio <= AppState.maxPrice;
        
        let matchesStock = true;
        if (AppState.filterInStock && p.stock <= 0) matchesStock = false;
        if (AppState.filterImmediate && p.disponibilidad !== 'entrega_inmediata') matchesStock = false;

        return matchesCategory && matchesSearch && matchesPrice && matchesStock;
    });

    const countElem = document.getElementById('catalogCountText');
    if (countElem) {
        countElem.innerText = `Mostrando ${filtered.length} productos comestibles y herramientas para impresiones en alta calidad`;
    }

    if (filtered.length === 0) {
        grid.innerHTML = `
            <div class="col-12 py-5 text-center text-muted">
                <i class="bi bi-search fs-1 mb-2 text-danger opacity-50"></i>
                <h5>No encontramos productos con estos filtros</h5>
                <p class="small">Intenta ajustar tu búsqueda o rango de precio.</p>
                <button class="btn btn-sm btn-pill-outline mt-2" onclick="resetFilters()">Restablecer Filtros</button>
            </div>
        `;
        return;
    }

    grid.innerHTML = filtered.map(p => {
        const isWishlisted = AppState.wishlist.includes(p.id);
        const heartClass = isWishlisted ? 'bi-heart-fill active' : 'bi-heart';

        return `
            <div class="product-card">
                <div class="product-card-top">
                    <span class="product-badge-tag ${p.tagClass}">${p.tag}</span>
                    <button class="product-fav-btn ${isWishlisted ? 'active' : ''}" 
                            title="${isWishlisted ? 'Quitar de lista de deseos' : 'Guardar en lista de deseos'}"
                            onclick="toggleWishlist(${p.id})">
                        <i class="bi ${heartClass}"></i>
                    </button>
                    <div class="product-image-box ${p.bgClass}">
                        <i class="bi ${p.icon} product-placeholder-icon"></i>
                        <h4 class="product-placeholder-title">${p.placeholder}</h4>
                    </div>
                </div>

                <div class="product-info-body">
                    <h5 class="product-name" title="${p.nombre}">${p.nombre}</h5>
                    <p class="product-desc">${p.descripcion}</p>
                    <div class="product-price">Q ${p.precio.toFixed(2)}</div>
                    <button class="btn-add-cart" onclick="addToCart(${p.id})">
                        <i class="bi bi-cart-plus me-1"></i> + Agregar al Carrito
                    </button>
                </div>
            </div>
        `;
    }).join('');
}

// Filtros de Categoría
function setCategory(catId, elem) {
    AppState.activeCategory = catId;
    document.querySelectorAll('.category-link-item').forEach(el => el.classList.remove('active'));
    if (elem) elem.classList.add('active');
    renderCatalog();
}

// Filtro de Búsqueda
function handleSearch(query) {
    AppState.searchQuery = query.trim();
    renderCatalog();
}

// Filtro de Rango de Precio
function handlePriceFilter(val) {
    AppState.maxPrice = parseFloat(val);
    const label = document.getElementById('priceRangeLabel');
    if (label) {
        label.innerText = `Rango: Q 35.00 — Q ${AppState.maxPrice.toLocaleString('es-GT', {minimumFractionDigits: 2})}`;
    }
    renderCatalog();
}

// Filtro de Disponibilidad
function handleStockFilter(checkbox) {
    AppState.filterInStock = checkbox.checked;
    renderCatalog();
}

function handleImmediateFilter(checkbox) {
    AppState.filterImmediate = checkbox.checked;
    renderCatalog();
}

function resetFilters() {
    AppState.activeCategory = 'all';
    AppState.searchQuery = '';
    AppState.maxPrice = 1850;
    AppState.filterInStock = true;
    AppState.filterImmediate = false;

    const searchInput = document.getElementById('globalSearchInput');
    if (searchInput) searchInput.value = '';

    const priceSlider = document.getElementById('priceRangeInput');
    if (priceSlider) priceSlider.value = 1850;

    const label = document.getElementById('priceRangeLabel');
    if (label) label.innerText = 'Rango: Q 35.00 — Q 1,850.00';

    const chkStock = document.getElementById('chkInStock');
    if (chkStock) chkStock.checked = true;

    const chkImm = document.getElementById('chkImmediate');
    if (chkImm) chkImm.checked = false;

    document.querySelectorAll('.category-link-item').forEach((el, index) => {
        if (index === 0) el.classList.add('active');
        else el.classList.remove('active');
    });

    renderCatalog();
}

// ============================================================================
// GESTIÓN DEL CARRITO DE COMPRAS
// ============================================================================
function addToCart(productId, qty = 1, customNote = null) {
    const existing = AppState.cart.find(item => item.id === productId);
    const prod = AppState.products.find(p => p.id === productId);

    if (existing) {
        existing.qty += qty;
    } else {
        AppState.cart.push({
            id: productId,
            qty: qty,
            customNote: customNote || (prod ? prod.descripcion : '')
        });
    }

    saveCart();
    updateHeaderCounters();
    showToast(`¡${prod ? prod.nombre : 'Producto'} agregado al carrito!`, 'toast-pink');

    // Si la vista actual es el carrito o resumen, refrescar
    if (document.getElementById('view-carrito').classList.contains('active-view')) {
        renderCart();
    }
}

function updateCartQty(productId, change) {
    const item = AppState.cart.find(i => i.id === productId);
    if (!item) return;

    item.qty += change;
    if (item.qty <= 0) {
        removeFromCart(productId);
        return;
    }

    saveCart();
    updateHeaderCounters();
    renderCart();
}

function removeFromCart(productId) {
    const prod = AppState.products.find(p => p.id === productId);
    AppState.cart = AppState.cart.filter(item => item.id !== productId);
    saveCart();
    updateHeaderCounters();
    renderCart();
    showToast(`Producto eliminado del carrito.`, 'toast-alert');
}

function renderCart() {
    const cartContainer = document.getElementById('cartItemsList');
    if (!cartContainer) return;

    if (AppState.cart.length === 0) {
        cartContainer.innerHTML = `
            <div class="py-5 text-center text-muted">
                <i class="bi bi-cart-x fs-1 text-danger opacity-50 mb-2"></i>
                <h5>Tu carrito está vacío</h5>
                <p class="small">Explora nuestro catálogo para añadir hojas comestibles, tintas y accesorios.</p>
                <button class="btn-pill-primary mt-2" onclick="switchView('catalogo')">
                    <i class="bi bi-arrow-left me-1"></i> Ir al Catálogo
                </button>
            </div>
        `;
        renderCartSummary(0, 0, 0, 0);
        return;
    }

    let subtotalGeneral = 0;

    const rowsHtml = AppState.cart.map(item => {
        const prod = AppState.products.find(p => p.id === item.id) || {
            nombre: "Producto Personalizado",
            precio: 45.00,
            icon: "bi-stars"
        };

        const itemSubtotal = prod.precio * item.qty;
        subtotalGeneral += itemSubtotal;

        return `
            <div class="table-custom-row">
                <div class="col-cart-product">
                    <div class="thumb-box">
                        <i class="bi ${prod.icon || 'bi-box-seam'}"></i>
                    </div>
                    <div>
                        <h6 class="item-info-title">${prod.nombre}</h6>
                        <p class="item-info-desc">${item.customNote || prod.descripcion}</p>
                        <span class="link-remove-cart" onclick="removeFromCart(${item.id})">
                            <i class="bi bi-trash3"></i> Eliminar del Carrito
                        </span>
                    </div>
                </div>

                <div class="col-cart-qty">
                    <div class="qty-stepper">
                        <button class="btn-qty" onclick="updateCartQty(${item.id}, -1)">–</button>
                        <span class="qty-number">${item.qty}</span>
                        <button class="btn-qty" onclick="updateCartQty(${item.id}, 1)">+</button>
                    </div>
                </div>

                <div class="col-cart-price">
                    Q ${prod.precio.toFixed(2)}
                </div>

                <div class="col-cart-subtotal">
                    Q ${itemSubtotal.toFixed(2)}
                </div>
            </div>
        `;
    }).join('');

    cartContainer.innerHTML = rowsHtml;

    // Calcular totales
    const discount = AppState.coupon ? AppState.discountAmount : 0;
    const shipping = subtotalGeneral > 0 ? AppState.shippingCost : 0;
    const total = Math.max(0, subtotalGeneral + shipping - discount);

    renderCartSummary(subtotalGeneral, shipping, discount, total);
}

function renderCartSummary(subtotal, shipping, discount, total) {
    const subtotalEl = document.getElementById('summarySubtotal');
    const shippingEl = document.getElementById('summaryShipping');
    const discountEl = document.getElementById('summaryDiscount');
    const totalEl = document.getElementById('summaryTotal');

    if (subtotalEl) subtotalEl.innerText = `Q ${subtotal.toFixed(2)}`;
    if (shippingEl) shippingEl.innerText = `Q ${shipping.toFixed(2)}`;
    if (discountEl) discountEl.innerText = `- Q ${discount.toFixed(2)}`;
    if (totalEl) totalEl.innerText = `Q ${total.toFixed(2)}`;
}

// Cupones de Descuento
function applyCoupon() {
    const input = document.getElementById('couponInput');
    if (!input) return;
    const code = input.value.trim().toUpperCase();

    if (code === 'DULCE2026') {
        AppState.coupon = 'DULCE2026';
        AppState.discountAmount = 15.00;
        localStorage.setItem('dulce_coupon', 'DULCE2026');
        showToast('¡Cupón DULCE2026 aplicado! Descuento de Q 15.00', 'toast-success');
        renderCart();
    } else if (code === '') {
        showToast('Ingresa un código de descuento válido.', 'toast-alert');
    } else {
        showToast(`El código "${code}" no es válido o ha expirado.`, 'toast-alert');
    }
}

// ============================================================================
// GESTIÓN DE LA LISTA DE DESEOS (WISHLIST)
// ============================================================================
function toggleWishlist(productId) {
    const index = AppState.wishlist.indexOf(productId);
    const prod = AppState.products.find(p => p.id === productId);

    if (index > -1) {
        AppState.wishlist.splice(index, 1);
        showToast(`Quitado de tu Lista de Deseos.`, 'toast-alert');
    } else {
        AppState.wishlist.push(productId);
        showToast(`¡${prod ? prod.nombre : 'Producto'} guardado en tu Lista de Deseos!`, 'toast-pink');
    }

    saveWishlist();
    updateHeaderCounters();
    renderCatalog();

    if (document.getElementById('view-deseos').classList.contains('active-view')) {
        renderWishlist();
    }
}

function moveToCartFromWishlist(productId) {
    addToCart(productId, 1);
    // Opcionalmente podemos retirarlo de deseos o mantenerlo
    AppState.wishlist = AppState.wishlist.filter(id => id !== productId);
    saveWishlist();
    updateHeaderCounters();
    renderWishlist();
}

function removeFromWishlist(productId) {
    AppState.wishlist = AppState.wishlist.filter(id => id !== productId);
    saveWishlist();
    updateHeaderCounters();
    renderWishlist();
    showToast('Producto eliminado de tu Lista de Deseos.', 'toast-alert');
}

function renderWishlist() {
    const container = document.getElementById('wishlistItemsList');
    const countHeader = document.getElementById('wishlistCountText');
    if (!container) return;

    if (countHeader) {
        countHeader.innerText = `Mi Lista de Deseos (${AppState.wishlist.length} productos guardados)`;
    }

    if (AppState.wishlist.length === 0) {
        container.innerHTML = `
            <div class="py-5 text-center text-muted">
                <i class="bi bi-heart fs-1 text-danger opacity-50 mb-2"></i>
                <h5>Tu lista de deseos está vacía</h5>
                <p class="small">Haz clic en el corazón de cualquier producto para guardarlo aquí y comprarlo luego.</p>
                <button class="btn-pill-primary mt-2" onclick="switchView('catalogo')">
                    Explorar Catálogo
                </button>
            </div>
        `;
        return;
    }

    const rowsHtml = AppState.wishlist.map(productId => {
        const prod = AppState.products.find(p => p.id === productId);
        if (!prod) return '';

        return `
            <div class="table-custom-row">
                <div class="col-wishlist-product">
                    <div class="thumb-box">
                        <i class="bi ${prod.icon || 'bi-box-seam'}"></i>
                    </div>
                    <div>
                        <h6 class="item-info-title">${prod.nombre}</h6>
                        <p class="item-info-desc">${prod.descripcion}</p>
                    </div>
                </div>

                <div class="col-wishlist-price">
                    Q ${prod.precio.toLocaleString('es-GT', {minimumFractionDigits: 2})}
                </div>

                <div class="col-wishlist-stock">
                    <span class="badge-stock">
                        <i class="bi bi-check2-circle me-1"></i> En Stock (${prod.stock} disponibles)
                    </span>
                </div>

                <div class="col-wishlist-actions">
                    <button class="btn-pill-primary" onclick="moveToCartFromWishlist(${prod.id})">
                        <i class="bi bi-cart-check me-1"></i> Mover al Carrito
                    </button>
                    <button class="btn-pill-outline" onclick="removeFromWishlist(${prod.id})">
                        <i class="bi bi-trash3 me-1"></i> Quitar
                    </button>
                </div>
            </div>
        `;
    }).join('');

    container.innerHTML = rowsHtml;
}

function copyWishlistLink() {
    const url = window.location.origin + window.location.pathname + '#deseos';
    navigator.clipboard.writeText(url).then(() => {
        showToast('¡Enlace de Lista de Deseos copiado al portapapeles!', 'toast-success');
    }).catch(() => {
        showToast('Enlace: ' + url, 'toast-pink');
    });
}

// ============================================================================
// ESTADO DE PEDIDO / TRACKING
// ============================================================================
function renderOrderStatus() {
    const order = AppState.currentOrder;
    const titleEl = document.getElementById('orderStatusTitle');
    const clientEl = document.getElementById('orderStatusClient');
    const guideEl = document.getElementById('orderTrackingGuide');
    const methodEl = document.getElementById('orderShippingMethod');
    const dateEl = document.getElementById('orderEstimatedDate');

    if (titleEl) titleEl.innerText = `Estado del Pedido #${order.id}`;
    if (clientEl) clientEl.innerText = `Cliente: ${AppState.client.shortName} | Dirección: ${AppState.client.address}`;
    if (guideEl) guideEl.innerText = order.trackingGuide;
    if (methodEl) methodEl.innerText = order.shippingMethod;
    if (dateEl) dateEl.innerText = order.estimatedDelivery;

    // Actualizar nodos del stepper
    const stepNodes = document.querySelectorAll('.step-node');
    const progressFill = document.getElementById('stepperProgressBar');

    stepNodes.forEach((node, idx) => {
        const stepNum = idx + 1;
        node.classList.remove('completed', 'active');
        if (stepNum < order.step) {
            node.classList.add('completed');
        } else if (stepNum === order.step) {
            node.classList.add('active');
        }
    });

    if (progressFill) {
        const percentage = ((order.step - 1) / (stepNodes.length - 1)) * 100;
        progressFill.style.width = `${percentage}%`;
    }
}

// ============================================================================
// VISTA RESUMEN / DASHBOARD (Mockup 4: Catálogo + Carrito + Pedido)
// ============================================================================
function renderDashboardView() {
    renderCatalog();
    renderCart();
    renderOrderStatus();
}

// ============================================================================
// MODAL: SUBIR FOTO PARA IMPRESIÓN COMESTIBLE
// ============================================================================
function handleFileSelect(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('photoPreview');
        const dropzoneText = document.getElementById('dropzoneText');
        if (preview) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }
        if (dropzoneText) {
            dropzoneText.innerText = `Archivo cargado: ${file.name}`;
        }
    };
    reader.readAsDataURL(file);
}

function submitCustomPrint() {
    const paperType = document.getElementById('customPaperType')?.value || 'Hoja de Azúcar A4';
    const dedication = document.getElementById('customDedication')?.value || 'Diseño personalizado para pastel';
    const qty = parseInt(document.getElementById('customQuantity')?.value || '1', 10);

    let price = 45.00;
    if (paperType.includes('Arroz')) price = 35.00;
    if (paperType.includes('Discos')) price = 40.00;

    const customProduct = {
        id: Date.now(), // ID temporal
        nombre: `Impresión en ${paperType}`,
        descripcion: dedication,
        precio: price,
        icon: "bi-cake2"
    };

    AppState.products.push({
        id: customProduct.id,
        categoriaId: 3,
        categoriaNombre: "Impresiones Personalizadas",
        nombre: customProduct.nombre,
        descripcion: customProduct.descripcion,
        precio: customProduct.precio,
        stock: 99,
        disponibilidad: "entrega_inmediata",
        tag: "Personalizado",
        tagClass: "badge-tag-servicio",
        bgClass: "bg-lavender",
        placeholder: "Impresión Foto",
        icon: "bi-cake2"
    });

    addToCart(customProduct.id, qty, dedication);

    // Cerrar modal
    const modalEl = document.getElementById('uploadPhotoModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
    }

    showToast('¡Tu impresión comestible personalizada fue agregada al carrito!', 'toast-success');
    switchView('carrito');
}

// ============================================================================
// CHECKOUT / CONFIRMACIÓN DE PEDIDO
// ============================================================================
function confirmCheckoutOrder() {
    if (AppState.cart.length === 0) {
        showToast('Tu carrito está vacío. Agrega productos antes de confirmar.', 'toast-alert');
        return;
    }

    const orderId = `PED-2026-0${Math.floor(Math.random() * 90) + 10}`;
    
    // Actualizar estado del pedido activo
    AppState.currentOrder = {
        id: orderId,
        status: "En Preparación",
        step: 2,
        trackingGuide: `GT-EXPRESS-${Math.floor(Math.random() * 90000) + 10000}`,
        shippingMethod: "Entrega Local Ciudad de Guatemala",
        estimatedDelivery: "Hoy a las 4:00 PM",
        date: new Date().toLocaleDateString('es-GT'),
        total: 190.00
    };

    // Vaciar carrito
    AppState.cart = [];
    saveCart();
    updateHeaderCounters();

    // Mostrar modal de confirmación
    const modalEl = document.getElementById('orderConfirmedModal');
    const orderNumberEl = document.getElementById('modalConfirmedOrderNumber');
    if (orderNumberEl) orderNumberEl.innerText = `#${orderId}`;

    if (modalEl) {
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    }
}

// ============================================================================
// ACTUALIZACIÓN DE CONTADORES EN HEADER Y TOASTS
// ============================================================================
function updateHeaderCounters() {
    // Contador carrito
    const cartCount = AppState.cart.reduce((sum, item) => sum + item.qty, 0);
    const cartTabBadge = document.getElementById('tabCartCount');
    if (cartTabBadge) cartTabBadge.innerText = `(${cartCount})`;

    // Contador wishlist
    const wishCount = AppState.wishlist.length;
    const wishTabBadge = document.getElementById('tabWishCount');
    if (wishTabBadge) wishTabBadge.innerText = `(${wishCount})`;

    // Total en badge de cuenta
    let subtotal = 0;
    AppState.cart.forEach(item => {
        const prod = AppState.products.find(p => p.id === item.id);
        if (prod) subtotal += (prod.precio * item.qty);
    });

    const discount = AppState.coupon ? AppState.discountAmount : 0;
    const shipping = subtotal > 0 ? AppState.shippingCost : 0;
    const total = Math.max(0, subtotal + shipping - discount);

    const userTotalEl = document.getElementById('headerUserTotal');
    if (userTotalEl) {
        userTotalEl.innerText = `Q ${total.toFixed(2)}`;
    }
}

function showToast(message, typeClass = 'toast-alert') {
    const container = document.getElementById('toastAlertContainer');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast-alert ${typeClass}`;
    toast.innerHTML = `
        <i class="bi bi-info-circle-fill"></i>
        <span>${message}</span>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateY(10px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
    }, 3200);
}

// ============================================================================
// INICIALIZACIÓN AL CARGAR LA PÁGINA
// ============================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Configurar búsqueda global en header
    const searchInput = document.getElementById('globalSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            handleSearch(e.target.value);
            // Si el usuario busca y no está en catálogo, redirigir a catálogo
            const catalogoView = document.getElementById('view-catalogo');
            if (catalogoView && !catalogoView.classList.contains('active-view')) {
                switchView('catalogo');
            }
        });
    }

    // Configurar Drag & Drop en dropzone
    const dropzone = document.getElementById('dropzoneUpload');
    const fileInput = document.getElementById('printFileInput');

    if (dropzone && fileInput) {
        dropzone.addEventListener('click', () => fileInput.click());
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        });
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('dragover');
        });
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelect({ target: { files: e.dataTransfer.files } });
            }
        });
    }

    // Leer hash inicial o cargar catálogo por defecto
    const initialHash = window.location.hash.replace('#', '') || 'catalogo';
    updateHeaderCounters();
    switchView(initialHash);
});

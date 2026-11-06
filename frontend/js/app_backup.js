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
// CONSTANTES Y GESTOR DE DATOS AISLADOS POR CUENTA DE USUARIO
// ============================================================================
const DEMO_NOHELIA_EMAIL = 'nohelia.barillas@ejemplo.com';
const DEMO_CARLOS_EMAIL = 'carlos.morales@ejemplo.com';

// Generador de clave de almacenamiento única por usuario (Storage Sandbox)
function getUserStorageKey(suffix, email = null) {
    const targetEmail = email || (AppState.currentUser ? AppState.currentUser.email : null);
    if (!targetEmail) {
        return `dulce_guest_${suffix}`;
    }
    const cleanEmail = targetEmail.toLowerCase().trim().replace(/[^a-z0-9]/g, '_');
    return `dulce_usr_${cleanEmail}_${suffix}`;
}

// Datos iniciales independientes para cuentas demo de prueba
function getInitialDataForEmail(email) {
    const cleanEmail = (email || '').toLowerCase().trim();

    // Cuenta Demo 1: Nohelia Barillas (Mockups originales)
    if (cleanEmail === DEMO_NOHELIA_EMAIL.toLowerCase()) {
        return {
            cart: [
                { id: 3, qty: 1, customNote: "Servicio personalizado con envío de foto" },
                { id: 5, qty: 2, customNote: "12 toppers redondos precortados en azúcar" },
                { id: 8, qty: 1, customNote: "Mantenimiento grado alimenticio para impresoras" }
            ],
            wishlist: [7, 1],
            orders: [
                {
                    id: "PED-2026-04",
                    status: "En Preparación",
                    step: 2,
                    trackingGuide: "GT-EXPRESS-88921",
                    shippingMethod: "Entrega Local Ciudad de Guatemala",
                    estimatedDelivery: "Hoy a las 3:30 PM",
                    date: "2026-10-21",
                    total: 190.00,
                    items: [
                        { nombre: "Impresión Foto Pastel A4 (Hoja de Azúcar)", descripcion: "Diseño personalizado para pastel temático", qty: 1, precio: 45.00, icon: "bi-camera" },
                        { nombre: "Discos Comestibles Cupcakes 5cm (Pack x12)", descripcion: "12 toppers precortados en azúcar", qty: 2, precio: 35.00, icon: "bi-circle" },
                        { nombre: "Solución Limpiadora de Cabezales 100ml", descripcion: "Mantenimiento de inyectores grado alimenticio", qty: 1, precio: 65.00, icon: "bi-wrench-adjustable" }
                    ]
                },
                {
                    id: "PED-2026-05",
                    status: "Despachado",
                    step: 3,
                    trackingGuide: "GT-EXPRESS-99432",
                    shippingMethod: "Envío Nacional Cargo Expreso",
                    estimatedDelivery: "Mañana a las 11:00 AM",
                    date: "2026-10-23",
                    total: 165.00,
                    items: [
                        { nombre: "Kit Tintas Comestibles CMYK 100ml", descripcion: "4 botellas grado alimenticio con certificación FDA", qty: 1, precio: 165.00, icon: "bi-droplet-half" }
                    ]
                }
            ],
            selectedOrderId: "PED-2026-04"
        };
    }

    // Cuenta Demo 2: Carlos Morales (Pastelería Creativa - Datos completamente diferentes)
    if (cleanEmail === DEMO_CARLOS_EMAIL.toLowerCase()) {
        return {
            cart: [
                { id: 2, qty: 1, customNote: "Kit de tintas para impresora alimentaria EPSON" }
            ],
            wishlist: [4],
            orders: [
                {
                    id: "PED-2026-09",
                    status: "Entregado",
                    step: 4,
                    trackingGuide: "FORZA-GT-55410",
                    shippingMethod: "Envío Departamental Forza a Escuintla",
                    estimatedDelivery: "Entregado el 15/10/2026",
                    date: "2026-10-15",
                    total: 165.00,
                    items: [
                        { nombre: "Kit Tintas Comestibles CMYK 100ml", descripcion: "4 botellas grado alimenticio con certificación FDA", qty: 1, precio: 165.00, icon: "bi-droplet-half" }
                    ]
                }
            ],
            selectedOrderId: "PED-2026-09"
        };
    }

    // Cualquier otra cuenta nueva inicia 100% limpia sin mezclar información
    return {
        cart: [],
        wishlist: [],
        orders: [],
        selectedOrderId: null
    };
}

// Guardar los datos de la cuenta activa en su propio espacio aislado
function saveCurrentUserData() {
    if (!AppState.currentUser || !AppState.currentUser.email) return;
    const email = AppState.currentUser.email.toLowerCase().trim();

    localStorage.setItem(getUserStorageKey('cart', email), JSON.stringify(AppState.cart || []));
    localStorage.setItem(getUserStorageKey('wishlist', email), JSON.stringify(AppState.wishlist || []));
    localStorage.setItem(getUserStorageKey('orders', email), JSON.stringify(AppState.orders || []));
    if (AppState.selectedOrderId) {
        localStorage.setItem(getUserStorageKey('selected_order_id', email), AppState.selectedOrderId);
    } else {
        localStorage.removeItem(getUserStorageKey('selected_order_id', email));
    }
}

// Cargar los datos exclusivos de una cuenta específica
function loadUserDataForAccount(user) {
    if (!user || !user.email) {
        // Invitado / Sesión cerrada: TODO LIMPIO
        AppState.cart = [];
        AppState.wishlist = [];
        AppState.orders = [];
        AppState.selectedOrderId = null;
        return;
    }

    const email = user.email.toLowerCase().trim();
    const defaults = getInitialDataForEmail(email);

    // 1. Carrito propio de la cuenta
    const savedCart = localStorage.getItem(getUserStorageKey('cart', email));
    if (savedCart !== null) {
        try { AppState.cart = JSON.parse(savedCart) || []; } catch (e) { AppState.cart = []; }
    } else {
        AppState.cart = defaults.cart;
        localStorage.setItem(getUserStorageKey('cart', email), JSON.stringify(AppState.cart));
    }

    // 2. Lista de deseos propia de la cuenta
    const savedWish = localStorage.getItem(getUserStorageKey('wishlist', email));
    if (savedWish !== null) {
        try { AppState.wishlist = JSON.parse(savedWish) || []; } catch (e) { AppState.wishlist = []; }
    } else {
        AppState.wishlist = defaults.wishlist;
        localStorage.setItem(getUserStorageKey('wishlist', email), JSON.stringify(AppState.wishlist));
    }

    // 3. Pedidos propios de la cuenta
    const savedOrders = localStorage.getItem(getUserStorageKey('orders', email));
    if (savedOrders !== null) {
        try { AppState.orders = JSON.parse(savedOrders) || []; } catch (e) { AppState.orders = []; }
    } else {
        AppState.orders = defaults.orders;
        localStorage.setItem(getUserStorageKey('orders', email), JSON.stringify(AppState.orders));
    }

    // 4. Pedido seleccionado
    const savedSel = localStorage.getItem(getUserStorageKey('selected_order_id', email));
    if (savedSel && AppState.orders.some(o => o.id === savedSel)) {
        AppState.selectedOrderId = savedSel;
    } else if (AppState.orders.length > 0) {
        AppState.selectedOrderId = AppState.orders[0].id;
    } else {
        AppState.selectedOrderId = null;
    }
}

// ============================================================================
// ESTADO GLOBAL DE LA APLICACIÓN (AppState)
// ============================================================================
const AppState = {
    products: INITIAL_PRODUCTS,
    activeCategory: 'all',
    searchQuery: '',
    maxPrice: 1850,
    filterInStock: true,
    filterImmediate: false,

    // Carrito, Deseos y Pedidos se manejan por cuenta (inician vacíos y se cargan con loadUserDataForAccount)
    cart: [],
    wishlist: [],
    orders: [],
    selectedOrderId: null,

    // Configuración de envío y cupones
    coupon: localStorage.getItem('dulce_coupon') || 'DULCE2026',
    discountAmount: 15.00,
    shippingCost: 25.00,
    shippingMethod: 'domicilio',
    shippingNotes: '',
    deptMethod: 'forza_prepago',
    deptDepartment: 'Quetzaltenango',
    deptMunicipality: '',
    codFee: 0.00,

    // Cuentas guardadas en este dispositivo (Multi-cuenta switcher)
    savedAccounts: (function() {
        const saved = localStorage.getItem('dulce_saved_accounts');
        if (saved) {
            try {
                const parsed = JSON.parse(saved);
                if (Array.isArray(parsed) && parsed.length > 0) return parsed;
            } catch (e) {}
        }
        return [
            {
                id: 'acc_nohelia',
                name: "Nohelia Mishelle Barillas",
                shortName: "Nohelia Barillas",
                email: "nohelia.barillas@ejemplo.com",
                address: "5ta Calle 12-45 Zona 10, Edificio Las Flores, Guatemala",
                phone: "+502 5555-1234",
                tag: "Cliente Frecuente"
            },
            {
                id: 'acc_carlos',
                name: "Carlos Eduardo Morales",
                shortName: "Carlos Morales",
                email: "carlos.morales@ejemplo.com",
                address: "Calzada Roosevelt 14-20 Zona 11, Guatemala",
                phone: "+502 4444-9876",
                tag: "Pastelería Creativa"
            }
        ];
    })(),

    // Usuario autenticado (con persistencia en localStorage)
    currentUser: (function() {
        const saved = localStorage.getItem('dulce_user');
        if (saved === 'null') return null;
        if (saved) {
            try {
                const parsed = JSON.parse(saved);
                if (parsed && parsed.email) return parsed;
            } catch (e) {}
        }
        return {
            id: 1,
            name: "Nohelia Mishelle Barillas",
            shortName: "Nohelia Barillas",
            email: "nohelia.barillas@ejemplo.com",
            address: "5ta Calle 12-45 Zona 10, Edificio Las Flores, Guatemala",
            phone: "+502 5555-1234"
        };
    })(),

    // Compatibilidad para client
    get client() {
        return this.currentUser || {
            name: "Cliente Invitado",
            shortName: "Invitado",
            email: "invitado@dulceimpresion.gt",
            address: "Ciudad de Guatemala",
            phone: ""
        };
    }
};

// Cargar los datos de la cuenta activa al iniciar
loadUserDataForAccount(AppState.currentUser);

// Compatibilidad para AppState.currentOrder
Object.defineProperty(AppState, 'currentOrder', {
    get: function() { return getCurrentOrder(); },
    set: function(val) {
        if (!val) {
            AppState.orders = [];
            AppState.selectedOrderId = null;
        } else {
            const idx = AppState.orders.findIndex(o => o.id === val.id);
            if (idx >= 0) {
                AppState.orders[idx] = val;
            } else {
                AppState.orders.unshift(val);
            }
            AppState.selectedOrderId = val.id;
        }
        saveOrders();
    }
});

// ============================================================================
// FUNCIONES DE ALMACENAMIENTO Y PERSISTENCIA (AISLADAS POR USUARIO)
// ============================================================================
function saveCart() {
    if (AppState.currentUser && AppState.currentUser.email) {
        localStorage.setItem(getUserStorageKey('cart', AppState.currentUser.email), JSON.stringify(AppState.cart || []));
    } else {
        localStorage.setItem('dulce_guest_cart', JSON.stringify(AppState.cart || []));
    }
}

function saveWishlist() {
    if (AppState.currentUser && AppState.currentUser.email) {
        localStorage.setItem(getUserStorageKey('wishlist', AppState.currentUser.email), JSON.stringify(AppState.wishlist || []));
    } else {
        localStorage.setItem('dulce_guest_wishlist', JSON.stringify(AppState.wishlist || []));
    }
}

function getCurrentOrder() {
    if (!AppState.orders || AppState.orders.length === 0) return null;
    const found = AppState.orders.find(o => o.id === AppState.selectedOrderId);
    return found || AppState.orders[0];
}

function saveOrders() {
    if (AppState.currentUser && AppState.currentUser.email) {
        localStorage.setItem(getUserStorageKey('orders', AppState.currentUser.email), JSON.stringify(AppState.orders || []));
        const selKey = getUserStorageKey('selected_order_id', AppState.currentUser.email);
        if (AppState.selectedOrderId) {
            localStorage.setItem(selKey, AppState.selectedOrderId);
        } else {
            localStorage.removeItem(selKey);
        }
    } else {
        localStorage.setItem('dulce_guest_orders', JSON.stringify(AppState.orders || []));
    }
}

function selectOrder(orderId) {
    AppState.selectedOrderId = orderId;
    saveOrders();
    renderOrderStatus();
    showToast(`Mostrando Pedido #${orderId}`, 'toast-pink');
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
function addToCart(productId, qty = 1, customNote = null, customImage = null) {
    const existing = AppState.cart.find(item => item.id === productId);
    const prod = AppState.products.find(p => p.id === productId);

    if (existing) {
        existing.qty += qty;
        if (customImage) existing.image = customImage;
    } else {
        AppState.cart.push({
            id: productId,
            qty: qty,
            customNote: customNote || (prod ? prod.descripcion : ''),
            image: customImage || (prod ? prod.image : null)
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
                <p class="small text-muted mb-3">
                    ${AppState.currentUser 
                        ? 'No has agregado productos a tu compra todavía.' 
                        : 'No hay productos en el carrito porque no has iniciado sesión o se cerró la cuenta.'}
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn-pill-primary" onclick="switchView('catalogo')">
                        <i class="bi bi-bag-plus me-1"></i> Ir al Catálogo
                    </button>
                    ${!AppState.currentUser ? `
                        <button class="btn-pill-outline" onclick="openLoginModal()">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                        </button>
                    ` : ''}
                </div>
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

        const thumbHtml = (item.image || prod.image)
            ? `<img src="${item.image || prod.image}" alt="Foto comestible" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">`
            : `<i class="bi ${prod.icon || 'bi-box-seam'}"></i>`;

        return `
            <div class="table-custom-row">
                <div class="col-cart-product">
                    <div class="thumb-box overflow-hidden">
                        ${thumbHtml}
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

    // Calcular fletes y comisiones
    let shipping = 0;
    let codFee = 0;

    if (subtotalGeneral > 0) {
        if (AppState.shippingMethod === 'tienda') {
            shipping = 0.00;
            codFee = 0.00;
        } else if (AppState.shippingMethod === 'domicilio') {
            shipping = AppState.shippingCost;
            codFee = 0.00;
        } else if (AppState.shippingMethod === 'departamental') {
            if (AppState.deptMethod === 'forza_prepago') {
                shipping = 35.00;
                codFee = 0.00;
            } else if (AppState.deptMethod === 'contra_entrega') {
                shipping = 45.00;
                // Comisión del 5% cobrada por Guatex/Forza por manejo y recaudación de efectivo
                codFee = Math.round((subtotalGeneral * 0.05) * 100) / 100;
            } else if (AppState.deptMethod === 'por_cobrar') {
                shipping = 0.00; // Flete pagadero al recibir en agencia
                codFee = 0.00;
            }
        }
    }

    AppState.codFee = codFee;
    const discount = AppState.coupon ? AppState.discountAmount : 0;
    const total = Math.max(0, subtotalGeneral + shipping + codFee - discount);

    renderCartSummary(subtotalGeneral, shipping, discount, total, codFee);
}

function renderCartSummary(subtotal, shipping, discount, total, codFee = 0) {
    const subtotalEl = document.getElementById('summarySubtotal');
    const shippingEl = document.getElementById('summaryShipping');
    const discountEl = document.getElementById('summaryDiscount');
    const totalEl = document.getElementById('summaryTotal');
    const codRow = document.getElementById('summaryCodFeeRow');
    const codEl = document.getElementById('summaryCodFee');

    if (subtotalEl) subtotalEl.innerText = `Q ${subtotal.toFixed(2)}`;
    if (shippingEl) {
        if (AppState.shippingMethod === 'departamental' && AppState.deptMethod === 'por_cobrar') {
            shippingEl.innerText = 'Por pagar en agencia';
        } else if (shipping === 0) {
            shippingEl.innerText = 'Gratis (Q 0.00)';
        } else {
            shippingEl.innerText = `Q ${shipping.toFixed(2)}`;
        }
    }

    if (codRow && codEl) {
        if (codFee > 0) {
            codRow.classList.remove('d-none');
            codEl.innerText = `+ Q ${codFee.toFixed(2)}`;
        } else {
            codRow.classList.add('d-none');
        }
    }

    if (discountEl) discountEl.innerText = `- Q ${discount.toFixed(2)}`;
    if (totalEl) totalEl.innerText = `Q ${total.toFixed(2)}`;

    // Actualizar datos del cliente en el checkout
    const client = AppState.client;
    const nameEl = document.getElementById('checkoutClientName');
    const addrEl = document.getElementById('checkoutClientAddress');
    const phoneEl = document.getElementById('checkoutClientPhone');
    if (nameEl) nameEl.innerText = client.name || 'Cliente Invitado';
    if (addrEl) addrEl.innerText = client.address || 'Guatemala';
    if (phoneEl) phoneEl.innerText = `Teléfono: ${client.phone || '+502 5555-1234'}`;
}

// ============================================================================
// GESTIÓN DE TIPO DE ENTREGA, ZONAS Y TARIFAS (ZONAS ROJAS / RECOGER EN TIENDA / GUATEX)
// ============================================================================

function selectShippingOption(optionType) {
    AppState.shippingMethod = optionType;

    const radioDomicilio = document.getElementById('shipDomicilio');
    const radioTienda = document.getElementById('shipTienda');
    const radioDepartamental = document.getElementById('shipDepartamental');

    const cardDomicilio = document.getElementById('cardOptionDomicilio');
    const cardTienda = document.getElementById('cardOptionTienda');
    const cardDepartamental = document.getElementById('cardOptionDepartamental');

    const zoneSelector = document.getElementById('zoneSelectorContainer');
    const tiendaNotice = document.getElementById('tiendaNotice');
    const deptContainer = document.getElementById('departamentalOptionsContainer');

    // Desmarcar clases
    [cardDomicilio, cardTienda, cardDepartamental].forEach(c => {
        if (c) c.classList.remove('selected');
    });

    if (optionType === 'domicilio') {
        if (radioDomicilio) radioDomicilio.checked = true;
        if (cardDomicilio) cardDomicilio.classList.add('selected');
        if (zoneSelector) zoneSelector.classList.remove('d-none');
        if (tiendaNotice) tiendaNotice.classList.add('d-none');
        if (deptContainer) deptContainer.classList.add('d-none');

        handleZoneChange();
    } else if (optionType === 'tienda') {
        if (radioTienda) radioTienda.checked = true;
        if (cardTienda) cardTienda.classList.add('selected');
        if (zoneSelector) zoneSelector.classList.add('d-none');
        if (tiendaNotice) tiendaNotice.classList.remove('d-none');
        if (deptContainer) deptContainer.classList.add('d-none');

        AppState.shippingCost = 0.00;
        renderCart();
        showToast('Tipo de entrega: Pasar a recoger en taller o mandar Uber propio.', 'toast-pink');
    } else if (optionType === 'departamental') {
        if (radioDepartamental) radioDepartamental.checked = true;
        if (cardDepartamental) cardDepartamental.classList.add('selected');
        if (zoneSelector) zoneSelector.classList.add('d-none');
        if (tiendaNotice) tiendaNotice.classList.add('d-none');
        if (deptContainer) deptContainer.classList.remove('d-none');

        selectDeptMode(AppState.deptMethod || 'forza_prepago');
    }
}

// Sub-modalidades Departamentales (Forza Prepago, COD Contra Entrega, Por Cobrar)
function selectDeptMode(mode) {
    AppState.deptMethod = mode;

    const cardForza = document.getElementById('deptCardForza');
    const cardContra = document.getElementById('deptCardContraEntrega');
    const cardCobrar = document.getElementById('deptCardPorCobrar');

    const radioForza = document.getElementById('radioDeptForza');
    const radioContra = document.getElementById('radioDeptContraEntrega');
    const radioCobrar = document.getElementById('radioDeptPorCobrar');

    const badgeDept = document.getElementById('deptCostBadge');

    [cardForza, cardContra, cardCobrar].forEach(c => {
        if (c) c.classList.remove('selected');
    });

    const radioTransfer = document.getElementById('paymentTransfer');
    const radioCash = document.getElementById('paymentCash');
    const noticeText = document.getElementById('paymentMethodNoticeText');

    if (mode === 'forza_prepago') {
        if (cardForza) cardForza.classList.add('selected');
        if (radioForza) radioForza.checked = true;
        if (badgeDept) badgeDept.innerText = 'Q 35.00';
        if (radioTransfer) radioTransfer.checked = true;
        if (noticeText) noticeText.innerText = 'Para guías prepago Forza Express se requiere depósito/transferencia bancaria previa del total del pedido + flete.';
        AppState.shippingCost = 35.00;
        showToast('Guía Prepago Forza seleccionada (Q 35.00 - Requiere previo depósito).', 'toast-pink');
    } else if (mode === 'contra_entrega') {
        if (cardContra) cardContra.classList.add('selected');
        if (radioContra) radioContra.checked = true;
        if (badgeDept) badgeDept.innerText = 'Q 45.00 + 5%';
        if (radioCash) radioCash.checked = true;
        if (noticeText) noticeText.innerText = 'Pagas en efectivo al mensajero de Guatex o Forza al recibir en tu dirección. Aplica 5% de comisión de agencia.';
        AppState.shippingCost = 45.00;
        showToast('Pago Contra Entrega seleccionado (Envío Q 45.00 + 5% comisión de agencia).', 'toast-alert');
    } else if (mode === 'por_cobrar') {
        if (cardCobrar) cardCobrar.classList.add('selected');
        if (radioCobrar) radioCobrar.checked = true;
        if (badgeDept) badgeDept.innerText = 'Flete al recibir';
        if (radioTransfer) radioTransfer.checked = true;
        if (noticeText) noticeText.innerText = 'El flete exacto se consulta en agencia y lo pagas directamente a Guatex/Forza al retirar tu paquete.';
        AppState.shippingCost = 0.00;
        showToast('Flete por Cobrar: el costo exacto se paga en la agencia receptora.', 'toast-pink');
    }

    renderCart();
}

function handleDepartamentoChange() {
    const sel = document.getElementById('departamentoSelect');
    if (sel) {
        AppState.deptDepartment = sel.value;
        renderCart();
        showToast(`Destino departamental: ${sel.value}`, 'toast-pink');
    }
}

function handleMunicipioChange(val) {
    AppState.deptMunicipality = val;
}

function handleZoneChange() {
    const select = document.getElementById('deliveryZoneSelect');
    if (!select) return;

    const selectedOption = select.options[select.selectedIndex];
    const cost = parseFloat(selectedOption.getAttribute('data-cost') || '25');
    const isSafe = selectedOption.getAttribute('data-safe') === 'true';

    const warningEl = document.getElementById('dangerZoneWarning');
    const badgeEl = document.getElementById('domicilioCostBadge');

    if (badgeEl) badgeEl.innerText = `Q ${cost.toFixed(2)}`;

    // Mostrar alerta de seguridad si es zona roja / restringida
    if (warningEl) {
        if (!isSafe) {
            warningEl.classList.remove('d-none');
            showToast('⚠️ Sector con cobertura limitada por seguridad. Revisa las recomendaciones.', 'toast-alert');
        } else {
            warningEl.classList.add('d-none');
        }
    }

    if (AppState.shippingMethod === 'domicilio') {
        AppState.shippingCost = cost;
        renderCart();
    }
}

function handleAddressNotesChange(notes) {
    AppState.shippingNotes = notes;
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
                <p class="small text-muted mb-3">
                    ${AppState.currentUser 
                        ? 'Haz clic en el corazón de cualquier producto para guardarlo aquí y comprarlo luego.' 
                        : 'Inicia sesión con tu cuenta para guardar y consultar tus productos favoritos.'}
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn-pill-primary" onclick="switchView('catalogo')">
                        <i class="bi bi-bag-plus me-1"></i> Explorar Catálogo
                    </button>
                    ${!AppState.currentUser ? `
                        <button class="btn-pill-outline" onclick="openLoginModal()">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                        </button>
                    ` : ''}
                </div>
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
// ESTADO DE PEDIDO / TRACKING (SOPORTE MULTI-PEDIDO)
// ============================================================================
function renderOrderStatus() {
    const order = getCurrentOrder();
    const cardEl = document.getElementById('orderTrackingCard');
    const emptyEl = document.getElementById('orderEmptyState');
    const selectorWrapper = document.getElementById('ordersSelectorWrapper');
    const tabsContainer = document.getElementById('ordersListTabs');
    const totalCountBadge = document.getElementById('ordersTotalCountBadge');
    const sidebarContainer = document.getElementById('sidebarOrdersContainer');
    const sidebarCount = document.getElementById('sidebarOrdersCount');

    // Actualizar contador del sidebar
    if (sidebarCount) sidebarCount.innerText = AppState.orders.length;

    // Renderizar lista interactiva en el SIDEBAR
    if (sidebarContainer) {
        if (!AppState.orders || AppState.orders.length === 0) {
            sidebarContainer.innerHTML = `
                <div class="p-3 text-center text-muted small bg-light rounded-3">
                    <i class="bi bi-box-seam d-block fs-4 opacity-50 mb-1"></i>
                    Sin pedidos activos
                </div>
            `;
        } else {
            sidebarContainer.innerHTML = AppState.orders.map(o => {
                const isSel = (order && o.id === order.id);
                let badgeClass = 'bg-lavender text-wine';
                if (o.status === 'Cancelado') badgeClass = 'bg-danger text-white';
                else if (o.status === 'Despachado') badgeClass = 'bg-primary-subtle text-primary';
                else if (o.status === 'Entregado') badgeClass = 'bg-success-subtle text-success';

                return `
                    <div class="sidebar-order-item ${isSel ? 'active' : ''}" onclick="selectOrder('${o.id}'); switchView('pedido');">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <strong class="text-wine small">#${o.id}</strong>
                            <span class="badge ${badgeClass} rounded-pill" style="font-size: 0.68rem;">${o.status}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center text-muted" style="font-size: 0.72rem;">
                            <span>${o.date}</span>
                            <strong class="text-dark">Q ${o.total.toFixed(2)}</strong>
                        </div>
                    </div>
                `;
            }).join('');
        }
    }

    // 1. CASO: No hay ningún pedido en el sistema
    if (!order) {
        if (cardEl) cardEl.classList.add('d-none');
        if (selectorWrapper) selectorWrapper.classList.add('d-none');
        if (emptyEl) {
            emptyEl.classList.remove('d-none');
            const isGuest = !AppState.currentUser;
            emptyEl.innerHTML = `
                <div class="d-inline-flex p-4 rounded-circle bg-pink-subtle text-wine mb-3">
                    <i class="bi ${isGuest ? 'bi-person-lock' : 'bi-bag-x'} fs-1"></i>
                </div>
                <h3 class="fw-bold text-wine mb-2">
                    ${isGuest ? 'Inicia sesión para ver tus pedidos' : 'No tienes pedidos activos en esta cuenta'}
                </h3>
                <p class="text-muted small mb-4 mx-auto" style="max-width: 480px;">
                    ${isGuest 
                        ? 'Para rastrear tus compras y consultar tu historial de pedidos, inicia sesión con tu cuenta de cliente.' 
                        : `Hola ${AppState.currentUser.shortName || AppState.currentUser.name}, actualmente no tienes pedidos registrados en esta cuenta. Puedes explorar el catálogo para comprar o cargar pedidos de prueba.`}
                </p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    ${isGuest ? `
                        <button class="btn-pill-primary px-4 py-2" onclick="openLoginModal()">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                        </button>
                        <button class="btn-pill-outline px-4 py-2" onclick="switchView('catalogo')">
                            <i class="bi bi-bag-plus me-1"></i> Explorar Catálogo
                        </button>
                    ` : `
                        <button class="btn-pill-primary px-4 py-2" onclick="switchView('catalogo')">
                            <i class="bi bi-bag-plus me-1"></i> Explorar Catálogo
                        </button>
                        <button class="btn-pill-outline px-4 py-2" onclick="restoreDemoOrders()">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Cargar Pedidos Demo
                        </button>
                    `}
                </div>
            `;
        }
        return;
    }

    // 2. CASO: Hay pedidos registrados
    if (cardEl) cardEl.classList.remove('d-none');
    if (selectorWrapper) selectorWrapper.classList.remove('d-none');
    if (emptyEl) emptyEl.classList.add('d-none');

    // Renderizar Selector / Tabs de Pedidos
    if (totalCountBadge) {
        totalCountBadge.innerText = `${AppState.orders.length} ${AppState.orders.length === 1 ? 'Pedido' : 'Pedidos Activos'}`;
    }

    if (tabsContainer) {
        tabsContainer.innerHTML = AppState.orders.map(o => {
            const isSel = (o.id === order.id);
            let badgeClass = 'bg-lavender text-wine';
            if (o.status === 'Cancelado') badgeClass = 'bg-danger text-white';
            else if (o.status === 'Despachado') badgeClass = 'bg-primary text-white';
            else if (o.status === 'Entregado') badgeClass = 'bg-success text-white';

            return `
                <button type="button" class="order-tab-btn ${isSel ? 'active' : ''}" onclick="selectOrder('${o.id}')">
                    <i class="bi ${isSel ? 'bi-check-circle-fill' : 'bi-box-seam'}"></i>
                    <span>#${o.id}</span>
                    <span class="badge ${badgeClass} rounded-pill">${o.status}</span>
                    <span class="small opacity-75 ms-1">Q ${o.total.toFixed(2)}</span>
                </button>
            `;
        }).join('');
    }

    // Actualizar encabezados y datos del pedido activo
    const titleEl = document.getElementById('orderStatusTitle');
    const clientEl = document.getElementById('orderStatusClient');
    const guideEl = document.getElementById('orderTrackingGuide');
    const methodEl = document.getElementById('orderShippingMethod');
    const dateEl = document.getElementById('orderEstimatedDate');
    const badgeEl = document.getElementById('orderStatusBadge');
    const noticeEl = document.getElementById('orderStatusNotice');
    const stepperWrapper = document.getElementById('orderStepperWrapper');
    const btnCancel = document.getElementById('btnCancelOrder');
    const actionNote = document.getElementById('orderActionNote');

    if (titleEl) titleEl.innerText = `Estado del Pedido #${order.id}`;
    if (clientEl) clientEl.innerText = `Cliente: ${AppState.client.shortName} | Dirección: ${AppState.client.address}`;
    if (guideEl) guideEl.innerText = order.trackingGuide;
    if (methodEl) methodEl.innerText = order.shippingMethod;
    if (dateEl) dateEl.innerText = order.estimatedDelivery;

    // Si el pedido actual está CANCELADO
    if (order.status === 'Cancelado') {
        if (badgeEl) {
            badgeEl.className = 'badge bg-danger text-white fs-6 px-3 py-2 rounded-pill';
            badgeEl.innerHTML = '<i class="bi bi-x-circle me-1"></i> Cancelado';
        }

        if (noticeEl) {
            noticeEl.innerHTML = `
                <div class="alert alert-danger d-flex align-items-center mb-4 rounded-4 shadow-sm border-danger" role="alert">
                    <i class="bi bi-x-octagon-fill fs-2 text-danger me-3 flex-shrink-0"></i>
                    <div class="flex-grow-1">
                        <strong class="d-block text-danger fs-6">Este pedido fue cancelado</strong>
                        <span class="small text-muted">
                            <strong>Motivo:</strong> ${order.cancellationReason || 'Cancelado a solicitud del cliente'}<br>
                            ${order.cancellationNotes ? `<strong>Detalles:</strong> ${order.cancellationNotes}<br>` : ''}
                            <span class="text-secondary"><i class="bi bi-clock me-1"></i> Cancelado el: ${order.cancelledAt || 'Hoy'}</span>
                        </span>
                    </div>
                </div>
            `;
        }

        if (stepperWrapper) {
            stepperWrapper.style.opacity = '0.35';
            stepperWrapper.style.filter = 'grayscale(1)';
        }

        const stepNodes = document.querySelectorAll('.step-node');
        stepNodes.forEach(node => node.classList.remove('completed', 'active'));
        const progressFill = document.getElementById('stepperProgressBar');
        if (progressFill) progressFill.style.width = '0%';

        if (btnCancel) btnCancel.classList.add('d-none');
        if (actionNote) actionNote.innerText = 'Este pedido se encuentra cancelado. Puedes eliminar el registro si deseas retirarlo de tu vista.';

    } else {
        // Pedido ACTIVO NORMAL (En preparación, Despachado, etc.)
        if (badgeEl) {
            let badgeClass = 'badge-stock bg-lavender text-wine fs-6 px-3 py-2';
            if (order.status === 'Despachado') badgeClass = 'badge bg-primary text-white fs-6 px-3 py-2 rounded-pill';
            badgeEl.className = badgeClass;
            badgeEl.innerHTML = `<i class="bi bi-clock-history me-1"></i> ${order.status}`;
        }
        if (noticeEl) noticeEl.innerHTML = '';

        if (stepperWrapper) {
            stepperWrapper.style.opacity = '1';
            stepperWrapper.style.filter = 'none';
        }

        // Stepper
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

        if (btnCancel) {
            btnCancel.classList.remove('d-none');
            if (order.step >= 3) {
                btnCancel.disabled = true;
                btnCancel.title = 'No se puede cancelar porque el pedido ya está en ruta.';
            } else {
                btnCancel.disabled = false;
                btnCancel.removeAttribute('title');
            }
        }
        if (actionNote) actionNote.innerText = 'Gestión del pedido: Puedes cancelar o eliminar este pedido.';
    }

    // Renderizar Productos Específicos de este Pedido
    const itemsBody = document.getElementById('orderItemsTableBody');
    const totalPaidEl = document.getElementById('orderTotalPaid');
    if (totalPaidEl) totalPaidEl.innerText = `Q ${order.total.toFixed(2)}`;

    if (itemsBody) {
        if (!order.items || order.items.length === 0) {
            itemsBody.innerHTML = '<div class="p-3 text-muted text-center small">No hay detalle de productos para este pedido.</div>';
        } else {
            itemsBody.innerHTML = order.items.map(it => {
                const itemThumb = it.image 
                    ? `<img src="${it.image}" alt="Foto" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">`
                    : `<i class="bi ${it.icon || 'bi-box-seam'}"></i>`;
                return `
                <div class="table-custom-row">
                    <div class="col-cart-product">
                        <div class="thumb-box overflow-hidden">${itemThumb}</div>
                        <div>
                            <h6 class="item-info-title">${it.nombre}</h6>
                            <p class="item-info-desc">${it.descripcion || ''}</p>
                        </div>
                    </div>
                    <div class="col-cart-qty text-center"><span class="qty-number">${it.qty}</span></div>
                    <div class="col-cart-price">Q ${it.precio.toFixed(2)}</div>
                    <div class="col-cart-subtotal">Q ${(it.precio * it.qty).toFixed(2)}</div>
                </div>
            `}).join('');
        }
    }
}

// ============================================================================
// GESTIÓN INTERACTIVA: CANCELAR Y ELIMINAR PEDIDO CON MODALES
// ============================================================================

// Abrir modal interactivo de cancelación
function openCancelOrderModal() {
    const order = getCurrentOrder();
    if (!order) {
        showToast('No tienes ningún pedido activo para cancelar.', 'toast-alert');
        return;
    }

    if (order.status === 'Cancelado') {
        showToast('Este pedido ya se encuentra cancelado.', 'toast-alert');
        return;
    }

    if (order.step >= 3) {
        showToast('El pedido ya fue despachado y no puede cancelarse desde la plataforma.', 'toast-alert');
        return;
    }

    // Actualizar datos del modal
    const codeEl = document.getElementById('cancelModalOrderCode');
    if (codeEl) codeEl.innerText = `#${order.id}`;

    const selectEl = document.getElementById('cancelReasonSelect');
    if (selectEl) selectEl.value = '';

    const notesEl = document.getElementById('cancelModalNotes');
    if (notesEl) notesEl.value = '';

    const validationMsg = document.getElementById('cancelReasonValidationMsg');
    if (validationMsg) validationMsg.classList.add('d-none');

    // Mostrar modal con Bootstrap
    const modalEl = document.getElementById('cancelOrderModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

// Confirmar cancelación del pedido
function confirmOrderCancellation() {
    const order = getCurrentOrder();
    if (!order) return;

    const selectEl = document.getElementById('cancelReasonSelect');
    const reason = selectEl ? selectEl.value : '';
    const validationMsg = document.getElementById('cancelReasonValidationMsg');

    if (!reason) {
        if (validationMsg) validationMsg.classList.remove('d-none');
        if (selectEl) selectEl.focus();
        showToast('Por favor selecciona un motivo para cancelar el pedido.', 'toast-alert');
        return;
    }

    const notesEl = document.getElementById('cancelModalNotes');
    const notes = notesEl ? notesEl.value.trim() : '';

    // Actualizar estado del pedido específico
    order.status = 'Cancelado';
    order.step = 0;
    order.cancellationReason = reason;
    order.cancellationNotes = notes;
    order.cancelledAt = new Date().toLocaleDateString('es-GT', { 
        year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit' 
    });

    saveOrders();

    // Cerrar modal de forma segura y remover backdrop
    const modalEl = document.getElementById('cancelOrderModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.hide();
    }
    limpiarModalesBootstrap();

    // Actualizar vista
    renderOrderStatus();
    showToast(`El pedido #${order.id} ha sido cancelado con éxito.`, 'toast-alert');
}

// Abrir modal de eliminación
function openDeleteOrderModal() {
    const order = getCurrentOrder();
    if (!order) {
        showToast('No tienes ningún pedido para eliminar.', 'toast-alert');
        return;
    }

    const codeEl = document.getElementById('deleteModalOrderCode');
    if (codeEl) codeEl.innerText = `#${order.id}`;

    const modalEl = document.getElementById('deleteOrderModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

// Confirmar eliminación definitiva del pedido
function confirmOrderDeletion() {
    const order = getCurrentOrder();
    if (!order) return;
    const deletedId = order.id;

    // Eliminar de memoria y persistencia
    AppState.orders = AppState.orders.filter(o => o.id !== deletedId);
    if (AppState.orders.length > 0) {
        AppState.selectedOrderId = AppState.orders[0].id;
    } else {
        AppState.selectedOrderId = null;
    }

    saveOrders();

    // Cerrar modal de forma segura
    const modalEl = document.getElementById('deleteOrderModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.hide();
    }
    limpiarModalesBootstrap();

    // Actualizar vista
    renderOrderStatus();
    showToast(`El pedido #${deletedId} fue eliminado correctamente.`, 'toast-success');
}

// Función auxiliar para asegurar que ningún backdrop quede pegado
function limpiarModalesBootstrap() {
    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    document.body.classList.remove('modal-open');
    document.body.style.removeProperty('overflow');
    document.body.style.removeProperty('padding-right');
}

// Restaurar pedidos de demostración para pruebas
function restoreDemoOrders() {
    if (AppState.currentUser) {
        const email = AppState.currentUser.email.toLowerCase().trim();
        localStorage.removeItem(getUserStorageKey('orders', email));
        localStorage.removeItem(getUserStorageKey('selected_order_id', email));
        loadUserDataForAccount(AppState.currentUser);
        renderOrderStatus();
        showToast('Pedidos de demostración restaurados para esta cuenta.', 'toast-pink');
    } else {
        loginDemoAccount();
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
    const previewEl = document.getElementById('photoPreview');
    const uploadedImageSrc = (previewEl && previewEl.style.display !== 'none' && previewEl.src) ? previewEl.src : null;

    let price = 45.00;
    if (paperType.includes('Arroz')) price = 35.00;
    if (paperType.includes('Discos')) price = 40.00;

    const customProduct = {
        id: Date.now(), // ID temporal
        categoriaId: 3,
        categoriaNombre: "Impresiones Personalizadas",
        nombre: `Impresión en ${paperType}`,
        descripcion: dedication,
        precio: price,
        stock: 99,
        disponibilidad: "entrega_inmediata",
        tag: "Personalizado",
        tagClass: "badge-tag-servicio",
        bgClass: "bg-lavender",
        placeholder: "Impresión Foto",
        icon: "bi-cake2",
        image: uploadedImageSrc
    };

    AppState.products.push(customProduct);

    addToCart(customProduct.id, qty, dedication, uploadedImageSrc);

    // Cerrar modal de forma segura
    const modalEl = document.getElementById('uploadPhotoModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    limpiarModalesBootstrap();

    showToast('¡Tu impresión comestible personalizada fue agregada al carrito!', 'toast-success');
    switchView('carrito');
}

// ============================================================================
// CHECKOUT / CONFIRMACIÓN DE PEDIDO
// ============================================================================
function confirmCheckoutOrder() {
    if (!AppState.currentUser) {
        showToast('Debes iniciar sesión con tu cuenta para confirmar y rastrear tu pedido.', 'toast-alert');
        openLoginModal();
        return;
    }

    if (AppState.cart.length === 0) {
        showToast('Tu carrito está vacío. Agrega productos antes de confirmar.', 'toast-alert');
        return;
    }

    const orderNum = Math.floor(Math.random() * 90) + 10;
    const orderId = `PED-2026-0${orderNum}`;
    
    // Convertir productos del carrito al detalle del nuevo pedido
    const orderItems = AppState.cart.map(item => {
        const prod = AppState.products.find(p => p.id === item.id) || {
            nombre: "Producto Comestible",
            descripcion: "",
            precio: 0,
            icon: "bi-box-seam"
        };
        return {
            nombre: prod.nombre,
            descripcion: item.customNote || prod.descripcion,
            qty: item.qty,
            precio: prod.precio,
            icon: prod.icon || "bi-box-seam",
            image: item.image || prod.image || null
        };
    });

    const subtotal = orderItems.reduce((acc, it) => acc + (it.precio * it.qty), 0);
    const discount = AppState.coupon ? AppState.discountAmount : 0;
    let shipping = 0;
    let codFee = 0;

    if (AppState.shippingMethod === 'tienda') {
        shipping = 0.00;
        codFee = 0.00;
    } else if (AppState.shippingMethod === 'domicilio') {
        shipping = AppState.shippingCost;
        codFee = 0.00;
    } else if (AppState.shippingMethod === 'departamental') {
        if (AppState.deptMethod === 'forza_prepago') {
            shipping = 35.00;
            codFee = 0.00;
        } else if (AppState.deptMethod === 'contra_entrega') {
            shipping = 45.00;
            codFee = Math.round((subtotal * 0.05) * 100) / 100;
        } else if (AppState.deptMethod === 'por_cobrar') {
            shipping = 0.00;
            codFee = 0.00;
        }
    }

    const total = Math.max(0, subtotal + shipping + codFee - discount);

    // Determinar método de entrega y tiempo estimado según la selección
    let orderShippingMethod = "Entrega Local Ciudad de Guatemala";
    let orderEstimatedDelivery = "Hoy a las 4:30 PM";

    if (AppState.shippingMethod === 'tienda') {
        orderShippingMethod = "Recoger en Taller (Zona 10) / Mandará Uber Propio (Previo Depósito)";
        orderEstimatedDelivery = "Listo para recoger hoy a las 2:00 PM";
    } else if (AppState.shippingMethod === 'departamental') {
        const depto = AppState.deptDepartment || 'Quetzaltenango';
        const muni = AppState.deptMunicipality ? ` - ${AppState.deptMunicipality}` : '';

        if (AppState.deptMethod === 'forza_prepago') {
            orderShippingMethod = `Envío Departamental: Guía Prepago Forza Express a ${depto}${muni} [Previo Depósito]`;
            orderEstimatedDelivery = "1 a 2 días hábiles (Forza)";
        } else if (AppState.deptMethod === 'contra_entrega') {
            orderShippingMethod = `Envío Departamental: Guatex / Forza COD a ${depto}${muni} [Pago Contra Entrega + 5% comisión: Q ${codFee.toFixed(2)}]`;
            orderEstimatedDelivery = "1 a 2 días hábiles (Pago al recibir)";
        } else {
            orderShippingMethod = `Envío Departamental: Flete por Cobrar en Agencia a ${depto}${muni}`;
            orderEstimatedDelivery = "1 a 3 días hábiles (Flete pagadero en agencia)";
        }
    } else {
        const zoneSelect = document.getElementById('deliveryZoneSelect');
        const zoneName = zoneSelect ? zoneSelect.options[zoneSelect.selectedIndex].text.split('-')[0].trim() : 'Zona Local';
        orderShippingMethod = `Mensajería Local (${zoneName})`;
        if (AppState.shippingNotes) {
            orderShippingMethod += ` - Ref: ${AppState.shippingNotes}`;
        }
    }

    const newOrder = {
        id: orderId,
        status: "En Preparación",
        step: 2,
        trackingGuide: `GT-EXPRESS-${Math.floor(Math.random() * 90000) + 10000}`,
        shippingMethod: orderShippingMethod,
        estimatedDelivery: orderEstimatedDelivery,
        date: new Date().toLocaleDateString('es-GT'),
        total: total,
        items: orderItems
    };

    // Agregar el nuevo pedido a la lista de pedidos activos
    AppState.orders.unshift(newOrder);
    AppState.selectedOrderId = orderId;
    saveOrders();

    // Vaciar carrito
    AppState.cart = [];
    saveCart();
    updateHeaderCounters();

    // Mostrar modal de confirmación
    const modalEl = document.getElementById('orderConfirmedModal');
    const orderNumberEl = document.getElementById('modalConfirmedOrderNumber');
    if (orderNumberEl) orderNumberEl.innerText = `#${orderId}`;

    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
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
    let shipping = 0;
    let codFee = 0;

    if (subtotal > 0) {
        if (AppState.shippingMethod === 'tienda') {
            shipping = 0.00;
        } else if (AppState.shippingMethod === 'domicilio') {
            shipping = AppState.shippingCost;
        } else if (AppState.shippingMethod === 'departamental') {
            if (AppState.deptMethod === 'forza_prepago') {
                shipping = 35.00;
            } else if (AppState.deptMethod === 'contra_entrega') {
                shipping = 45.00;
                codFee = Math.round((subtotal * 0.05) * 100) / 100;
            } else if (AppState.deptMethod === 'por_cobrar') {
                shipping = 0.00;
            }
        }
    }

    const total = Math.max(0, subtotal + shipping + codFee - discount);

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
// GESTIÓN DE AUTENTICACIÓN (LOGIN, LOGOUT, REGISTRO)
// ============================================================================

function saveCurrentUser() {
    if (AppState.currentUser) {
        localStorage.setItem('dulce_user', JSON.stringify(AppState.currentUser));
    } else {
        localStorage.setItem('dulce_user', 'null');
    }
}

function updateAuthUI() {
    const user = AppState.currentUser;
    const headerLogged = document.getElementById('headerUserLogged');
    const headerGuest = document.getElementById('headerUserGuest');
    const headerName = document.getElementById('headerUserName');
    
    // Offcanvas usuario
    const offcanvasLogged = document.getElementById('offcanvasUserLoggedSection');
    const offcanvasGuest = document.getElementById('offcanvasUserGuestSection');
    const profileName = document.getElementById('profileOffcanvasName');
    const profileEmail = document.getElementById('profileOffcanvasEmail');
    const profileAddress = document.getElementById('profileOffcanvasAddress');
    const profilePhone = document.getElementById('profileOffcanvasPhone');

    // Offcanvas móvil
    const mobileLogged = document.getElementById('mobileUserLoggedSection');
    const mobileGuest = document.getElementById('mobileUserGuestSection');
    const mobileName = document.getElementById('mobileUserName');

    if (user) {
        // Estado AUTENTICADO
        if (headerLogged) headerLogged.classList.remove('d-none');
        if (headerGuest) {
            headerGuest.classList.remove('d-flex');
            headerGuest.classList.add('d-none');
        }
        if (headerName) headerName.innerText = user.shortName || user.name;

        if (offcanvasLogged) offcanvasLogged.classList.remove('d-none');
        if (offcanvasGuest) offcanvasGuest.classList.add('d-none');
        if (profileName) profileName.innerText = user.name;
        if (profileEmail) profileEmail.innerText = user.email;
        if (profileAddress) profileAddress.innerText = user.address || 'Guatemala';
        if (profilePhone) profilePhone.innerHTML = `<i class="bi bi-telephone me-1"></i> ${user.phone || '+502 5555-1234'}`;

        if (mobileLogged) mobileLogged.classList.remove('d-none');
        if (mobileGuest) mobileGuest.classList.add('d-none');
        if (mobileName) mobileName.innerText = user.shortName || user.name;
    } else {
        // Estado INVITADO (NO AUTENTICADO)
        if (headerLogged) headerLogged.classList.add('d-none');
        if (headerGuest) {
            headerGuest.classList.remove('d-none');
            headerGuest.classList.add('d-flex');
        }

        if (offcanvasLogged) offcanvasLogged.classList.add('d-none');
        if (offcanvasGuest) offcanvasGuest.classList.remove('d-none');

        if (mobileLogged) mobileLogged.classList.add('d-none');
        if (mobileGuest) mobileGuest.classList.remove('d-none');
    }
}

// Abrir modal de Login
function openLoginModal() {
    // Renderizar cuentas guardadas
    renderSavedAccounts();

    const offcanvasEl = document.getElementById('userProfileOffcanvas');
    if (offcanvasEl) {
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if (offcanvas) offcanvas.hide();
    }
    const mobileOffcanvasEl = document.getElementById('mobileMenuOffcanvas');
    if (mobileOffcanvasEl) {
        const mobileOffcanvas = bootstrap.Offcanvas.getInstance(mobileOffcanvasEl);
        if (mobileOffcanvas) mobileOffcanvas.hide();
    }

    const modalEl = document.getElementById('authLoginModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

// Renderizar Cuentas Guardadas en el Navegador (Multi-cuenta switcher)
function renderSavedAccounts() {
    const container = document.getElementById('savedAccountsContainer');
    if (!container) return;

    if (!AppState.savedAccounts || AppState.savedAccounts.length === 0) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = `
        <div class="mb-3 p-2 bg-light rounded-3 border">
            <div class="d-flex justify-content-between align-items-center mb-2 px-1">
                <span class="small fw-bold text-wine" style="font-size: 0.78rem;">
                    <i class="bi bi-people-fill me-1"></i> Cuentas guardadas en este equipo:
                </span>
                <span class="badge bg-white text-muted border">${AppState.savedAccounts.length}</span>
            </div>
            ${AppState.savedAccounts.map(acc => {
                const isCurrent = AppState.currentUser && AppState.currentUser.email.toLowerCase() === acc.email.toLowerCase();
                return `
                <div class="saved-account-card ${isCurrent ? 'border-primary' : ''}">
                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                        <div class="rounded-circle bg-pink-soft text-wine d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 30px; height: 30px; font-size: 0.8rem;">
                            ${(acc.shortName || acc.name || 'U').charAt(0)}
                        </div>
                        <div class="text-truncate">
                            <strong class="d-block small text-dark text-truncate" style="line-height: 1.1;">
                                ${acc.name} ${isCurrent ? '<span class="badge bg-success-subtle text-success ms-1" style="font-size: 0.65rem;">En uso</span>' : ''}
                            </strong>
                            <span class="small text-muted text-truncate" style="font-size: 0.72rem;">${acc.email}</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-1 flex-shrink-0">
                        ${!isCurrent ? `
                            <button type="button" class="btn btn-sm btn-pill-primary py-1 px-2" style="font-size: 0.72rem;" onclick="loginWithSavedAccount('${acc.email}')">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Cambiar
                            </button>
                        ` : `
                            <span class="text-success small px-2 fw-bold" style="font-size: 0.70rem;"><i class="bi bi-check-circle-fill me-1"></i>Activa</span>
                        `}
                        <button type="button" class="btn btn-sm text-danger border-0 p-1" onclick="removeSavedAccount('${acc.email}')" title="Quitar cuenta de este equipo">
                            <i class="bi bi-trash3" style="font-size: 0.8rem;"></i>
                        </button>
                    </div>
                </div>
            `}).join('')}
            <div class="text-center my-2 position-relative">
                <hr class="text-muted opacity-25 m-0">
                <span class="position-absolute top-50 start-50 translate-middle bg-light px-2 small text-muted" style="font-size: 0.68rem;">o ingresa con otra cuenta:</span>
            </div>
        </div>
    `;
}

function saveToSavedAccounts(user) {
    if (!user || !user.email) return;
    const existingIdx = AppState.savedAccounts.findIndex(a => a.email.toLowerCase() === user.email.toLowerCase());
    if (existingIdx >= 0) {
        AppState.savedAccounts[existingIdx] = { ...user };
    } else {
        AppState.savedAccounts.unshift({ ...user });
    }
    localStorage.setItem('dulce_saved_accounts', JSON.stringify(AppState.savedAccounts));
}

function loginWithSavedAccount(email) {
    const acc = AppState.savedAccounts.find(a => a.email.toLowerCase() === email.toLowerCase());
    if (!acc) return;

    // 1. Guardar los datos de la cuenta previa antes de cambiar
    if (AppState.currentUser && AppState.currentUser.email.toLowerCase() !== email.toLowerCase()) {
        saveCurrentUserData();
    }

    // 2. Establecer la nueva cuenta
    AppState.currentUser = { ...acc };
    saveCurrentUser();

    // 3. Cargar los datos aislados correspondientes a ESTA cuenta
    loadUserDataForAccount(AppState.currentUser);

    // 4. Cerrar modal de login
    const modalEl = document.getElementById('authLoginModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    limpiarModalesBootstrap();

    // 5. Re-renderizar todas las vistas
    updateAuthUI();
    renderCart();
    renderWishlist();
    renderOrderStatus();
    updateHeaderCounters();

    showToast(`¡Sesión cambiada a ${acc.shortName || acc.name}! Datos cargados.`, 'toast-success');
}

function removeSavedAccount(email) {
    const clean = email.toLowerCase();
    AppState.savedAccounts = AppState.savedAccounts.filter(a => a.email.toLowerCase() !== clean);
    localStorage.setItem('dulce_saved_accounts', JSON.stringify(AppState.savedAccounts));

    if (AppState.currentUser && AppState.currentUser.email.toLowerCase() === clean) {
        handleLogout();
    } else {
        renderSavedAccounts();
    }
    showToast('Cuenta quitada de la lista guardada.', 'toast-alert');
}

// Abrir modal de Registro
function openRegisterModal() {
    const offcanvasEl = document.getElementById('userProfileOffcanvas');
    if (offcanvasEl) {
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if (offcanvas) offcanvas.hide();
    }
    const mobileOffcanvasEl = document.getElementById('mobileMenuOffcanvas');
    if (mobileOffcanvasEl) {
        const mobileOffcanvas = bootstrap.Offcanvas.getInstance(mobileOffcanvasEl);
        if (mobileOffcanvas) mobileOffcanvas.hide();
    }

    const modalEl = document.getElementById('authRegisterModal');
    if (modalEl) {
        const modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    }
}

// Alternar entre modales
function switchToRegisterModal() {
    const loginModalEl = document.getElementById('authLoginModal');
    if (loginModalEl) {
        bootstrap.Modal.getOrCreateInstance(loginModalEl).hide();
    }
    limpiarModalesBootstrap();
    setTimeout(() => openRegisterModal(), 200);
}

function switchToLoginModal() {
    const regModalEl = document.getElementById('authRegisterModal');
    if (regModalEl) {
        bootstrap.Modal.getOrCreateInstance(regModalEl).hide();
    }
    const forgotModalEl = document.getElementById('authForgotPasswordModal');
    if (forgotModalEl) {
        bootstrap.Modal.getOrCreateInstance(forgotModalEl).hide();
    }
    limpiarModalesBootstrap();
    setTimeout(() => openLoginModal(), 200);
}

// Modal de Recuperación / Restablecimiento de Contraseña
function openForgotPasswordModal() {
    const loginModalEl = document.getElementById('authLoginModal');
    if (loginModalEl) {
        bootstrap.Modal.getOrCreateInstance(loginModalEl).hide();
    }
    limpiarModalesBootstrap();

    const step1 = document.getElementById('forgotStep1');
    const step2 = document.getElementById('forgotStep2');
    if (step1) step1.classList.remove('d-none');
    if (step2) step2.classList.add('d-none');

    const emailInput = document.getElementById('forgotEmail');
    if (emailInput) emailInput.value = '';

    const modalEl = document.getElementById('authForgotPasswordModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).show();
    }
}

function handleSendResetCode(event) {
    if (event) event.preventDefault();
    const email = document.getElementById('forgotEmail')?.value.trim();
    if (!email) {
        showToast('Por favor ingresa tu correo electrónico.', 'toast-alert');
        return;
    }

    const step1 = document.getElementById('forgotStep1');
    const step2 = document.getElementById('forgotStep2');
    const emailDisplay = document.getElementById('forgotEmailDisplay');

    if (emailDisplay) emailDisplay.innerText = email;
    if (step1) step1.classList.add('d-none');
    if (step2) step2.classList.remove('d-none');

    showToast(`Código de verificación simulado (582419) enviado a ${email}.`, 'toast-pink');
}

function handleSaveNewPassword(event) {
    if (event) event.preventDefault();
    const code = document.getElementById('resetVerificationCode')?.value.trim();
    const newPass = document.getElementById('resetNewPassword')?.value;
    const confirmPass = document.getElementById('resetConfirmPassword')?.value;
    const email = document.getElementById('forgotEmailDisplay')?.innerText || '';

    if (code !== '582419') {
        showToast('Código incorrecto. Utiliza 582419 para la demostración.', 'toast-alert');
        return;
    }

    if (!newPass || newPass.length < 6) {
        showToast('La nueva contraseña debe tener al menos 6 caracteres.', 'toast-alert');
        return;
    }

    if (newPass !== confirmPass) {
        showToast('Las contraseñas no coinciden. Verifícalas.', 'toast-alert');
        return;
    }

    // Actualizar contraseña si la cuenta estaba guardada
    const acc = AppState.savedAccounts.find(a => a.email.toLowerCase() === email.toLowerCase());
    if (acc) {
        acc.password = newPass;
        localStorage.setItem('dulce_saved_accounts', JSON.stringify(AppState.savedAccounts));
    }

    const modalEl = document.getElementById('authForgotPasswordModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    limpiarModalesBootstrap();

    showToast('¡Contraseña actualizada con éxito! Ahora puedes ingresar.', 'toast-success');
    setTimeout(() => openLoginModal(), 300);
}

// Procesar inicio de sesión
function handleLogin(event) {
    if (event) event.preventDefault();

    const email = document.getElementById('loginEmail')?.value.trim();
    const password = document.getElementById('loginPassword')?.value;

    if (!email || !password) {
        showToast('Por favor completa todos los campos para iniciar sesión.', 'toast-alert');
        return;
    }

    // 1. Guardar los datos de la cuenta activa previa si existía
    if (AppState.currentUser && AppState.currentUser.email.toLowerCase() !== email.toLowerCase()) {
        saveCurrentUserData();
    }

    // 2. Buscar si ya estaba en savedAccounts o crear nuevo perfil
    const existingAcc = AppState.savedAccounts.find(a => a.email.toLowerCase() === email.toLowerCase());

    if (existingAcc) {
        AppState.currentUser = { ...existingAcc };
    } else if (email.toLowerCase().includes('nohelia')) {
        AppState.currentUser = {
            id: 1,
            name: "Nohelia Mishelle Barillas",
            shortName: "Nohelia Barillas",
            email: "nohelia.barillas@ejemplo.com",
            address: "5ta Calle 12-45 Zona 10, Edificio Las Flores, Guatemala",
            phone: "+502 5555-1234"
        };
    } else {
        const extractedName = email.split('@')[0].replace(/[._]/g, ' ');
        const capitalized = extractedName.charAt(0).toUpperCase() + extractedName.slice(1);
        AppState.currentUser = {
            id: Date.now(),
            name: capitalized,
            shortName: capitalized.split(' ')[0],
            email: email,
            address: "Ciudad de Guatemala",
            phone: "+502 5555-0000"
        };
    }

    // Guardar en sesión activa y en la lista de cuentas guardadas
    saveCurrentUser();
    saveToSavedAccounts(AppState.currentUser);

    // 3. Cargar datos específicos e independientes de esta cuenta
    loadUserDataForAccount(AppState.currentUser);

    const modalEl = document.getElementById('authLoginModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    limpiarModalesBootstrap();

    updateAuthUI();
    renderCart();
    renderWishlist();
    renderOrderStatus();
    updateHeaderCounters();
    showToast(`¡Bienvenida/o de nuevo, ${AppState.currentUser.shortName}!`, 'toast-success');
}

// Inicio rápido con cuenta Demo (Nohelia)
function loginDemoAccount() {
    if (AppState.currentUser && AppState.currentUser.email.toLowerCase() !== DEMO_NOHELIA_EMAIL.toLowerCase()) {
        saveCurrentUserData();
    }

    AppState.currentUser = {
        id: 1,
        name: "Nohelia Mishelle Barillas",
        shortName: "Nohelia Barillas",
        email: "nohelia.barillas@ejemplo.com",
        address: "5ta Calle 12-45 Zona 10, Edificio Las Flores, Guatemala",
        phone: "+502 5555-1234"
    };

    saveCurrentUser();
    saveToSavedAccounts(AppState.currentUser);

    loadUserDataForAccount(AppState.currentUser);

    const modalEl = document.getElementById('authLoginModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    limpiarModalesBootstrap();

    updateAuthUI();
    renderCart();
    renderWishlist();
    renderOrderStatus();
    updateHeaderCounters();
    showToast('Sesión iniciada como Nohelia Barillas (Demo).', 'toast-pink');
}

// Procesar creación de nueva cuenta
function handleRegister(event) {
    if (event) event.preventDefault();

    const name = document.getElementById('registerName')?.value.trim();
    const email = document.getElementById('registerEmail')?.value.trim();
    const phone = document.getElementById('registerPhone')?.value.trim();
    const address = document.getElementById('registerAddress')?.value.trim();
    const pass = document.getElementById('registerPassword')?.value;
    const passConfirm = document.getElementById('registerPasswordConfirm')?.value;

    if (!name || !email || !pass) {
        showToast('Por favor completa los campos obligatorios (*).', 'toast-alert');
        return;
    }

    if (pass !== passConfirm) {
        showToast('Las contraseñas no coinciden. Verifícalas.', 'toast-alert');
        return;
    }

    // Guardar datos previos si existía sesión activa
    if (AppState.currentUser) {
        saveCurrentUserData();
    }

    // Registrar en AppState
    AppState.currentUser = {
        id: Date.now(),
        name: name,
        shortName: name.split(' ')[0],
        email: email,
        phone: phone || "+502 5555-0000",
        address: address || "Ciudad de Guatemala, Guatemala"
    };

    saveCurrentUser();
    saveToSavedAccounts(AppState.currentUser);

    // Cargar datos propios (como es nueva, inicia 100% limpia sin mezclar nada)
    loadUserDataForAccount(AppState.currentUser);

    // Intentar registrar en Backend CodeIgniter 4 si está disponible
    try {
        fetch(`${BackendService.baseUrl}/clientes/insertar`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                txt_nombre: name,
                txt_correo: email,
                txt_contrasenia: pass,
                txt_fecha_registro: new Date().toISOString().split('T')[0]
            })
        }).catch(() => {});
    } catch (e) {}

    const modalEl = document.getElementById('authRegisterModal');
    if (modalEl) {
        bootstrap.Modal.getOrCreateInstance(modalEl).hide();
    }
    limpiarModalesBootstrap();

    updateAuthUI();
    renderCart();
    renderWishlist();
    renderOrderStatus();
    updateHeaderCounters();
    showToast(`¡Cuenta creada con éxito! Bienvenida/o, ${AppState.currentUser.shortName}.`, 'toast-success');
}

// Cerrar sesión
function handleLogout() {
    const user = AppState.currentUser;
    const oldName = user ? (user.shortName || user.name) : 'Usuario';

    // 1. Guardar los datos de la cuenta activa antes de salir
    if (AppState.currentUser) {
        saveCurrentUserData();
    }

    // 2. Limpiar sesión en almacenamiento
    AppState.currentUser = null;
    saveCurrentUser();

    // 3. LIMPIAR COMPLETAMENTE TODO EL ESTADO EN MEMORIA (No hay cuenta activa)
    AppState.cart = [];
    AppState.wishlist = [];
    AppState.orders = [];
    AppState.selectedOrderId = null;
    AppState.shippingCost = 25.00;
    AppState.shippingMethod = 'domicilio';
    AppState.shippingNotes = '';
    AppState.codFee = 0.00;

    // 4. Cerrar offcanvas si está abierto
    const offcanvasEl = document.getElementById('userProfileOffcanvas');
    if (offcanvasEl) {
        const offcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
        if (offcanvas) offcanvas.hide();
    }
    const mobileOffcanvasEl = document.getElementById('mobileMenuOffcanvas');
    if (mobileOffcanvasEl) {
        const mobileOffcanvas = bootstrap.Offcanvas.getInstance(mobileOffcanvasEl);
        if (mobileOffcanvas) mobileOffcanvas.hide();
    }
    limpiarModalesBootstrap();

    // 5. Actualizar interfaz visual completa al estado limpio / vacío
    updateAuthUI();
    renderCart();
    renderWishlist();
    renderOrderStatus();
    updateHeaderCounters();

    showToast(`Hasta pronto, ${oldName}. Has cerrado sesión y se limpió la pantalla.`, 'toast-alert');
}

// ============================================================================
// INICIALIZACIÓN AL CARGAR LA PÁGINA
// ============================================================================
document.addEventListener('DOMContentLoaded', () => {
    // Cargar datos propios de la cuenta activa (o vacío si es invitado)
    loadUserDataForAccount(AppState.currentUser);
    updateAuthUI();
    renderCart();
    renderWishlist();
    renderOrderStatus();
    updateHeaderCounters();

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
    switchView(initialHash);
});

<?php
$paginaActual = 'admin';
$tituloPagina = 'Panel de Administración de Empleados';
require_once "header.php";

// ============================================================================
// SEGURIDAD: Lógica de protección idéntica a la captura de tu clase
// Si el tipo de usuario NO es empleado (tipo <> 2), se deniega el acceso
// ============================================================================
if (($tipoUsuario ?? 0) !== 2) {
    echo "<script>alert('Acceso restringido: Solo para empleados.'); window.location.href='index.php';</script>";
    exit;
}

require_once "clases/Pedidos.php";
require_once "clases/Productos.php";
require_once "clases/Usuarios.php";

$todosPedidos = Pedidos::obtenerPedidos($conexionMongo);
$todosProductos = Productos::obtenerProductos($conexionMongo);
$totalPedidos = count($todosPedidos);
$totalProductos = count($todosProductos);
?>

<div class="row g-4">
    <!-- Encabezado del Panel de Empleados -->
    <div class="col-12">
        <div class="content-card bg-wine text-white p-4 rounded-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-white text-wine px-3 py-1 rounded-pill fw-bold text-uppercase mb-2">
                        <i class="bi bi-shield-check me-1"></i> Panel Exclusivo de Empleados (Tipo 2)
                    </span>
                    <h2 class="h3 fw-bold mb-1">Bienvenido(a), <?= escapar($nombreUsuario) ?></h2>
                    <p class="mb-0 text-white-50 small">
                        Desde aquí puedes supervisar los módulos internos de la tienda, gestionar pedidos y acceder al backend.
                    </p>
                </div>
                <div>
                    <a href="objetos/cerrarSesion.php" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjetas de Resumen Rápido -->
    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-rose text-wine fs-3">
                    <i class="bi bi-bag-check"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Pedidos Registrados</span>
                    <h3 class="fw-bold mb-0 text-wine"><?= $totalPedidos ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-mint text-success fs-3">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Productos en Catálogo</span>
                    <h3 class="fw-bold mb-0"><?= $totalProductos ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-lavender text-primary fs-3">
                    <i class="bi bi-database"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Motor NoSQL</span>
                    <h6 class="fw-bold mb-0 text-primary">MongoDB 9.0</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-sand text-dark fs-3">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Tu Nivel de Acceso</span>
                    <h6 class="fw-bold mb-0">Empleado / Admin</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Módulos de Administración Internos -->
    <div class="col-lg-8">
        <div class="content-card p-4">
            <h4 class="card-title-lg mb-1"><i class="bi bi-kanban me-2 text-wine"></i>Módulos Administrativos del Sistema</h4>
            <p class="card-subtitle-muted mb-4">
                Listado de registros del sistema a los que un cliente regular no tiene acceso:
            </p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h6 class="fw-bold text-wine mb-1"><i class="bi bi-receipt me-1"></i> Control de Pedidos</h6>
                        <p class="small text-muted mb-2">Consulta los pedidos entrantes de los clientes en MongoDB.</p>
                        <a href="pedidos.php" class="btn btn-sm btn-pill-primary">Ver Pedidos</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h6 class="fw-bold text-wine mb-1"><i class="bi bi-grid-3x3-gap me-1"></i> Catálogo de Insumos</h6>
                        <p class="small text-muted mb-2">Revisar precios, stock y disponibilidad de productos.</p>
                        <a href="index.php" class="btn btn-sm btn-pill-outline">Ir al Catálogo</a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h6 class="fw-bold text-wine mb-1"><i class="bi bi-truck me-1"></i> Envíos y Entregas</h6>
                        <p class="small text-muted mb-2">Seguimiento de guías para entregas locales y nacionales.</p>
                        <span class="badge bg-secondary">Módulo Empleado</span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-3 bg-light h-100">
                        <h6 class="fw-bold text-wine mb-1"><i class="bi bi-people me-1"></i> Clientes y Cuentas</h6>
                        <p class="small text-muted mb-2">Usuarios registrados con rol tipo 1 (clientes).</p>
                        <span class="badge bg-secondary">Módulo Empleado</span>
                    </div>
                </div>
            </div>

            <!-- Enlace al CRUD de CodeIgniter 4 del Backend -->
            <div class="mt-4 p-3 bg-rose rounded-3 border d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h6 class="fw-bold text-wine mb-0"><i class="bi bi-terminal me-1"></i> Panel CRUD del Backend (CodeIgniter 4)</h6>
                    <small class="text-muted">Si deseas gestionar directamente las tablas de MySQL/CI4</small>
                </div>
                <a href="../backend/public/" target="_blank" class="btn btn-sm btn-pill-primary">
                    Abrir Backend CI4 <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
            </div>

        </div>
    </div>

    <!-- Sidebar Lateral de Empleado -->
    <div class="col-lg-4">
        <div class="summary-card p-4">
            <h5 class="summary-heading mb-3"><i class="bi bi-info-circle me-1"></i> ¿Cómo funciona tu rol?</h5>
            
            <div class="small text-muted mb-3">
                <p class="mb-2"><strong>Tipo 1 (Cliente):</strong> Solo puede ver la tienda pública, agregar productos a su carrito, guardar deseos y ver sus propios pedidos.</p>
                <p class="mb-0"><strong>Tipo 2 (Empleado):</strong> Eres tú. Tienes acceso a este panel de administración, a la revisión de pedidos y a la gestión del sistema.</p>
            </div>

            <div class="border-top pt-3">
                <h6 class="fw-bold text-wine mb-2">Accesos Directos Rápidos:</h6>
                <ul class="list-unstyled small mb-0">
                    <li class="py-1"><a href="pedidos.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-wine me-1"></i> Ver Todos los Pedidos</a></li>
                    <li class="py-1"><a href="index.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-wine me-1"></i> Ver Catálogo como Cliente</a></li>
                    <li class="py-1"><a href="conexion/seed_mongo.php" class="text-decoration-none text-dark"><i class="bi bi-chevron-right text-wine me-1"></i> Sincronizar Productos en MongoDB</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>

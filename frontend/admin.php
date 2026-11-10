<?php
$paginaActual = 'admin';
$tituloPagina = 'Panel de Administración de Empleados';
require_once "header.php";

if (!$estaAutenticado || !$esEmpleado) {
    echo "<script>alert('Acceso restringido: Esta sección es exclusiva para empleados.'); window.location.href='index.php';</script>";
    exit;
}

require_once "clases/Pedidos.php";
require_once "clases/Productos.php";
require_once "clases/Usuarios.php";

$todosProductos = Productos::obtenerProductos($conexionMySQL, $conexionMongo);
$categorias     = Productos::obtenerCategorias($conexionMySQL);
$todosPedidos   = Pedidos::obtenerPedidos($conexionMySQL, $conexionMongo);
$usuariosData   = Usuarios::obtenerUsuarios($conexionMySQL);

$totalPedidos   = count($todosPedidos);
$totalProductos = count($todosProductos);
$totalEmpleados = count($usuariosData['empleados']);
$totalClientes  = count($usuariosData['clientes']);
?>

<div class="row g-4">
    <div class="col-12">
        <div class="content-card bg-wine text-white p-4 rounded-4 shadow-sm">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div>
                    <span class="badge bg-white text-wine px-3 py-1 rounded-pill fw-bold text-uppercase mb-2">
                        <i class="bi bi-shield-check me-1"></i> Panel de Empleado & Administrador
                    </span>
                    <h2 class="h3 fw-bold mb-1">Bienvenido(a), <?= escapar($nombreUsuario) ?></h2>
                    <p class="mb-0 text-white-50 small">
                        Aquí puedes crear nuevos productos a través de formularios, modificar datos existentes y controlar pedidos.
                    </p>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="../backend/public/productos" class="btn btn-sm btn-light rounded-pill px-3 text-dark fw-bold shadow-sm">
                        <i class="bi bi-terminal me-1 text-primary"></i> Abrir Backend CI4
                    </a>
                    <a href="index.php" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="bi bi-eye me-1"></i> Ver Catálogo (Tienda)
                    </a>
                    <a href="objetos/cerrarSesion.php" class="btn btn-sm btn-outline-light rounded-pill px-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET['producto_creado'])): ?>
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <strong>¡Producto creado con éxito!</strong> El nuevo artículo ya está disponible en el catálogo de clientes.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['producto_actualizado'])): ?>
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show rounded-pill px-4 shadow-sm" role="alert">
                <i class="bi bi-pencil-square me-2 fs-5"></i>
                <strong>¡Datos modificados!</strong> El producto fue actualizado en la base de datos correctamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['producto_eliminado'])): ?>
        <div class="col-12">
            <div class="alert alert-warning alert-dismissible fade show rounded-pill px-4 shadow-sm" role="alert">
                <i class="bi bi-trash-fill me-2 fs-5"></i>
                <strong>¡Producto eliminado!</strong> El artículo ha sido retirado del catálogo.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['pedido_actualizado'])): ?>
        <div class="col-12">
            <div class="alert alert-primary alert-dismissible fade show rounded-pill px-4 shadow-sm" role="alert">
                <i class="bi bi-truck me-2 fs-5"></i>
                <strong>¡Estado de pedido actualizado!</strong> El cliente podrá ver el nuevo estado de su orden.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['usuario_creado'])): ?>
        <div class="col-12">
            <div class="alert alert-success alert-dismissible fade show rounded-pill px-4 shadow-sm" role="alert">
                <i class="bi bi-person-check-fill me-2 fs-5"></i>
                <strong>¡Usuario registrado!</strong> La cuenta ha sido creada exitosamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-mint text-success fs-3">
                    <i class="bi bi-box-seam"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Productos en Catálogo</span>
                    <h3 class="fw-bold mb-0 text-wine"><?= $totalProductos ?></h3>
                </div>
            </div>
        </div>
    </div>

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
                <div class="p-3 rounded-circle bg-lavender text-primary fs-3">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Clientes Registrados</span>
                    <h3 class="fw-bold mb-0 text-primary"><?= $totalClientes ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
            <div class="d-flex align-items-center gap-3">
                <div class="p-3 rounded-circle bg-sand text-dark fs-3">
                    <i class="bi bi-database-check"></i>
                </div>
                <div>
                    <span class="text-muted small d-block">Base de Datos</span>
                    <h6 class="fw-bold mb-0 text-success">MySQL Activo</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <ul class="nav nav-pills gap-2 p-2 bg-white rounded-4 shadow-sm" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-semibold" id="tab-productos-btn" data-bs-toggle="pill" data-bs-target="#tab-productos" type="button" role="tab">
                    <i class="bi bi-boxes me-2"></i> Gestión de Productos (CRUD)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold" id="tab-pedidos-btn" data-bs-toggle="pill" data-bs-target="#tab-pedidos" type="button" role="tab">
                    <i class="bi bi-receipt me-2"></i> Control de Pedidos (<?= $totalPedidos ?>)
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold" id="tab-usuarios-btn" data-bs-toggle="pill" data-bs-target="#tab-usuarios" type="button" role="tab">
                    <i class="bi bi-people me-2"></i> Usuarios del Sistema
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold" id="tab-conexiones-btn" data-bs-toggle="pill" data-bs-target="#tab-conexiones" type="button" role="tab">
                    <i class="bi bi-hdd-network me-2"></i> Conexiones & Backend CI4
                </button>
            </li>
        </ul>
    </div>

    <div class="col-12">
        <div class="tab-content" id="adminTabsContent">

            <div class="tab-pane fade show active" id="tab-productos" role="tabpanel">
                <div class="content-card p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                        <div>
                            <h4 class="card-title-lg mb-1"><i class="bi bi-box-seam me-2 text-wine"></i>Módulo de Catálogo & Modificación de Datos</h4>
                            <p class="card-subtitle-muted mb-0">
                                Como empleado puedes crear nuevos productos con el formulario o modificar los precios, stock y datos existentes.
                            </p>
                        </div>
                        <button type="button" class="btn btn-pill-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoProducto">
                            <i class="bi bi-plus-circle me-1"></i> Formulario: Crear Nuevo Producto
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Categoría</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Estado</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($todosProductos as $p): ?>
                                    <tr>
                                        <td class="fw-bold text-wine">#<?= $p['id'] ?></td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="p-2 rounded-3 bg-light text-wine fs-5">
                                                    <i class="bi <?= escapar($p['icono'] ?? 'bi-box-seam') ?>"></i>
                                                </div>
                                                <div>
                                                    <strong class="d-block text-dark"><?= escapar($p['nombre']) ?></strong>
                                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 280px;">
                                                        <?= escapar($p['descripcion']) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3">
                                                <?= escapar($p['categoria']) ?>
                                            </span>
                                        </td>
                                        <td class="fw-bold text-dark">
                                            Q <?= number_format((float)$p['precio'], 2) ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= (int)$p['stock'] > 10 ? 'bg-success' : 'bg-warning text-dark' ?> rounded-pill px-2">
                                                <?= (int)$p['stock'] ?> uds.
                                            </span>
                                        </td>
                                        <td>
                                            <?php if (($p['disponibilidad_num'] ?? 1) === 1 && (int)$p['stock'] > 0): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">
                                                    <i class="bi bi-check-circle me-1"></i> En Stock
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">
                                                    <i class="bi bi-x-circle me-1"></i> Agotado
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-end">
                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1" 
                                                    data-bs-toggle="modal" data-bs-target="#modalEditarProducto<?= $p['id'] ?>">
                                                <i class="bi bi-pencil me-1"></i> Modificar
                                            </button>
                                            
                                            <a href="objetos/eliminarProducto.php?id=<?= $p['id'] ?>" 
                                               class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                               onclick="return confirm('¿Seguro que deseas eliminar el producto <?= escapar($p['nombre']) ?>?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="modalEditarProducto<?= $p['id'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content rounded-4 border-0 shadow">
                                                <div class="modal-header bg-light rounded-top-4">
                                                    <h5 class="modal-title fw-bold text-wine">
                                                        <i class="bi bi-pencil-square me-1"></i> Modificar Producto #<?= $p['id'] ?>
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="objetos/guardarProducto.php" method="post">
                                                    <div class="modal-body p-4">
                                                        <input type="hidden" name="txt_id" value="<?= $p['id'] ?>">

                                                        <div class="mb-3">
                                                             <label class="form-label small fw-semibold text-muted">Nombre del Producto</label>
                                                            <input type="text" name="txt_nombre" class="form-control rounded-pill" 
                                                                   value="<?= escapar($p['nombre']) ?>" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold text-muted">Categoría</label>
                                                            <select name="txt_categoria_id" class="form-select rounded-pill" required>
                                                                <?php foreach ($categorias as $cat): ?>
                                                                    <option value="<?= $cat['id'] ?>" <?= ((int)($p['categoria_id'] ?? 1) === (int)$cat['id']) ? 'selected' : '' ?>>
                                                                        <?= escapar($cat['nombre']) ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="row g-2 mb-3">
                                                            <div class="col-6">
                                                                <label class="form-label small fw-semibold text-muted">Precio (Q)</label>
                                                                <input type="number" step="0.01" name="txt_precio" class="form-control rounded-pill" 
                                                                       value="<?= (float)$p['precio'] ?>" required>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label small fw-semibold text-muted">Stock Disponible</label>
                                                                <input type="number" name="txt_stock" class="form-control rounded-pill" 
                                                                       value="<?= (int)$p['stock'] ?>" required>
                                                            </div>
                                                        </div>

                                                        <div class="row g-2 mb-3">
                                                            <div class="col-6">
                                                                <label class="form-label small fw-semibold text-muted">Disponibilidad</label>
                                                                <select name="txt_disponibilidad" class="form-select rounded-pill">
                                                                    <option value="1" <?= (($p['disponibilidad_num'] ?? 1) === 1) ? 'selected' : '' ?>>En Stock</option>
                                                                    <option value="0" <?= (($p['disponibilidad_num'] ?? 1) === 0) ? 'selected' : '' ?>>Agotado</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label small fw-semibold text-muted">Ícono / Imagen</label>
                                                                <select name="txt_imagen" class="form-select rounded-pill">
                                                                    <option value="bi-file-earmark-richtext" <?= ($p['icono'] ?? '') === 'bi-file-earmark-richtext' ? 'selected' : '' ?>>Hojas Papel</option>
                                                                    <option value="bi-droplet-half" <?= ($p['icono'] ?? '') === 'bi-droplet-half' ? 'selected' : '' ?>>Tintas</option>
                                                                    <option value="bi-camera" <?= ($p['icono'] ?? '') === 'bi-camera' ? 'selected' : '' ?>>Impresión Foto</option>
                                                                    <option value="bi-printer" <?= ($p['icono'] ?? '') === 'bi-printer' ? 'selected' : '' ?>>Impresora</option>
                                                                    <option value="bi-circle" <?= ($p['icono'] ?? '') === 'bi-circle' ? 'selected' : '' ?>>Discos Cupcake</option>
                                                                    <option value="bi-wrench-adjustable" <?= ($p['icono'] ?? '') === 'bi-wrench-adjustable' ? 'selected' : '' ?>>Mantenimiento</option>
                                                                    <option value="bi-box-seam" <?= ($p['icono'] ?? '') === 'bi-box-seam' ? 'selected' : '' ?>>Caja General</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label small fw-semibold text-muted">Descripción</label>
                                                            <textarea name="txt_descripcion" rows="3" class="form-control rounded-3"><?= escapar($p['descripcion']) ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light rounded-bottom-4">
                                                        <button type="button" class="btn btn-pill-outline btn-sm" data-bs-dismiss="modal">Cancelar</button>
                                                        <button type="submit" class="btn btn-pill-primary btn-sm px-4">
                                                            <i class="bi bi-save me-1"></i> Guardar Cambios
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-pedidos" role="tabpanel">
                <div class="content-card p-4">
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                        <div>
                            <h4 class="card-title-lg mb-1"><i class="bi bi-receipt me-2 text-wine"></i>Control y Gestión de Pedidos de Clientes</h4>
                            <p class="card-subtitle-muted mb-0">
                                Revisa las órdenes enviadas por los clientes y cambia su estado de avance.
                            </p>
                        </div>
                    </div>

                    <?php if (empty($todosPedidos)): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted opacity-50 mb-3 d-block"></i>
                            <h5 class="fw-bold text-dark">No hay pedidos registrados en el sistema</h5>
                            <p class="text-muted small">Los pedidos que los clientes realicen desde el catálogo aparecerán aquí.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr class="small text-muted text-uppercase">
                                        <th>Código</th>
                                        <th>Cliente</th>
                                        <th>Fecha</th>
                                        <th>Total</th>
                                        <th>Entrega</th>
                                        <th>Estado Actual</th>
                                        <th>Cambiar Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($todosPedidos as $ped): ?>
                                        <tr>
                                            <td>
                                                <span class="badge bg-wine text-white rounded-pill px-3 py-1 fw-bold">
                                                    <?= escapar($ped['codigo']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong><?= escapar($ped['cliente'] ?? 'Cliente General') ?></strong>
                                                <small class="d-block text-muted">Tel: <?= escapar($ped['telefono'] ?? 'N/A') ?></small>
                                            </td>
                                            <td class="small text-muted">
                                                <?= escapar($ped['fecha']) ?>
                                            </td>
                                            <td class="fw-bold text-dark">
                                                Q <?= number_format((float)$ped['total'], 2) ?>
                                            </td>
                                            <td class="small">
                                                <span class="d-block fw-semibold"><?= escapar($ped['tipo_entrega'] ?? 'Recoger') ?></span>
                                                <span class="text-muted"><?= escapar($ped['direccion'] ?? 'Tienda Central') ?></span>
                                            </td>
                                            <td>
                                                <?php
                                                    $est = $ped['estado'] ?? 'En Preparación';
                                                    if ($est === 'Entregado') {
                                                        $bgClass = 'bg-success text-white';
                                                    } elseif ($est === 'En Tránsito') {
                                                        $bgClass = 'bg-primary text-white';
                                                    } elseif ($est === 'Cancelado') {
                                                        $bgClass = 'bg-danger text-white';
                                                    } else {
                                                        $bgClass = 'bg-warning text-dark';
                                                    }
                                                ?>
                                                <span class="badge <?= $bgClass ?> rounded-pill px-3 py-1">
                                                    <?= escapar($est) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <form action="objetos/actualizarPedido.php" method="post" class="d-flex align-items-center gap-1">
                                                    <input type="hidden" name="txt_codigo" value="<?= escapar($ped['codigo']) ?>">
                                                    <select name="txt_estado" class="form-select form-select-sm rounded-pill" style="min-width: 140px;">
                                                        <option value="En Preparación" <?= $est === 'En Preparación' ? 'selected' : '' ?>>En Preparación</option>
                                                        <option value="En Tránsito" <?= $est === 'En Tránsito' ? 'selected' : '' ?>>En Tránsito</option>
                                                        <option value="Entregado" <?= $est === 'Entregado' ? 'selected' : '' ?>>Entregado</option>
                                                        <option value="Cancelado" <?= $est === 'Cancelado' ? 'selected' : '' ?>>Cancelado</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-sm btn-pill-outline py-1 px-2" title="Actualizar">
                                                        <i class="bi bi-check2"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-usuarios" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-5">
                        <div class="content-card p-4">
                            <h5 class="fw-bold text-wine mb-2">
                                <i class="bi bi-person-plus me-1"></i> Registrar Nuevo Empleado o Cliente
                            </h5>
                            <p class="small text-muted mb-4">
                                Puedes dar de alta a nuevos empleados para que colaboren en el panel o registrar clientes.
                            </p>

                            <form action="objetos/agregarUsuario.php" method="post">
                                <input type="hidden" name="origen" value="admin">
                                
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Nombre Completo</label>
                                    <input type="text" name="txtNombre" class="form-control rounded-pill" placeholder="Ej: Karla Méndez" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Usuario o Correo</label>
                                    <input type="text" name="txtUsuario" class="form-control rounded-pill" placeholder="Ej: karla" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold text-muted">Contraseña</label>
                                    <input type="password" name="txtPassword" class="form-control rounded-pill" placeholder="Contraseña segura" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label small fw-semibold text-muted">Tipo de Cuenta</label>
                                    <select name="txtTipoUsuario" class="form-select rounded-pill">
                                        <option value="2" selected>👔 Empleado (Acceso al Panel de Modificación y Formularios)</option>
                                        <option value="1">🛍️ Cliente (Acceso a Compras)</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-pill-primary w-100 py-2">
                                    <i class="bi bi-check-circle me-1"></i> Crear Usuario
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <div class="content-card p-4">
                            <h5 class="fw-bold text-wine mb-3">
                                <i class="bi bi-people me-1"></i> Cuentas Registradas en el Sistema
                            </h5>

                            <h6 class="fw-bold text-primary small text-uppercase mb-2"><i class="bi bi-shield-lock me-1"></i> Empleados & Administradores</h6>
                            <div class="table-responsive mb-4">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light small text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Usuario/Correo</th>
                                            <th>Rol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuariosData['empleados'] as $emp): ?>
                                            <tr>
                                                <td>#<?= $emp['empleado_id'] ?></td>
                                                <td class="fw-bold"><?= escapar($emp['nombre']) ?></td>
                                                <td><code><?= escapar($emp['correo']) ?></code></td>
                                                <td><span class="badge bg-primary rounded-pill">Empleado / Admin</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <h6 class="fw-bold text-wine small text-uppercase mb-2"><i class="bi bi-person me-1"></i> Clientes Registrados</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-light small text-muted">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Usuario/Correo</th>
                                            <th>Rol</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($usuariosData['clientes'] as $cli): ?>
                                            <tr>
                                                <td>#<?= $cli['cliente_id'] ?></td>
                                                <td class="fw-bold"><?= escapar($cli['nombre']) ?></td>
                                                <td><code><?= escapar($cli['correo']) ?></code></td>
                                                <td><span class="badge bg-secondary rounded-pill">Cliente</span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="tab-conexiones" role="tabpanel">
                <div class="content-card p-4">
                    <h4 class="card-title-lg mb-2"><i class="bi bi-hdd-network me-2 text-wine"></i>Estado de las Conexiones del Proyecto</h4>
                    <p class="card-subtitle-muted mb-4">
                        Arquitectura de conexiones activa en tu servidor local XAMPP:
                    </p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="p-3 rounded-3 border bg-light h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-database me-1 text-primary"></i> Conexión MySQL / MariaDB</h6>
                                    <span class="badge bg-success rounded-pill">Conectado</span>
                                </div>
                                <p class="small text-muted mb-1">Servidor: <code>127.0.0.1:3306</code></p>
                                <p class="small text-muted mb-1">Base de Datos: <code>fs2026_proyecto</code></p>
                                <p class="small text-muted mb-0">Tablas: <code>productos</code>, <code>clientes</code>, <code>empleados</code>, <code>pedidos</code>, <code>categorias</code>.</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="p-3 rounded-3 border bg-light h-100">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <h6 class="fw-bold text-dark mb-0"><i class="bi bi-server me-1 text-success"></i> Conexión MongoDB</h6>
                                    <span class="badge <?= $mongoConectado ? 'bg-success' : 'bg-secondary' ?> rounded-pill">
                                        <?= $mongoConectado ? 'Activo' : 'Opcional / Híbrido' ?>
                                    </span>
                                </div>
                                <p class="small text-muted mb-1">Servidor: <code>mongodb://127.0.0.1:27017</code></p>
                                <p class="small text-muted mb-0"><?= escapar($mensajeMongo) ?></p>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="p-3 rounded-3 border bg-rose d-flex align-items-center justify-content-between flex-wrap gap-3 mt-3">
                                <div>
                                    <h6 class="fw-bold text-wine mb-1"><i class="bi bi-terminal me-2"></i>Backend en CodeIgniter 4</h6>
                                    <p class="small text-muted mb-0">
                                        Puedes acceder al panel CRUD generado en CodeIgniter 4 que interactúa directamente con las tablas de MySQL.
                                    </p>
                                </div>
                                <a href="../backend/public/" target="_blank" class="btn btn-pill-primary btn-sm px-4">
                                    Abrir Backend CI4 <i class="bi bi-box-arrow-up-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header bg-wine text-white rounded-top-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle me-1"></i> Formulario: Crear Nuevo Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="objetos/guardarProducto.php" method="post">
                <div class="modal-body p-4">
                    <input type="hidden" name="txt_id" value="0">

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Nombre del Producto</label>
                        <input type="text" name="txt_nombre" class="form-control rounded-pill" 
                               placeholder="Ej: Obleas Comestibles Especiales" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Categoría</label>
                        <select name="txt_categoria_id" class="form-select rounded-pill" required>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"><?= escapar($cat['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted">Precio (Q)</label>
                            <input type="number" step="0.01" name="txt_precio" class="form-control rounded-pill" 
                                   placeholder="0.00" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted">Stock Inicial</label>
                            <input type="number" name="txt_stock" class="form-control rounded-pill" 
                                   placeholder="10" required>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted">Disponibilidad</label>
                            <select name="txt_disponibilidad" class="form-select rounded-pill">
                                <option value="1" selected>En Stock</option>
                                <option value="0">Agotado</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-semibold text-muted">Ícono / Imagen</label>
                            <select name="txt_imagen" class="form-select rounded-pill">
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

                    <div class="mb-3">
                        <label class="form-label small fw-semibold text-muted">Descripción</label>
                        <textarea name="txt_descripcion" rows="3" class="form-control rounded-3" 
                                  placeholder="Describe las características del producto para los clientes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light rounded-bottom-4">
                    <button type="button" class="btn btn-pill-outline btn-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-pill-primary btn-sm px-4">
                        <i class="bi bi-check-lg me-1"></i> Guardar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var hash = window.location.hash;
    if (hash === '#pedidos') {
        var trigger = document.getElementById('tab-pedidos-btn');
        if (trigger) {
            var tab = new bootstrap.Tab(trigger);
            tab.show();
        }
    } else if (hash === '#usuarios') {
        var trigger = document.getElementById('tab-usuarios-btn');
        if (trigger) {
            var tab = new bootstrap.Tab(trigger);
            tab.show();
        }
    }
});
</script>

<?php require_once "footer.php"; ?>

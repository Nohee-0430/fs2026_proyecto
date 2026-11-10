<?php
$paginaActual = 'registro';
$tituloPagina = 'Crear Nueva Cuenta';
require_once "header.php";
?>

<div class="row justify-content-center my-4">
    <div class="col-md-7 col-lg-6">
        <div class="content-card p-4 p-md-5 shadow-sm">
            
            <div class="text-center mb-4">
                <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión" style="height: 60px;" class="mb-2">
                <h3 class="card-title-lg text-wine">Crear Nueva Cuenta</h3>
                <p class="text-muted small">Registra una nueva cuenta para cliente o empleado</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-warning py-2 small rounded-pill px-3 text-center mb-3">
                    <i class="bi bi-exclamation-triangle me-1"></i> Por favor completa todos los campos requeridos.
                </div>
            <?php endif; ?>

            <form action="objetos/agregarUsuario.php" method="post">
                <div class="mb-3">
                    <label for="txtNombre" class="form-label small fw-semibold text-muted">Nombre Completo</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" name="txtNombre" id="txtNombre" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Ej: Daniel Morales" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="txtUsuario" class="form-label small fw-semibold text-muted">Usuario o Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="txtUsuario" id="txtUsuario" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Ej: daniel o daniel@correo.com" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="txtPassword" class="form-label small fw-semibold text-muted">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="txtPassword" id="txtPassword" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Contraseña segura" required>
                    </div>
                    <span class="form-text text-muted small" style="font-size: 11px;">
                        <i class="bi bi-shield-lock me-1"></i> La contraseña se almacenará encriptada con <code>password_hash()</code>.
                    </span>
                </div>

                <div class="mb-4">
                    <label for="txtTipoUsuario" class="form-label small fw-semibold text-muted">Tipo de Cuenta / Rol</label>
                    <select name="txtTipoUsuario" id="txtTipoUsuario" class="form-select rounded-pill">
                        <option value="1" selected>🛍️ Cliente (Acceso a Tienda, Catálogo, Carrito y Compras)</option>
                        <option value="2">👔 Empleado / Admin (Acceso a Modificar Datos, Crear Productos y Pedidos)</option>
                    </select>
                    <span class="form-text text-muted small" style="font-size: 11px;">
                        Selecciona <strong>Empleado</strong> si deseas acceder al panel donde puedes modificar datos y crear nuevos productos.
                    </span>
                </div>

                <button type="submit" class="btn btn-pill-primary w-100 py-2 fs-6 shadow-sm mb-3">
                    <i class="bi bi-person-check me-1"></i> Registrar Cuenta
                </button>
            </form>

            <div class="text-center pt-3 border-top">
                <p class="text-muted small mb-2">¿Ya tienes una cuenta?</p>
                <a href="login.php" class="btn btn-pill-outline btn-sm px-4">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Ir a Iniciar Sesión
                </a>
            </div>

        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>

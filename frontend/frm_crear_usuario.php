<?php
$paginaActual = 'registro';
$tituloPagina = 'Crear Nuevo Usuario';
require_once "header.php";
?>

<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="content-card p-4 p-md-5 shadow-sm">
            
            <div class="text-center mb-4">
                <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión" style="height: 60px;" class="mb-2">
                <h3 class="card-title-lg text-wine">Crear Nuevo Usuario</h3>
                <p class="text-muted small">Registra tus datos con la lógica de autenticación del curso</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-warning py-2 small rounded-pill px-3 text-center mb-3">
                    <i class="bi bi-exclamation-triangle me-1"></i> Por favor completa todos los campos requeridos.
                </div>
            <?php endif; ?>

            <!-- Formulario con los mismos campos de la clase -->
            <form action="objetos/agregarUsuario.php" method="post">
                <div class="mb-3">
                    <label for="txtNombre" class="form-label small fw-semibold text-muted">Nombre Completo</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-card-text"></i>
                        </span>
                        <input type="text" name="txtNombre" id="txtNombre" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Ej: Nohelia Barillas" required autofocus>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="txtUsuario" class="form-label small fw-semibold text-muted">Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="txtUsuario" id="txtUsuario" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Ej: noheliab o tu alias" required>
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
                        <i class="bi bi-shield-lock me-1"></i> Se guardará encriptada con <code>password_hash()</code>.
                    </span>
                </div>

                <div class="mb-4">
                    <label for="txtTipoUsuario" class="form-label small fw-semibold text-muted">Tipo de Usuario</label>
                    <select name="txtTipoUsuario" id="txtTipoUsuario" class="form-select rounded-pill">
                        <option value="1" selected>Cliente (Acceso a Catálogo y Compras)</option>
                        <option value="2">Empleado (Acceso a Pedidos y Gestión)</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-pill-primary w-100 py-2 fs-6 shadow-sm mb-3">
                    <i class="bi bi-person-check me-1"></i> Guardar y Crear Usuario
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

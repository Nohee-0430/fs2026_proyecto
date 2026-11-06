<?php
$paginaActual = 'login';
$tituloPagina = 'Iniciar Sesión';
require_once "header.php";
?>

<div class="row justify-content-center my-4">
    <div class="col-md-6 col-lg-5">
        <div class="content-card p-4 p-md-5 shadow-sm">
            
            <div class="text-center mb-4">
                <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión" style="height: 60px;" class="mb-2">
                <h3 class="card-title-lg text-wine">Iniciar Sesión</h3>
                <p class="text-muted small">Ingresa tus credenciales para acceder a tu cuenta</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger py-2 small rounded-pill px-3 text-center mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Usuario o contraseña incorrectos.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registrado'])): ?>
                <div class="alert alert-success py-2 small rounded-pill px-3 text-center mb-3">
                    <i class="bi bi-check-circle-fill me-1"></i> ¡Usuario registrado con éxito! Ya puedes iniciar sesión.
                </div>
            <?php endif; ?>

            <form action="objetos/iniciarSesion.php" method="post">
                <div class="mb-3">
                    <label for="txtUsuario" class="form-label small fw-semibold text-muted">Usuario o Correo</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="txtUsuario" id="txtUsuario" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Ej: nohelia o tu correo" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="txtPassword" class="form-label small fw-semibold text-muted">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-lock"></i>
                        </span>
                        <input type="password" name="txtPassword" id="txtPassword" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Tu contraseña" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-pill-primary w-100 py-2 fs-6 shadow-sm mb-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                </button>
            </form>

            <div class="text-center pt-3 border-top">
                <p class="text-muted small mb-2">¿Aún no tienes cuenta?</p>
                <a href="frm_crear_usuario.php" class="btn btn-pill-outline btn-sm px-4">
                    <i class="bi bi-person-plus me-1"></i> Crear Nuevo Usuario
                </a>
            </div>

            

        </div>
    </div>
</div>

<?php require_once "footer.php"; ?>

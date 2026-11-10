<?php
$paginaActual = 'login';
$tituloPagina = 'Iniciar Sesión';
require_once "header.php";
?>

<div class="row justify-content-center my-4">
    <div class="col-md-7 col-lg-5">
        <div class="content-card p-4 p-md-5 shadow-sm">
            
            <div class="text-center mb-4">
                <img src="imagenes/logo_proyecto.png" alt="Dulce Impresión" style="height: 60px;" class="mb-2">
                <h3 class="card-title-lg text-wine">Iniciar Sesión</h3>
                <p class="text-muted small">Ingresa tus credenciales para acceder a tu rol en el sistema</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-danger py-2 small rounded-pill px-3 text-center mb-3">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Usuario o contraseña incorrectos. Verifica tus credenciales.
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['registrado'])): ?>
                <?php if ($_GET['registrado'] === 'empleado'): ?>
                    <div class="alert alert-success py-2 small rounded-pill px-3 text-center mb-3">
                        <i class="bi bi-shield-check me-1"></i> <strong>¡Cuenta de Empleado creada!</strong> Inicia sesión para entrar al Panel Administrativo.
                    </div>
                <?php else: ?>
                    <div class="alert alert-success py-2 small rounded-pill px-3 text-center mb-3">
                        <i class="bi bi-check-circle-fill me-1"></i> <strong>¡Usuario creado con éxito!</strong> Ya puedes iniciar sesión con tu cuenta.
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <form action="objetos/iniciarSesion.php" method="post">
                <div class="mb-3">
                    <label for="txtUsuario" class="form-label small fw-semibold text-muted">Usuario o Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 rounded-start-pill text-muted">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" name="txtUsuario" id="txtUsuario" 
                               class="form-control rounded-end-pill border-start-0 ps-0" 
                               placeholder="Ej: admin o nohelia" required autofocus>
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
                               placeholder="Tu contraseña (ej: 123)" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-pill-primary w-100 py-2 fs-6 shadow-sm mb-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                </button>
            </form>

            <div class="p-3 bg-light rounded-4 border mb-4">
                <h6 class="fw-bold text-wine small mb-2"><i class="bi bi-info-circle me-1"></i> Cuentas preconfiguradas del sistema:</h6>
                
                <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-white rounded-3 border small">
                    <div>
                        <span class="badge bg-primary me-1">Empleado / Admin</span>
                        <strong class="text-dark">admin</strong> / <code>123</code>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm py-0 px-2" onclick="llenarLogin('admin', '123')">
                        Usar
                    </button>
                </div>

                <div class="d-flex align-items-center justify-content-between p-2 bg-white rounded-3 border small">
                    <div>
                        <span class="badge bg-wine text-white me-1">Cliente</span>
                        <strong class="text-dark">nohelia</strong> / <code>123</code>
                    </div>
                    <button type="button" class="btn btn-outline-secondary btn-sm py-0 px-2" onclick="llenarLogin('nohelia', '123')">
                        Usar
                    </button>
                </div>
            </div>

            <div class="text-center pt-3 border-top">
                <p class="text-muted small mb-2">¿Aún no tienes una cuenta registrada?</p>
                <a href="frm_crear_usuario.php" class="btn btn-pill-outline btn-sm px-4">
                    <i class="bi bi-person-plus me-1"></i> Crear Nueva Cuenta
                </a>
            </div>

        </div>
    </div>
</div>

<script>
function llenarLogin(usuario, pass) {
    document.getElementById('txtUsuario').value = usuario;
    document.getElementById('txtPassword').value = pass;
}
</script>

<?php require_once "footer.php"; ?>

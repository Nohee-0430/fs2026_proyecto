<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>

<h1 class="mt-4">Empleados</h1>

<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#EmpleadosModal">
    Nuevo Empleado
</button>

<!-- Modal -->
<div class="modal fade" id="EmpleadosModal" tabindex="-1" aria-labelledby="EmpleadosModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="EmpleadosModalLabel">Agregar Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('empleados/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_nombre" class="form-label">Nombre</label>
                        <input type="text" name="txt_nombre" id="txt_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_correo" class="form-label">Correo</label>
                        <input type="email" name="txt_correo" id="txt_correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_contrasenia" class="form-label">Contraseña</label>
                        <input type="password" name="txt_contrasenia" id="txt_contrasenia" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_rol" class="form-label">Rol</label>
                        <input type="text" name="txt_rol" id="txt_rol" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_registro" class="form-label">Fecha de Registro</label>
                        <input type="date" name="txt_fecha_registro" id="txt_fecha_registro" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="card shadow">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Fecha de Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $empleado): ?>
                    <tr>
                        <td><?=$empleado['empleado_id']?></td>
                        <td><?=$empleado['nombre']?></td>
                        <td><?=$empleado['correo']?></td>
                        <td><?=$empleado['rol']?></td>
                        <td><?=$empleado['fecha_registro']?></td>
                        <td>
                            <a href="<?=base_url('empleados/buscar/').$empleado['empleado_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('empleados/eliminar/').$empleado['empleado_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar empleado?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
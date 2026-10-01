<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Clientes</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalclientes">
    Nuevo
</button>
<div class="modal fade" id="modalclientes" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('clientes/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_nombre" class="form-label">Nombre</label>
                        <input type="text" name="txt_nombre" id="txt_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_correo" class="form-label">Correo</label>
                        <input type="text" name="txt_correo" id="txt_correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_contrasenia" class="form-label">Contrasenia</label>
                        <input type="text" name="txt_contrasenia" id="txt_contrasenia" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_registro" class="form-label">Fecha registro</label>
                        <input type="text" name="txt_fecha_registro" id="txt_fecha_registro" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
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
                        <th>Cliente id</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Contrasenia</th>
                        <th>Fecha registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['cliente_id']?></td>
                        <td><?=$fila['nombre']?></td>
                        <td><?=$fila['correo']?></td>
                        <td><?=$fila['contrasenia']?></td>
                        <td><?=$fila['fecha_registro']?></td>
                        <td>
                            <a href="<?=base_url('clientes/buscar/').$fila['cliente_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('clientes/eliminar/').$fila['cliente_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
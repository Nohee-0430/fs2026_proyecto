<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Lista_deseos</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modallista_deseos">
    Nuevo
</button>
<div class="modal fade" id="modallista_deseos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('lista_deseos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_cliente_id" class="form-label">Cliente id</label>
                        <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_producto_id" class="form-label">Producto id</label>
                        <input type="text" name="txt_producto_id" id="txt_producto_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_agregado" class="form-label">Fecha agregado</label>
                        <input type="text" name="txt_fecha_agregado" id="txt_fecha_agregado" class="form-control" required>
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
                        <th>Lista deseo id</th>
                        <th>Cliente id</th>
                        <th>Producto id</th>
                        <th>Fecha agregado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['lista_deseo_id']?></td>
                        <td><?=$fila['cliente_id']?></td>
                        <td><?=$fila['producto_id']?></td>
                        <td><?=$fila['fecha_agregado']?></td>
                        <td>
                            <a href="<?=base_url('lista_deseos/buscar/').$fila['lista_deseo_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('lista_deseos/eliminar/').$fila['lista_deseo_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Resenias</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalresenias">
    Nuevo
</button>
<div class="modal fade" id="modalresenias" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('resenias/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_cliente_id" class="form-label">Cliente id</label>
                        <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_detalle_pedido_id" class="form-label">Detalle pedido id</label>
                        <input type="text" name="txt_detalle_pedido_id" id="txt_detalle_pedido_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_calificacion" class="form-label">Calificacion</label>
                        <input type="text" name="txt_calificacion" id="txt_calificacion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_comentario" class="form-label">Comentario</label>
                        <input type="text" name="txt_comentario" id="txt_comentario" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_estado" class="form-label">Estado</label>
                        <input type="text" name="txt_estado" id="txt_estado" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_publicacion" class="form-label">Fecha publicacion</label>
                        <input type="text" name="txt_fecha_publicacion" id="txt_fecha_publicacion" class="form-control" required>
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
                        <th>Resenia id</th>
                        <th>Cliente id</th>
                        <th>Detalle pedido id</th>
                        <th>Calificacion</th>
                        <th>Comentario</th>
                        <th>Estado</th>
                        <th>Fecha publicacion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['resenia_id']?></td>
                        <td><?=$fila['cliente_id']?></td>
                        <td><?=$fila['detalle_pedido_id']?></td>
                        <td><?=$fila['calificacion']?></td>
                        <td><?=$fila['comentario']?></td>
                        <td><?=$fila['estado']?></td>
                        <td><?=$fila['fecha_publicacion']?></td>
                        <td>
                            <a href="<?=base_url('resenias/buscar/').$fila['resenia_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('resenias/eliminar/').$fila['resenia_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
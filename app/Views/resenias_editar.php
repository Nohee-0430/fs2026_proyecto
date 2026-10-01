<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('resenias/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_resenia_id" class="form-label">Resenia id</label>
                <input type="text" name="txt_resenia_id" id="txt_resenia_id" class="form-control" value="<?=$datos['resenia_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_cliente_id" class="form-label">Cliente id</label>
                <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" value="<?=$datos['cliente_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_detalle_pedido_id" class="form-label">Detalle pedido id</label>
                <input type="text" name="txt_detalle_pedido_id" id="txt_detalle_pedido_id" class="form-control" value="<?=$datos['detalle_pedido_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_calificacion" class="form-label">Calificacion</label>
                <input type="text" name="txt_calificacion" id="txt_calificacion" class="form-control" value="<?=$datos['calificacion'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_comentario" class="form-label">Comentario</label>
                <input type="text" name="txt_comentario" id="txt_comentario" class="form-control" value="<?=$datos['comentario'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_estado" class="form-label">Estado</label>
                <input type="text" name="txt_estado" id="txt_estado" class="form-control" value="<?=$datos['estado'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_publicacion" class="form-label">Fecha publicacion</label>
                <input type="text" name="txt_fecha_publicacion" id="txt_fecha_publicacion" class="form-control" value="<?=$datos['fecha_publicacion'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('resenias')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
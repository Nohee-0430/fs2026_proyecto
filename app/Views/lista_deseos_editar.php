<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('lista_deseos/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_lista_deseo_id" class="form-label">Lista deseo id</label>
                <input type="text" name="txt_lista_deseo_id" id="txt_lista_deseo_id" class="form-control" value="<?=$datos['lista_deseo_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_cliente_id" class="form-label">Cliente id</label>
                <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" value="<?=$datos['cliente_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_producto_id" class="form-label">Producto id</label>
                <input type="text" name="txt_producto_id" id="txt_producto_id" class="form-control" value="<?=$datos['producto_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_agregado" class="form-label">Fecha agregado</label>
                <input type="text" name="txt_fecha_agregado" id="txt_fecha_agregado" class="form-control" value="<?=$datos['fecha_agregado'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('lista_deseos')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
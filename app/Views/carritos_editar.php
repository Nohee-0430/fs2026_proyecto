<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('carritos/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_carrito_id" class="form-label">Carrito id</label>
                <input type="text" name="txt_carrito_id" id="txt_carrito_id" class="form-control" value="<?=$datos['carrito_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_cliente_id" class="form-label">Cliente id</label>
                <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" value="<?=$datos['cliente_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_creacion" class="form-label">Fecha creacion</label>
                <input type="text" name="txt_fecha_creacion" id="txt_fecha_creacion" class="form-control" value="<?=$datos['fecha_creacion'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_estado" class="form-label">Estado</label>
                <input type="text" name="txt_estado" id="txt_estado" class="form-control" value="<?=$datos['estado'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('carritos')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
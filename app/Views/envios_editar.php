<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('envios/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_pedido_id" class="form-label">Pedido id</label>
                <input type="text" name="txt_pedido_id" id="txt_pedido_id" class="form-control" value="<?=$datos['pedido_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_direccion" class="form-label">Direccion</label>
                <input type="text" name="txt_direccion" id="txt_direccion" class="form-control" value="<?=$datos['direccion'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_municipio" class="form-label">Municipio</label>
                <input type="text" name="txt_municipio" id="txt_municipio" class="form-control" value="<?=$datos['municipio'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_departamento" class="form-label">Departamento</label>
                <input type="text" name="txt_departamento" id="txt_departamento" class="form-control" value="<?=$datos['departamento'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_estado_envio" class="form-label">Estado envio</label>
                <input type="text" name="txt_estado_envio" id="txt_estado_envio" class="form-control" value="<?=$datos['estado_envio'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_envio" class="form-label">Fecha envio</label>
                <input type="text" name="txt_fecha_envio" id="txt_fecha_envio" class="form-control" value="<?=$datos['fecha_envio'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_entrega" class="form-label">Fecha entrega</label>
                <input type="text" name="txt_fecha_entrega" id="txt_fecha_entrega" class="form-control" value="<?=$datos['fecha_entrega'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_referencia_ubicacion" class="form-label">Referencia ubicacion</label>
                <input type="text" name="txt_referencia_ubicacion" id="txt_referencia_ubicacion" class="form-control" value="<?=$datos['referencia_ubicacion'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_observaciones" class="form-label">Observaciones</label>
                <input type="text" name="txt_observaciones" id="txt_observaciones" class="form-control" value="<?=$datos['observaciones'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('envios')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
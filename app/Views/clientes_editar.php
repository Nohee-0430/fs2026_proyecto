<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('clientes/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_cliente_id" class="form-label">Cliente id</label>
                <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" value="<?=$datos['cliente_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_nombre" class="form-label">Nombre</label>
                <input type="text" name="txt_nombre" id="txt_nombre" class="form-control" value="<?=$datos['nombre'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_correo" class="form-label">Correo</label>
                <input type="text" name="txt_correo" id="txt_correo" class="form-control" value="<?=$datos['correo'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_contrasenia" class="form-label">Contrasenia</label>
                <input type="text" name="txt_contrasenia" id="txt_contrasenia" class="form-control" value="<?=$datos['contrasenia'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_registro" class="form-label">Fecha registro</label>
                <input type="text" name="txt_fecha_registro" id="txt_fecha_registro" class="form-control" value="<?=$datos['fecha_registro'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('clientes')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
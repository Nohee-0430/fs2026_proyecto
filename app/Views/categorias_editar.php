<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('categorias/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_categoria_id" class="form-label">Categoria id</label>
                <input type="text" name="txt_categoria_id" id="txt_categoria_id" class="form-control" value="<?=$datos['categoria_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_nombre" class="form-label">Nombre</label>
                <input type="text" name="txt_nombre" id="txt_nombre" class="form-control" value="<?=$datos['nombre'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_descripcion" class="form-label">Descripcion</label>
                <input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control" value="<?=$datos['descripcion'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('categorias')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
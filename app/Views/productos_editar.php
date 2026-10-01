<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('productos/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_productos_id" class="form-label">Productos id</label>
                <input type="text" name="txt_productos_id" id="txt_productos_id" class="form-control" value="<?=$datos['productos_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_categoria_id" class="form-label">Categoria id</label>
                <input type="text" name="txt_categoria_id" id="txt_categoria_id" class="form-control" value="<?=$datos['categoria_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_nombre" class="form-label">Nombre</label>
                <input type="text" name="txt_nombre" id="txt_nombre" class="form-control" value="<?=$datos['nombre'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_descripcion" class="form-label">Descripcion</label>
                <input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control" value="<?=$datos['descripcion'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_imagen" class="form-label">Imagen</label>
                <input type="text" name="txt_imagen" id="txt_imagen" class="form-control" value="<?=$datos['imagen'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_precio" class="form-label">Precio</label>
                <input type="text" name="txt_precio" id="txt_precio" class="form-control" value="<?=$datos['precio'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_stock" class="form-label">Stock</label>
                <input type="text" name="txt_stock" id="txt_stock" class="form-control" value="<?=$datos['stock'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_disponibilidad" class="form-label">Disponibilidad</label>
                <input type="text" name="txt_disponibilidad" id="txt_disponibilidad" class="form-control" value="<?=$datos['disponibilidad'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('productos')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
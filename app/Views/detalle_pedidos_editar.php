<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('detalle_pedidos/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_detalle_pedido_id" class="form-label">Detalle pedido id</label>
                <input type="text" name="txt_detalle_pedido_id" id="txt_detalle_pedido_id" class="form-control" value="<?=$datos['detalle_pedido_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_carrito_id" class="form-label">Carrito id</label>
                <input type="text" name="txt_carrito_id" id="txt_carrito_id" class="form-control" value="<?=$datos['carrito_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_producto_id" class="form-label">Producto id</label>
                <input type="text" name="txt_producto_id" id="txt_producto_id" class="form-control" value="<?=$datos['producto_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_cantidad" class="form-label">Cantidad</label>
                <input type="text" name="txt_cantidad" id="txt_cantidad" class="form-control" value="<?=$datos['cantidad'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_precio_unitario" class="form-label">Precio unitario</label>
                <input type="text" name="txt_precio_unitario" id="txt_precio_unitario" class="form-control" value="<?=$datos['precio_unitario'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_subtotal" class="form-label">Subtotal</label>
                <input type="text" name="txt_subtotal" id="txt_subtotal" class="form-control" value="<?=$datos['subtotal'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('detalle_pedidos')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
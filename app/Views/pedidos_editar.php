<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('pedidos/actualizar'); ?>" class="form" method="post">
            <div class="mb-3">
                <label for="txt_carrito_id" class="form-label">Carrito id</label>
                <input type="text" name="txt_carrito_id" id="txt_carrito_id" class="form-control" value="<?=$datos['carrito_id'];?>" readonly>
            </div>
            <div class="mb-3">
                <label for="txt_cliente_id" class="form-label">Cliente id</label>
                <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" value="<?=$datos['cliente_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_empleado_id" class="form-label">Empleado id</label>
                <input type="text" name="txt_empleado_id" id="txt_empleado_id" class="form-control" value="<?=$datos['empleado_id'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_fecha_pedido" class="form-label">Fecha pedido</label>
                <input type="text" name="txt_fecha_pedido" id="txt_fecha_pedido" class="form-control" value="<?=$datos['fecha_pedido'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_total" class="form-label">Total</label>
                <input type="text" name="txt_total" id="txt_total" class="form-control" value="<?=$datos['total'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_estado" class="form-label">Estado</label>
                <input type="text" name="txt_estado" id="txt_estado" class="form-control" value="<?=$datos['estado'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_metodo_pago" class="form-label">Metodo pago</label>
                <input type="text" name="txt_metodo_pago" id="txt_metodo_pago" class="form-control" value="<?=$datos['metodo_pago'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_tipo_entrega" class="form-label">Tipo entrega</label>
                <input type="text" name="txt_tipo_entrega" id="txt_tipo_entrega" class="form-control" value="<?=$datos['tipo_entrega'];?>" required>
            </div>
            <div class="mb-3">
                <label for="txt_nit" class="form-label">Nit</label>
                <input type="text" name="txt_nit" id="txt_nit" class="form-control" value="<?=$datos['nit'];?>" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="<?=base_url('pedidos')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
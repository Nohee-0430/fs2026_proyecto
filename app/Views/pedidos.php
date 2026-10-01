<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Pedidos</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalpedidos">
    Nuevo
</button>
<div class="modal fade" id="modalpedidos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('pedidos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_cliente_id" class="form-label">Cliente id</label>
                        <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_empleado_id" class="form-label">Empleado id</label>
                        <input type="text" name="txt_empleado_id" id="txt_empleado_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_pedido" class="form-label">Fecha pedido</label>
                        <input type="text" name="txt_fecha_pedido" id="txt_fecha_pedido" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_total" class="form-label">Total</label>
                        <input type="text" name="txt_total" id="txt_total" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_estado" class="form-label">Estado</label>
                        <input type="text" name="txt_estado" id="txt_estado" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_metodo_pago" class="form-label">Metodo pago</label>
                        <input type="text" name="txt_metodo_pago" id="txt_metodo_pago" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_tipo_entrega" class="form-label">Tipo entrega</label>
                        <input type="text" name="txt_tipo_entrega" id="txt_tipo_entrega" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_nit" class="form-label">Nit</label>
                        <input type="text" name="txt_nit" id="txt_nit" class="form-control" required>
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
                        <th>Carrito id</th>
                        <th>Cliente id</th>
                        <th>Empleado id</th>
                        <th>Fecha pedido</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Metodo pago</th>
                        <th>Tipo entrega</th>
                        <th>Nit</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['carrito_id']?></td>
                        <td><?=$fila['cliente_id']?></td>
                        <td><?=$fila['empleado_id']?></td>
                        <td><?=$fila['fecha_pedido']?></td>
                        <td><?=$fila['total']?></td>
                        <td><?=$fila['estado']?></td>
                        <td><?=$fila['metodo_pago']?></td>
                        <td><?=$fila['tipo_entrega']?></td>
                        <td><?=$fila['nit']?></td>
                        <td>
                            <a href="<?=base_url('pedidos/buscar/').$fila['carrito_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('pedidos/eliminar/').$fila['carrito_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
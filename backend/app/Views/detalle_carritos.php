<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Detalle_carritos</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modaldetalle_carritos">
    Nuevo
</button>
<div class="modal fade" id="modaldetalle_carritos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('detalle_carritos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_carrito_id" class="form-label">Carrito id</label>
                        <input type="text" name="txt_carrito_id" id="txt_carrito_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_producto_id" class="form-label">Producto id</label>
                        <input type="text" name="txt_producto_id" id="txt_producto_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_cantidad" class="form-label">Cantidad</label>
                        <input type="text" name="txt_cantidad" id="txt_cantidad" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_precio_unitario" class="form-label">Precio unitario</label>
                        <input type="text" name="txt_precio_unitario" id="txt_precio_unitario" class="form-control" required>
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
                        <th>Detalle carrito id</th>
                        <th>Carrito id</th>
                        <th>Producto id</th>
                        <th>Cantidad</th>
                        <th>Precio unitario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['detalle_carrito_id']?></td>
                        <td><?=$fila['carrito_id']?></td>
                        <td><?=$fila['producto_id']?></td>
                        <td><?=$fila['cantidad']?></td>
                        <td><?=$fila['precio_unitario']?></td>
                        <td>
                            <a href="<?=base_url('detalle_carritos/buscar/').$fila['detalle_carrito_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('detalle_carritos/eliminar/').$fila['detalle_carrito_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Carritos</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalcarritos">
    Nuevo
</button>
<div class="modal fade" id="modalcarritos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('carritos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_cliente_id" class="form-label">Cliente id</label>
                        <input type="text" name="txt_cliente_id" id="txt_cliente_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_creacion" class="form-label">Fecha creacion</label>
                        <input type="text" name="txt_fecha_creacion" id="txt_fecha_creacion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_estado" class="form-label">Estado</label>
                        <input type="text" name="txt_estado" id="txt_estado" class="form-control" required>
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
                        <th>Fecha creacion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['carrito_id']?></td>
                        <td><?=$fila['cliente_id']?></td>
                        <td><?=$fila['fecha_creacion']?></td>
                        <td><?=$fila['estado']?></td>
                        <td>
                            <a href="<?=base_url('carritos/buscar/').$fila['carrito_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('carritos/eliminar/').$fila['carrito_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Envios</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalenvios">
    Nuevo
</button>
<div class="modal fade" id="modalenvios" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('envios/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_direccion" class="form-label">Direccion</label>
                        <input type="text" name="txt_direccion" id="txt_direccion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_municipio" class="form-label">Municipio</label>
                        <input type="text" name="txt_municipio" id="txt_municipio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_departamento" class="form-label">Departamento</label>
                        <input type="text" name="txt_departamento" id="txt_departamento" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_estado_envio" class="form-label">Estado envio</label>
                        <input type="text" name="txt_estado_envio" id="txt_estado_envio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_envio" class="form-label">Fecha envio</label>
                        <input type="text" name="txt_fecha_envio" id="txt_fecha_envio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_fecha_entrega" class="form-label">Fecha entrega</label>
                        <input type="text" name="txt_fecha_entrega" id="txt_fecha_entrega" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_referencia_ubicacion" class="form-label">Referencia ubicacion</label>
                        <input type="text" name="txt_referencia_ubicacion" id="txt_referencia_ubicacion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_observaciones" class="form-label">Observaciones</label>
                        <input type="text" name="txt_observaciones" id="txt_observaciones" class="form-control" required>
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
                        <th>Pedido id</th>
                        <th>Direccion</th>
                        <th>Municipio</th>
                        <th>Departamento</th>
                        <th>Estado envio</th>
                        <th>Fecha envio</th>
                        <th>Fecha entrega</th>
                        <th>Referencia ubicacion</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['pedido_id']?></td>
                        <td><?=$fila['direccion']?></td>
                        <td><?=$fila['municipio']?></td>
                        <td><?=$fila['departamento']?></td>
                        <td><?=$fila['estado_envio']?></td>
                        <td><?=$fila['fecha_envio']?></td>
                        <td><?=$fila['fecha_entrega']?></td>
                        <td><?=$fila['referencia_ubicacion']?></td>
                        <td><?=$fila['observaciones']?></td>
                        <td>
                            <a href="<?=base_url('envios/buscar/').$fila['pedido_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('envios/eliminar/').$fila['pedido_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
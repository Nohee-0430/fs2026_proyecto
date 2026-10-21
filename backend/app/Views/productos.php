<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">Productos</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modalproductos">
    Nuevo
</button>
<div class="modal fade" id="modalproductos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('productos/insertar'); ?>" class="form" method="post">
                    <div class="mb-3">
                        <label for="txt_categoria_id" class="form-label">Categoria id</label>
                        <input type="text" name="txt_categoria_id" id="txt_categoria_id" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_nombre" class="form-label">Nombre</label>
                        <input type="text" name="txt_nombre" id="txt_nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_descripcion" class="form-label">Descripcion</label>
                        <input type="text" name="txt_descripcion" id="txt_descripcion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_imagen" class="form-label">Imagen</label>
                        <input type="text" name="txt_imagen" id="txt_imagen" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_precio" class="form-label">Precio</label>
                        <input type="text" name="txt_precio" id="txt_precio" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_stock" class="form-label">Stock</label>
                        <input type="text" name="txt_stock" id="txt_stock" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="txt_disponibilidad" class="form-label">Disponibilidad</label>
                        <input type="text" name="txt_disponibilidad" id="txt_disponibilidad" class="form-control" required>
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
                        <th>Productos id</th>
                        <th>Categoria id</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Imagen</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Disponibilidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
                        <td><?=$fila['productos_id']?></td>
                        <td><?=$fila['categoria_id']?></td>
                        <td><?=$fila['nombre']?></td>
                        <td><?=$fila['descripcion']?></td>
                        <td><?=$fila['imagen']?></td>
                        <td><?=$fila['precio']?></td>
                        <td><?=$fila['stock']?></td>
                        <td><?=$fila['disponibilidad']?></td>
                        <td>
                            <a href="<?=base_url('productos/buscar/').$fila['productos_id'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('productos/eliminar/').$fila['productos_id'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
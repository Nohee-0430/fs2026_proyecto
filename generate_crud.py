import os

base_path = "c:\\xampp\\htdocs\\fs2026\\fs2026_proyecto\\app"

tables = {
    "clientes": {
        "id": "cliente_id",
        "fields": ["cliente_id", "nombre", "correo", "contrasenia", "fecha_registro"],
        "controller": "ClientesController",
        "model": "ClientesModel",
        "route_group": "clientes"
    },
    "categorias": {
        "id": "categoria_id",
        "fields": ["categoria_id", "nombre", "descripcion"],
        "controller": "CategoriasController",
        "model": "CategoriasModel",
        "route_group": "categorias"
    },
    "productos": {
        "id": "producto_id",
        "fields": ["producto_id", "categoria_id", "nombre", "descripcion", "imagen", "precio", "stock", "disponible"],
        "controller": "ProductosController",
        "model": "ProductosModel",
        "route_group": "productos"
    },
    "carritos": {
        "id": "carrito_id",
        "fields": ["carrito_id", "cliente_id", "fecha_creacion", "estado"],
        "controller": "CarritosController",
        "model": "CarritosModel",
        "route_group": "carritos"
    },
    "detalle_carritos": {
        "id": "detalle_carrito_id",
        "fields": ["detalle_carrito_id", "carrito_id", "producto_id", "cantidad", "precio_unitario"],
        "controller": "DetalleCarritosController",
        "model": "DetalleCarritosModel",
        "route_group": "detalle_carritos"
    },
    "pedidos": {
        "id": "carrito_id",
        "fields": ["carrito_id", "cliente_id", "empleado_id", "fecha_pedido", "total", "estado", "metodo_pago", "tipo_entrega", "nit"],
        "controller": "PedidosController",
        "model": "PedidosModel",
        "route_group": "pedidos"
    },
    "detalle_pedidos": {
        "id": "detalle_pedido_id",
        "fields": ["detalle_pedido_id", "carrito_id", "producto_id", "cantidad", "precio_unitario", "subtotal"],
        "controller": "DetallePedidosController",
        "model": "DetallePedidosModel",
        "route_group": "detalle_pedidos"
    },
    "envios": {
        "id": "pedido_id",
        "fields": ["pedido_id", "carrito_id", "direccion", "municipio", "departamento", "referencia_ubicacion", "observaciones", "total_cobrar", "estado_envio", "numero_seguimiento", "fecha_envio", "fecha_entrega"],
        "controller": "EnviosController",
        "model": "EnviosModel",
        "route_group": "envios"
    },
    "resenias": {
        "id": "resenia_id",
        "fields": ["resenia_id", "cliente_id", "detalle_pedido_id", "calificacion", "comentario", "estado", "fecha_publicacion"],
        "controller": "ReseniasController",
        "model": "ReseniasModel",
        "route_group": "resenias"
    },
    "lista_deseos": {
        "id": "lista_deseo_id",
        "fields": ["lista_deseo_id", "cliente_id", "producto_id", "fecha_agregado"],
        "controller": "ListaDeseosController",
        "model": "ListaDeseosModel",
        "route_group": "lista_deseos"
    }
}

routes_append = "\n\n/* RUTAS GENERADAS AUTOMÁTICAMENTE PARA E-COMMERCE */\n"

for table, data in tables.items():
    controller_name = data["controller"]
    model_name = data["model"]
    route_group = data["route_group"]
    pk = data["id"]
    fields = data["fields"]
    
    # 1. MODEL
    model_content = f"""<?php
namespace App\\Models;
use CodeIgniter\\Model;

class {model_name} extends Model 
{{
    protected $table = '{table}';
    protected $primaryKey = '{pk}';
    protected $allowedFields = {str(fields)};
}}
"""
    with open(os.path.join(base_path, "Models", f"{model_name}.php"), "w", encoding="utf-8") as f:
        f.write(model_content)

    # 2. CONTROLLER
    insert_array = []
    for field in fields:
        if field != pk:
            insert_array.append(f"            '{field}' => $this->request->getVar('txt_{field}')")
    insert_str = ",\n".join(insert_array)
    
    controller_content = f"""<?php
namespace App\\Controllers;
use App\\Controllers\\BaseController;
use App\\Models\\{model_name};

class {controller_name} extends BaseController
{{
    public function index()
    {{
        $modelo = new {model_name}();
        $datos["datos"] = $modelo->findAll();
        return view("{table}", $datos);
    }}

    public function buscarId($id)
    {{
        $modelo = new {model_name}();
        $datos["datos"] = $modelo->where('{pk}', $id)->first();
        return view("{table}_editar", $datos);
    }}

    public function actualizar()
    {{
        $id = $this->request->getVar('txt_{pk}');
        $datos = [
{insert_str}
        ];
        $modelo = new {model_name}();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('{route_group}'));
    }}

    public function insertar()
    {{
        $datos = [
{insert_str}
        ];
        $modelo = new {model_name}();
        $modelo->insert($datos);
        return redirect()->to(base_url('{route_group}'));
    }}

    public function eliminar($id)
    {{
        $modelo = new {model_name}();
        $modelo->delete($id);
        return redirect()->to(base_url('{route_group}'));
    }}
}}
"""
    with open(os.path.join(base_path, "Controllers", f"{controller_name}.php"), "w", encoding="utf-8") as f:
        f.write(controller_content)

    # 3. VIEWS (Index and Edit)
    table_headers = "".join([f"                        <th>{f}</th>\n" for f in fields])
    table_cells = "".join([f"                        <td><?=$fila['{f}']?></td>\n" for f in fields])
    form_inputs = ""
    edit_inputs = ""
    
    for field in fields:
        if field == pk:
            edit_inputs += f"""            <div class="mb-3">
                <label for="txt_{field}" class="form-label">{field.title()}</label>
                <input type="text" name="txt_{field}" id="txt_{field}" class="form-control" value="<?=$datos['{field}'];?>" readonly>
            </div>\n"""
        else:
            form_inputs += f"""                    <div class="mb-3">
                        <label for="txt_{field}" class="form-label">{field.title()}</label>
                        <input type="text" name="txt_{field}" id="txt_{field}" class="form-control" required>
                    </div>\n"""
            edit_inputs += f"""            <div class="mb-3">
                <label for="txt_{field}" class="form-label">{field.title()}</label>
                <input type="text" name="txt_{field}" id="txt_{field}" class="form-control" value="<?=$datos['{field}'];?>" required>
            </div>\n"""

    view_index = f"""<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<h1 class="mt-4">{table.title()}</h1>
<button type="button" class="btn btn-primary my-3" data-bs-toggle="modal" data-bs-target="#modal{table}">
    Nuevo {table.title()}
</button>
<!-- Modal -->
<div class="modal fade" id="modal{table}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Agregar {table.title()}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="<?=base_url('{route_group}/insertar'); ?>" class="form" method="post">
{form_inputs}                    <button type="submit" class="btn btn-primary w-100">Guardar</button>
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
{table_headers}                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $fila): ?>
                    <tr>
{table_cells}                        <td>
                            <a href="<?=base_url('{route_group}/buscar/').$fila['{pk}'];?>" class="btn btn-sm btn-info">Actualizar</a>
                            <a href="<?=base_url('{route_group}/eliminar/').$fila['{pk}'];?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>"""

    view_edit = f"""<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="card shadow mt-4 mx-auto" style="max-width: 600px;">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">Actualizar {table.title()}</h3>
    </div>
    <div class="card-body">
        <form action="<?=base_url('{route_group}/actualizar'); ?>" class="form" method="post">
{edit_inputs}            <div class="d-flex justify-content-between">
                <a href="<?=base_url('{route_group}')?>" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>"""

    with open(os.path.join(base_path, "Views", f"{table}.php"), "w", encoding="utf-8") as f:
        f.write(view_index)
    with open(os.path.join(base_path, "Views", f"{table}_editar.php"), "w", encoding="utf-8") as f:
        f.write(view_edit)

    # 4. ROUTES
    routes_append += f"""$routes->group('{route_group}', function($routes) {{
    $routes->get('/', '{controller_name}::index');
    $routes->get('eliminar/(:any)', '{controller_name}::eliminar/$1');
    $routes->get('buscar/(:any)', '{controller_name}::buscarId/$1');
    $routes->post('actualizar', '{controller_name}::actualizar');
    $routes->post('insertar', '{controller_name}::insertar');
}});\n"""

with open(os.path.join(base_path, "Config", "Routes.php"), "a", encoding="utf-8") as f:
    f.write(routes_append)

print("All controllers, models, views, and routes generated successfully.")

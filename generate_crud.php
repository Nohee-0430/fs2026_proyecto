<?php
$base_path = "c:\\xampp\\htdocs\\fs2026\\fs2026_proyecto\\app";

$tables = [
    "clientes" => [
        "id" => "cliente_id",
        "fields" => ["cliente_id", "nombre", "correo", "contrasenia", "fecha_registro"],
        "controller" => "ClientesController",
        "model" => "ClientesModel",
        "route_group" => "clientes"
    ],
    "categorias" => [
        "id" => "categoria_id",
        "fields" => ["categoria_id", "nombre", "descripcion"],
        "controller" => "CategoriasController",
        "model" => "CategoriasModel",
        "route_group" => "categorias"
    ],
    "productos" => [
        "id" => "productos_id",
        "fields" => ["productos_id", "categoria_id", "nombre", "descripcion", "imagen", "precio", "stock", "disponibilidad"],
        "controller" => "ProductosController",
        "model" => "ProductosModel",
        "route_group" => "productos"
    ],
    "carritos" => [
        "id" => "carrito_id",
        "fields" => ["carrito_id", "cliente_id", "fecha_creacion", "estado"],
        "controller" => "CarritosController",
        "model" => "CarritosModel",
        "route_group" => "carritos"
    ],
    "detalle_carritos" => [
        "id" => "detalle_carrito_id",
        "fields" => ["detalle_carrito_id", "carrito_id", "producto_id", "cantidad", "precio_unitario"],
        "controller" => "DetalleCarritosController",
        "model" => "DetalleCarritosModel",
        "route_group" => "detalle_carritos"
    ],
    "pedidos" => [
        "id" => "carrito_id",
        "fields" => ["carrito_id", "cliente_id", "empleado_id", "fecha_pedido", "total", "estado", "metodo_pago", "tipo_entrega", "nit"],
        "controller" => "PedidosController",
        "model" => "PedidosModel",
        "route_group" => "pedidos"
    ],
    "detalle_pedidos" => [
        "id" => "detalle_pedido_id",
        "fields" => ["detalle_pedido_id", "carrito_id", "producto_id", "cantidad", "precio_unitario", "subtotal"],
        "controller" => "DetallePedidosController",
        "model" => "DetallePedidosModel",
        "route_group" => "detalle_pedidos"
    ],
    "envios" => [
        "id" => "pedido_id",
        "fields" => ["pedido_id", "direccion", "municipio", "departamento", "estado_envio", "fecha_envio", "fecha_entrega", "referencia_ubicacion", "observaciones"],
        "controller" => "EnviosController",
        "model" => "EnviosModel",
        "route_group" => "envios"
    ],
    "resenias" => [
        "id" => "resenia_id",
        "fields" => ["resenia_id", "cliente_id", "detalle_pedido_id", "calificacion", "comentario", "estado", "fecha_publicacion"],
        "controller" => "ReseniasController",
        "model" => "ReseniasModel",
        "route_group" => "resenias"
    ],
    "lista_deseos" => [
        "id" => "lista_deseo_id",
        "fields" => ["lista_deseo_id", "cliente_id", "producto_id", "fecha_agregado"],
        "controller" => "ListaDeseosController",
        "model" => "ListaDeseosModel",
        "route_group" => "lista_deseos"
    ]
];

$routes_append = "\n\n/* RUTAS GENERADAS AUTOMÁTICAMENTE PARA E-COMMERCE */\n";

foreach ($tables as $table => $data) {
    $controller_name = $data["controller"];
    $model_name = $data["model"];
    $route_group = $data["route_group"];
    $pk = $data["id"];
    $fields = $data["fields"];
    
    // 1. MODEL
    $fields_str = "['" . implode("', '", $fields) . "']";
    $model_content = "<?php\nnamespace App\\Models;\nuse CodeIgniter\\Model;\n\nclass {$model_name} extends Model \n{\n    protected \$table = '{$table}';\n    protected \$primaryKey = '{$pk}';\n    protected \$allowedFields = {$fields_str};\n}\n";
    
    file_put_contents($base_path . "\\Models\\" . $model_name . ".php", $model_content);

    // 2. CONTROLLER
    $insert_array = [];
    foreach ($fields as $field) {
        if ($field != $pk) {
            $insert_array[] = "            '{$field}' => \$this->request->getVar('txt_{$field}')";
        }
    }
    $insert_str = implode(",\n", $insert_array);
    
    $controller_content = "<?php\nnamespace App\\Controllers;\nuse App\\Controllers\\BaseController;\nuse App\\Models\\{$model_name};\n\nclass {$controller_name} extends BaseController\n{\n    public function index()\n    {\n        \$modelo = new {$model_name}();\n        \$datos[\"datos\"] = \$modelo->findAll();\n        return view(\"{$table}\", \$datos);\n    }\n\n    public function buscarId(\$id)\n    {\n        \$modelo = new {$model_name}();\n        \$datos[\"datos\"] = \$modelo->where('{$pk}', \$id)->first();\n        return view(\"{$table}_editar\", \$datos);\n    }\n\n    public function actualizar()\n    {\n        \$id = \$this->request->getVar('txt_{$pk}');\n        \$datos = [\n{$insert_str}\n        ];\n        \$modelo = new {$model_name}();\n        \$modelo->update(\$id, \$datos);\n        return redirect()->to(base_url('{$route_group}'));\n    }\n\n    public function insertar()\n    {\n        \$datos = [\n{$insert_str}\n        ];\n        \$modelo = new {$model_name}();\n        \$modelo->insert(\$datos);\n        return redirect()->to(base_url('{$route_group}'));\n    }\n\n    public function eliminar(\$id)\n    {\n        \$modelo = new {$model_name}();\n        \$modelo->delete(\$id);\n        return redirect()->to(base_url('{$route_group}'));\n    }\n}\n";
    
    file_put_contents($base_path . "\\Controllers\\" . $controller_name . ".php", $controller_content);

    // 3. VIEWS
    $table_headers = "";
    $table_cells = "";
    $form_inputs = "";
    $edit_inputs = "";
    
    foreach ($fields as $field) {
        $table_headers .= "                        <th>" . ucfirst(str_replace('_', ' ', $field)) . "</th>\n";
        $table_cells .= "                        <td><?=\$fila['{$field}']?></td>\n";
        
        if ($field == $pk) {
            $edit_inputs .= "            <div class=\"mb-3\">\n                <label for=\"txt_{$field}\" class=\"form-label\">" . ucfirst(str_replace('_', ' ', $field)) . "</label>\n                <input type=\"text\" name=\"txt_{$field}\" id=\"txt_{$field}\" class=\"form-control\" value=\"<?=\$datos['{$field}'];?>\" readonly>\n            </div>\n";
        } else {
            $form_inputs .= "                    <div class=\"mb-3\">\n                        <label for=\"txt_{$field}\" class=\"form-label\">" . ucfirst(str_replace('_', ' ', $field)) . "</label>\n                        <input type=\"text\" name=\"txt_{$field}\" id=\"txt_{$field}\" class=\"form-control\" required>\n                    </div>\n";
            $edit_inputs .= "            <div class=\"mb-3\">\n                <label for=\"txt_{$field}\" class=\"form-label\">" . ucfirst(str_replace('_', ' ', $field)) . "</label>\n                <input type=\"text\" name=\"txt_{$field}\" id=\"txt_{$field}\" class=\"form-control\" value=\"<?=\$datos['{$field}'];?>\" required>\n            </div>\n";
        }
    }

    $view_index = "<?= \$this->extend('layout/template') ?>\n<?= \$this->section('content') ?>\n<h1 class=\"mt-4\">" . ucfirst($table) . "</h1>\n<button type=\"button\" class=\"btn btn-primary my-3\" data-bs-toggle=\"modal\" data-bs-target=\"#modal{$table}\">\n    Nuevo\n</button>\n<div class=\"modal fade\" id=\"modal{$table}\" tabindex=\"-1\" aria-hidden=\"true\">\n    <div class=\"modal-dialog\">\n        <div class=\"modal-content\">\n            <div class=\"modal-header\">\n                <h1 class=\"modal-title fs-5\">Agregar</h1>\n                <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\"></button>\n            </div>\n            <div class=\"modal-body\">\n                <form action=\"<?=base_url('{$route_group}/insertar'); ?>\" class=\"form\" method=\"post\">\n{$form_inputs}                    <button type=\"submit\" class=\"btn btn-primary w-100\">Guardar</button>\n                </form>\n            </div>\n        </div>\n    </div>\n</div>\n<div class=\"card shadow\">\n    <div class=\"card-body\">\n        <div class=\"table-responsive\">\n            <table class=\"table table-striped table-hover align-middle\">\n                <thead class=\"table-dark\">\n                    <tr>\n{$table_headers}                        <th>Acciones</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    <?php foreach (\$datos as \$fila): ?>\n                    <tr>\n{$table_cells}                        <td>\n                            <a href=\"<?=base_url('{$route_group}/buscar/').\$fila['{$pk}'];?>\" class=\"btn btn-sm btn-info\">Actualizar</a>\n                            <a href=\"<?=base_url('{$route_group}/eliminar/').\$fila['{$pk}'];?>\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('¿Eliminar?');\">Eliminar</a>\n                        </td>\n                    </tr>\n                    <?php endforeach; ?>\n                </tbody>\n            </table>\n        </div>\n    </div>\n</div>\n<?= \$this->endSection() ?>";

    $view_edit = "<?= \$this->extend('layout/template') ?>\n<?= \$this->section('content') ?>\n<div class=\"card shadow mt-4 mx-auto\" style=\"max-width: 600px;\">\n    <div class=\"card-header bg-primary text-white\">\n        <h3 class=\"mb-0\">Actualizar</h3>\n    </div>\n    <div class=\"card-body\">\n        <form action=\"<?=base_url('{$route_group}/actualizar'); ?>\" class=\"form\" method=\"post\">\n{$edit_inputs}            <div class=\"d-flex justify-content-between\">\n                <a href=\"<?=base_url('{$route_group}')?>\" class=\"btn btn-secondary\">Cancelar</a>\n                <button type=\"submit\" class=\"btn btn-primary\">Guardar cambios</button>\n            </div>\n        </form>\n    </div>\n</div>\n<?= \$this->endSection() ?>";

    file_put_contents($base_path . "\\Views\\" . $table . ".php", $view_index);
    file_put_contents($base_path . "\\Views\\" . $table . "_editar.php", $view_edit);

    // 4. ROUTES
    $routes_append .= "\$routes->group('{$route_group}', function(\$routes) {\n    \$routes->get('/', '{$controller_name}::index');\n    \$routes->get('eliminar/(:any)', '{$controller_name}::eliminar/$1');\n    \$routes->get('buscar/(:any)', '{$controller_name}::buscarId/$1');\n    \$routes->post('actualizar', '{$controller_name}::actualizar');\n    \$routes->post('insertar', '{$controller_name}::insertar');\n});\n";
}

file_put_contents($base_path . "\\Config\\Routes.php", $routes_append, FILE_APPEND);

echo "All controllers, models, views, and routes generated successfully.\n";

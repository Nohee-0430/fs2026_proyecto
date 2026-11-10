<?php
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";
require_once "../clases/Productos.php";

Usuarios::iniciarSesionPHP();
if (!Usuarios::esEmpleado()) {
    header("Location: ../index.php?error=acceso_denegado");
    exit;
}

$id             = isset($_POST['txt_id']) ? (int)$_POST['txt_id'] : 0;
$categoriaId    = isset($_POST['txt_categoria_id']) ? (int)$_POST['txt_categoria_id'] : 1;
$nombre         = trim($_POST['txt_nombre'] ?? '');
$descripcion    = trim($_POST['txt_descripcion'] ?? '');
$precio         = (float)($_POST['txt_precio'] ?? 0.0);
$stock          = (int)($_POST['txt_stock'] ?? 0);
$disponibilidad = isset($_POST['txt_disponibilidad']) ? (int)$_POST['txt_disponibilidad'] : 1;
$imagen         = trim($_POST['txt_imagen'] ?? 'bi-box-seam');

if (empty($nombre) || $precio < 0) {
    header("Location: ../admin.php?error=campos_invalidos");
    exit;
}

$datos = [
    'id'             => $id,
    'categoria_id'   => $categoriaId,
    'nombre'         => $nombre,
    'descripcion'    => $descripcion,
    'precio'         => $precio,
    'stock'          => $stock,
    'disponibilidad' => $disponibilidad,
    'imagen'         => $imagen
];

Productos::guardarProducto($datos, $conexionMySQL, $conexionMongo);

if ($id > 0) {
    header("Location: ../admin.php?producto_actualizado=1");
} else {
    header("Location: ../admin.php?producto_creado=1");
}
exit;
?>

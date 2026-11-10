<?php
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";
require_once "../clases/Productos.php";

Usuarios::iniciarSesionPHP();
if (!Usuarios::esEmpleado()) {
    header("Location: ../index.php?error=acceso_denegado");
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    Productos::eliminarProducto($id, $conexionMySQL, $conexionMongo);
    header("Location: ../admin.php?producto_eliminado=1");
    exit;
}

header("Location: ../admin.php");
exit;
?>

<?php
require_once "../conexion/conexion.php";
require_once "../clases/Carrito.php";

$productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($productoId > 0) {
    Carrito::eliminar($productoId, $conexionMySQL);
}

header("Location: ../carrito.php");
exit;
?>

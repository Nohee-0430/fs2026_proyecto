<?php
require_once "../conexion/conexion.php";
require_once "../clases/Productos.php";
require_once "../clases/Carrito.php";
require_once "../helpers.php";

$productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
$cantidad = isset($_POST['cantidad']) ? max(1, (int)$_POST['cantidad']) : 1;
$nota = isset($_POST['nota']) ? trim($_POST['nota']) : '';

if ($productoId > 0) {
    $producto = Productos::obtenerPorId($productoId, $conexionMySQL, $conexionMongo);
    if ($producto) {
        Carrito::agregar($producto, $cantidad, $nota, $conexionMySQL);
    }
}

$destino = isset($_POST['ir_a_carrito']) && $_POST['ir_a_carrito'] == '1' ? '../carrito.php' : '../index.php?agregado=1';
header("Location: " . $destino);
exit;
?>

<?php
/**
 * Objeto procesador: Eliminar producto del Carrito
 */
require_once "../clases/Carrito.php";

$productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($productoId > 0) {
    Carrito::eliminar($productoId);
}

header("Location: ../carrito.php");
exit;
?>

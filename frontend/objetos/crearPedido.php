<?php
require_once "../conexion/conexion.php";
require_once "../clases/Carrito.php";
require_once "../clases/Pedidos.php";
require_once "../helpers.php";

$items = Carrito::obtenerItems();

if (empty($items)) {
    header("Location: ../carrito.php?error=vacio");
    exit;
}

$tipoEntrega = !empty($_POST['tipo_entrega']) ? trim($_POST['tipo_entrega']) : 'Recoger en Tienda';
$subtotal    = Carrito::obtenerTotal();
$costoEnvio  = ($tipoEntrega === 'Recoger en Tienda') ? 0.00 : 25.00;
$total       = $subtotal + $costoEnvio;

$direccion = trim($_POST['direccion'] ?? '');
if (empty($direccion) || $tipoEntrega === 'Recoger en Tienda') {
    $direccion = 'Recoger en Tienda Central';
}

$datos = [
    'cliente'      => !empty($_POST['cliente']) ? trim($_POST['cliente']) : 'Cliente General',
    'telefono'     => !empty($_POST['telefono']) ? trim($_POST['telefono']) : 'N/A',
    'direccion'    => $direccion,
    'tipo_entrega' => $tipoEntrega,
    'metodo_pago'  => !empty($_POST['metodo_pago']) ? trim($_POST['metodo_pago']) : 'Efectivo contra entrega',
    'total'        => $total,
    'items'        => array_values($items)
];

$pedido = Pedidos::crearPedido($datos, $conexionMySQL, $conexionMongo);

Carrito::vaciar($conexionMySQL);

header("Location: ../pedidos.php?creado=" . urlencode($pedido['codigo']));
exit;
?>

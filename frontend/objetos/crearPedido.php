<?php
/**
 * Objeto procesador: Confirmar pedido y guardarlo en MongoDB
 */
require_once "../conexion/conexion.php";
require_once "../clases/Carrito.php";
require_once "../clases/Pedidos.php";
require_once "../helpers.php";

$items = Carrito::obtenerItems();

if (empty($items)) {
    header("Location: ../carrito.php?error=vacio");
    exit;
}

$datos = [
    'cliente' => !empty($_POST['cliente']) ? trim($_POST['cliente']) : 'Cliente General',
    'telefono' => !empty($_POST['telefono']) ? trim($_POST['telefono']) : 'N/A',
    'direccion' => !empty($_POST['direccion']) ? trim($_POST['direccion']) : 'Recoger en tienda',
    'tipo_entrega' => !empty($_POST['tipo_entrega']) ? trim($_POST['tipo_entrega']) : 'Recoger en tienda',
    'metodo_pago' => !empty($_POST['metodo_pago']) ? trim($_POST['metodo_pago']) : 'Efectivo',
    'total' => Carrito::obtenerTotal(),
    'items' => array_values($items)
];

// Guardar en MongoDB y sesión
$pedido = Pedidos::crearPedido($datos, $conexionMongo);

// Vaciar el carrito tras compra exitosa
Carrito::vaciar();

header("Location: ../pedidos.php?creado=" . urlencode($pedido['codigo']));
exit;
?>

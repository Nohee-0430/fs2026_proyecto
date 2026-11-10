<?php
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";
require_once "../clases/Pedidos.php";

Usuarios::iniciarSesionPHP();
if (!Usuarios::esEmpleado()) {
    header("Location: ../index.php?error=acceso_denegado");
    exit;
}

$codigo = trim($_POST['txt_codigo'] ?? '');
$estado = trim($_POST['txt_estado'] ?? '');

if (!empty($codigo) && !empty($estado)) {
    Pedidos::actualizarEstado($codigo, $estado, $conexionMySQL, $conexionMongo);
    header("Location: ../admin.php?pedido_actualizado=1#pedidos");
    exit;
}

header("Location: ../admin.php#pedidos");
exit;
?>

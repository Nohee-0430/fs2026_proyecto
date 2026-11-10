<?php
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";

$nombre  = trim($_POST['txtNombre'] ?? '');
$usuario = trim($_POST['txtUsuario'] ?? '');
$contra  = $_POST['txtPassword'] ?? '';
$tipo    = isset($_POST['txtTipoUsuario']) ? (int)$_POST['txtTipoUsuario'] : 1;

if (!empty($usuario) && !empty($contra) && !empty($nombre)) {
    Usuarios::agregarUsuario($usuario, $nombre, $contra, $tipo, $conexionMySQL, $conexionMongo);
    
    if (isset($_POST['origen']) && $_POST['origen'] === 'admin') {
        header("Location: ../admin.php?usuario_creado=1#usuarios");
        exit;
    }

    if ($tipo === 2) {
        header("Location: ../login.php?registrado=empleado");
    } else {
        header("Location: ../login.php?registrado=cliente");
    }
    exit;
} else {
    header("Location: ../frm_crear_usuario.php?error=vacio");
    exit;
}
?>

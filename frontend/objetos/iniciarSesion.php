<?php
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";

$usuario = trim($_POST['txtUsuario'] ?? '');
$contra  = $_POST['txtPassword'] ?? '';

if (empty($usuario) || empty($contra)) {
    header("Location: ../login.php?error=vacio");
    exit;
}

$datos = Usuarios::autenticar($usuario, $contra, $conexionMySQL, $conexionMongo);

if ($datos) {
    $tipo = (int)($datos['tipo_usuario_id'] ?? 1);
    
    if ($tipo === 2) {
        header("Location: ../../backend/public/productos");
    } else {
        header("Location: ../index.php?bienvenido=1");
    }
    exit;
} else {
    header("Location: ../login.php?error=1");
    exit;
}
?>

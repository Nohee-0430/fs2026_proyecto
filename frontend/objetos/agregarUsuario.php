<?php
/**
 * Objeto procesador: Agregar Usuario
 * Basado en la lógica del UsuariosController:
 * - Recibe txtNombre, txtUsuario, txtPassword
 * - Encripta la contraseña con password_hash
 * - Asigna tipo_usuario_id (1 = cliente, 2 = empleado)
 * - Guarda en MongoDB y redirige al login
 */
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";

$nombre = trim($_POST['txtNombre'] ?? '');
$usuario = trim($_POST['txtUsuario'] ?? '');
$contra = $_POST['txtPassword'] ?? '';
$tipo = isset($_POST['txtTipoUsuario']) ? (int)$_POST['txtTipoUsuario'] : 1;

if (!empty($usuario) && !empty($contra) && !empty($nombre)) {
    Usuarios::agregarUsuario($usuario, $nombre, $contra, $tipo, $conexionMongo);
    header("Location: ../login.php?registrado=1");
    exit;
} else {
    header("Location: ../frm_crear_usuario.php?error=vacio");
    exit;
}
?>

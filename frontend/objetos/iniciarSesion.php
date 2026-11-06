<?php
/**
 * Objeto procesador: Iniciar Sesión
 * Basado en la lógica del UsuariosController:
 * - Recibe txtUsuario y txtPassword
 * - Verifica contraseña con password_verify
 * - Guarda variables de sesión (usuario, nombre, tipo)
 * - Redirige según el tipo de usuario (1 = cliente, 2 = empleado)
 */
require_once "../conexion/conexion.php";
require_once "../clases/Usuarios.php";

// Recibir los datos del formulario (mismos nombres que en clase)
$usuario = $_POST['txtUsuario'] ?? '';
$contra = $_POST['txtPassword'] ?? '';

$datos = Usuarios::autenticar($usuario, $contra, $conexionMongo);

if ($datos) {
    // Redireccionar al menú correspondiente (igual que en tu clase)
    if ($datos['tipo_usuario_id'] == 1) {
        // Menú cliente -> Catálogo de la tienda
        header("Location: ../index.php?bienvenido=1");
    } elseif ($datos['tipo_usuario_id'] == 2) {
        // Menú empleado -> Panel exclusivo de administración (admin.php)
        header("Location: ../admin.php?bienvenido_admin=1");
    } else {
        header("Location: ../index.php");
    }
    exit;
} else {
    // Datos incorrectos
    header("Location: ../login.php?error=1");
    exit;
}
?>

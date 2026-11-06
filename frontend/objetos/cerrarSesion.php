<?php
/**
 * Objeto procesador: Cerrar Sesión
 * Se destruyen las variables de sesión y se redirige a la página principal
 */
require_once "../clases/Usuarios.php";

Usuarios::cerrarSesion();
header("Location: ../index.php");
exit;
?>

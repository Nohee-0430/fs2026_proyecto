<?php
require_once "../clases/Usuarios.php";

Usuarios::cerrarSesion();
header("Location: ../index.php");
exit;
?>

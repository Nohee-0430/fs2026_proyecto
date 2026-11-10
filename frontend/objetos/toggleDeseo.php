<?php
require_once "../clases/Deseos.php";

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_GET['id']) ? (int)$_GET['id'] : 0);

if ($id > 0) {
    Deseos::toggle($id);
}

$retorno = $_SERVER['HTTP_REFERER'] ?? '../index.php';
header("Location: " . $retorno);
exit;
?>

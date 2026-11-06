<?php
/**
 * Conexión a la base de datos MongoDB
 * Servidor local: mongodb://127.0.0.1:27017
 * Base de datos: fs2026_proyecto
 */

$mongoHost = "127.0.0.1";
$mongoPort = "27017";
$mongoDatabase = "fs2026_proyecto";
$mongoUri = "mongodb://{$mongoHost}:{$mongoPort}";

$conexionMongo = null;
$mongoConectado = false;
$mensajeMongo = "";

// Verificamos si la extensión de MongoDB para PHP está instalada en XAMPP
if (extension_loaded('mongodb')) {
    try {
        $conexionMongo = new MongoDB\Driver\Manager($mongoUri);
        $mongoConectado = true;
        $mensajeMongo = "Conectado exitosamente a MongoDB ({$mongoDatabase})";
    } catch (Exception $e) {
        $conexionMongo = null;
        $mongoConectado = false;
        $mensajeMongo = "Error al conectar a MongoDB: " . $e->getMessage();
    }
} else {
    $conexionMongo = null;
    $mongoConectado = false;
    $mensajeMongo = "Aviso: La extensión 'php_mongodb.dll' no está activa en tu XAMPP aún.";
}
?>

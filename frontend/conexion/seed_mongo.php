<?php
/**
 * Script para sembrar (insertar) los productos iniciales en MongoDB
 * Ejecutar desde el navegador: http://localhost/fs2026/fs2026_proyecto/frontend/conexion/seed_mongo.php
 */
require_once "conexion.php";
require_once "../clases/Productos.php";

echo "<h2>Sembrador de Productos en MongoDB</h2>";

if (!$mongoConectado || !($conexionMongo instanceof MongoDB\Driver\Manager)) {
    echo "<p style='color:red;'><strong>No se pudo conectar a MongoDB:</strong> " . htmlspecialchars($mensajeMongo) . "</p>";
    echo "<p>Para conectar MongoDB con PHP en XAMPP necesitas tener la extensión <code>php_mongodb.dll</code> en tu carpeta <code>C:\\xampp\\php\\ext\\</code> y habilitada en <code>php.ini</code>.</p>";
    echo "<p><a href='../index.php'>Volver a la tienda</a></p>";
    exit;
}

$productos = Productos::catalogoPorDefecto();

try {
    $bulk = new MongoDB\Driver\BulkWrite();
    // Limpiar colección previa
    $bulk->delete([]);
    foreach ($productos as $p) {
        $bulk->insert($p);
    }
    $conexionMongo->executeBulkWrite("fs2026_proyecto.productos", $bulk);
    echo "<p style='color:green;'><strong>¡Éxito!</strong> Se insertaron " . count($productos) . " productos en la colección <code>productos</code> de la base de datos <code>fs2026_proyecto</code>.</p>";
} catch (Exception $e) {
    echo "<p style='color:red;'>Error al sembrar en MongoDB: " . $e->getMessage() . "</p>";
}

echo "<p><a href='../index.php'>Ir al Catálogo de la Tienda</a></p>";
?>

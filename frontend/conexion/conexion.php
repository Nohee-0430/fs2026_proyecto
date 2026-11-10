<?php
$mysqlHost = "127.0.0.1";
$mysqlUser = "root";
$mysqlPass = "";
$mysqlDb   = "fs2026_proyecto";
$mysqlPort = 3306;

$conexionMySQL = null;
$mysqlConectado = false;
$mensajeMySQL  = "";

try {
    $conexionMySQL = @new mysqli($mysqlHost, $mysqlUser, $mysqlPass, $mysqlDb, $mysqlPort);
    
    if (!$conexionMySQL->connect_error) {
        $conexionMySQL->set_charset("utf8mb4");
        $mysqlConectado = true;
        $mensajeMySQL = "Conectado a MySQL";
        inicializarBaseDatosMySQL($conexionMySQL);
    } else {
        $mysqlConectado = false;
        $mensajeMySQL = "Error al conectar a MySQL: " . $conexionMySQL->connect_error;
    }
} catch (Exception $e) {
    $mysqlConectado = false;
    $mensajeMySQL = "Error: " . $e->getMessage();
}

function inicializarBaseDatosMySQL($db)
{
    $checkCat = $db->query("SELECT COUNT(*) AS total FROM categorias");
    if ($checkCat) {
        $row = $checkCat->fetch_assoc();
        if ((int)($row['total'] ?? 0) === 0) {
            $db->query("INSERT INTO categorias (categoria_id, nombre, descripcion) VALUES
                (1, 'Hojas Comestibles', 'Papel de azúcar, obleas y transfer para repostería'),
                (2, 'Tintas Comestibles', 'Tintas de grado alimenticio certificadas para impresión'),
                (3, 'Impresiones Personalizadas', 'Servicios de impresión personalizada de alta calidad'),
                (4, 'Impresoras Adaptadas', 'Equipos especializados y adaptados para tinta comestible'),
                (5, 'Soluciones de Limpieza', 'Mantenimiento y destape de cabezales alimentarios')");
        }
    }

    $checkEmp = $db->query("SELECT COUNT(*) AS total FROM empleados WHERE correo = 'admin'");
    if ($checkEmp) {
        $row = $checkEmp->fetch_assoc();
        if ((int)($row['total'] ?? 0) === 0) {
            $hash = password_hash('123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO empleados (nombre, correo, contrasenia, rol, fecha_registro) VALUES (?, ?, ?, ?, ?)");
            if ($stmt) {
                $nombre = 'Administrador Dulce Impresión';
                $correo = 'admin';
                $rol = 'Administrador';
                $fecha = date('Y-m-d');
                $stmt->bind_param("sssss", $nombre, $correo, $hash, $rol, $fecha);
                $stmt->execute();
            }
        }
    }

    $checkCli = $db->query("SELECT COUNT(*) AS total FROM clientes WHERE correo = 'nohelia'");
    if ($checkCli) {
        $row = $checkCli->fetch_assoc();
        if ((int)($row['total'] ?? 0) === 0) {
            $hash = password_hash('123', PASSWORD_DEFAULT);
            $stmt = $db->prepare("INSERT INTO clientes (nombre, correo, contrasenia, fecha_registro) VALUES (?, ?, ?, ?)");
            if ($stmt) {
                $nombre = 'Nohelia Barillas';
                $correo = 'nohelia';
                $fecha = date('Y-m-d');
                $stmt->bind_param("ssss", $nombre, $correo, $hash, $fecha);
                $stmt->execute();
            }
        }
    }

    $checkProd = $db->query("SELECT COUNT(*) AS total FROM productos");
    if ($checkProd) {
        $row = $checkProd->fetch_assoc();
        if ((int)($row['total'] ?? 0) === 0) {
            $productos = [
                [1, 1, 'Hojas Papel de Azúcar A4', 'Pack x 24 hojas flexibles con acabado de gran nitidez para repostería', 'bi-file-earmark-richtext', 210.00, 35, 1],
                [2, 2, 'Kit Tintas Comestibles CMYK', '4 botellas 100ml c/u (Cian, Magenta, Amarillo, Negro) grado alimenticio', 'bi-droplet-half', 350.00, 18, 1],
                [3, 3, 'Impresión Foto Pastel A4', 'Servicio personalizado con foto en hoja de azúcar de alta resolución', 'bi-camera', 45.00, 99, 1],
                [4, 1, 'Hojas Papel de Arroz A4', 'Pack x 24 obleas comestibles para galletas, merengues y turrón', 'bi-file-earmark', 125.00, 24, 1],
                [5, 3, 'Discos Cupcake (x12 5cm)', '12 toppers redondos precortados impresos en azúcar para cupcakes', 'bi-circle', 35.00, 50, 1],
                [6, 2, 'Tinta Comestible Negra 100ml', 'Alta densidad para bordes definidos y textos nítidos en pasteles', 'bi-paint-bucket', 95.00, 40, 1],
                [7, 4, 'Impresora Canon Adaptada', 'Equipada y lista para uso exclusivo con tintas comestibles alimentarias', 'bi-printer', 1850.00, 5, 1],
                [8, 5, 'Limpiador Cabezales 100ml', 'Líquido grado alimentario para mantenimiento y destape de inyectores', 'bi-wrench-adjustable', 65.00, 15, 1]
            ];
            $stmt = $db->prepare("INSERT INTO productos (productos_id, categoria_id, nombre, descripcion, imagen, precio, stock, disponibilidad) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                foreach ($productos as $p) {
                    $stmt->bind_param("iisssidi", $p[0], $p[1], $p[2], $p[3], $p[4], $p[5], $p[6], $p[7]);
                    $stmt->execute();
                }
            }
        }
    }
}

$mongoHost = "127.0.0.1";
$mongoPort = "27017";
$mongoDatabase = "fs2026_proyecto";
$mongoUri = "mongodb://" . $mongoHost . ":" . $mongoPort;

$conexionMongo = null;
$mongoConectado = false;
$mensajeMongo = "";

if (extension_loaded('mongodb')) {
    try {
        $conexionMongo = new MongoDB\Driver\Manager($mongoUri);
        $mongoConectado = true;
        $mensajeMongo = "Conectado a MongoDB";
    } catch (Exception $e) {
        $conexionMongo = null;
        $mongoConectado = false;
        $mensajeMongo = "Error MongoDB: " . $e->getMessage();
    }
}
?>

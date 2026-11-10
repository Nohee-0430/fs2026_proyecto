<?php
class Carrito
{
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public static function agregar($producto, $cantidad = 1, $nota = '', $conexionMySQL = null)
    {
        self::iniciar();
        $id = (int)$producto['id'];

        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad'] += $cantidad;
            $_SESSION['carrito'][$id]['subtotal'] = $_SESSION['carrito'][$id]['cantidad'] * $_SESSION['carrito'][$id]['precio'];
            if (!empty($nota)) {
                $_SESSION['carrito'][$id]['nota'] = $nota;
            }
        } else {
            $_SESSION['carrito'][$id] = [
                'id' => $id,
                'nombre' => $producto['nombre'],
                'categoria' => $producto['categoria'] ?? '',
                'precio' => (float)$producto['precio'],
                'cantidad' => $cantidad,
                'nota' => $nota,
                'icono' => $producto['icono'] ?? 'bi-box-seam',
                'subtotal' => $cantidad * (float)$producto['precio']
            ];
        }

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $clienteId = (int)($_SESSION['usuario_id'] ?? 1);
            
            $chkCli = $conexionMySQL->query("SELECT cliente_id FROM clientes WHERE cliente_id = {$clienteId} LIMIT 1");
            if (!$chkCli || $chkCli->num_rows === 0) {
                $cFirst = $conexionMySQL->query("SELECT cliente_id FROM clientes LIMIT 1");
                if ($cFirst && $rf = $cFirst->fetch_assoc()) {
                    $clienteId = (int)$rf['cliente_id'];
                }
            }

            $carritoId = (int)($_SESSION['carrito_mysql_id'] ?? 0);
            $existeCarrito = false;
            if ($carritoId > 0) {
                $chkCar = $conexionMySQL->query("SELECT carrito_id FROM carritos WHERE carrito_id = {$carritoId} AND estado = 'En Proceso' LIMIT 1");
                if ($chkCar && $chkCar->num_rows > 0) {
                    $existeCarrito = true;
                }
            }

            if (!$existeCarrito) {
                $stmtCar = $conexionMySQL->prepare("INSERT INTO carritos (cliente_id, fecha_creacion, estado) VALUES (?, CURDATE(), 'En Proceso')");
                if ($stmtCar) {
                    $stmtCar->bind_param("i", $clienteId);
                    $stmtCar->execute();
                    $carritoId = $conexionMySQL->insert_id;
                    $_SESSION['carrito_mysql_id'] = $carritoId;
                }
            }

            if ($carritoId > 0) {
                $chkDet = $conexionMySQL->query("SELECT detalle_carrito_id, cantidad FROM detalle_carritos WHERE carrito_id = {$carritoId} AND producto_id = {$id} LIMIT 1");
                if ($chkDet && $rDet = $chkDet->fetch_assoc()) {
                    $nuevaCant = (int)$_SESSION['carrito'][$id]['cantidad'];
                    $detId = (int)$rDet['detalle_carrito_id'];
                    $conexionMySQL->query("UPDATE detalle_carritos SET cantidad = {$nuevaCant} WHERE detalle_carrito_id = {$detId}");
                } else {
                    $stmtDet = $conexionMySQL->prepare("INSERT INTO detalle_carritos (carrito_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)");
                    if ($stmtDet) {
                        $precio = (float)$producto['precio'];
                        $stmtDet->bind_param("iiid", $carritoId, $id, $cantidad, $precio);
                        $stmtDet->execute();
                    }
                }
            }
        }
    }

    public static function eliminar($id, $conexionMySQL = null)
    {
        self::iniciar();
        $id = (int)$id;
        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $carritoId = (int)($_SESSION['carrito_mysql_id'] ?? 0);
            if ($carritoId > 0) {
                $conexionMySQL->query("DELETE FROM detalle_carritos WHERE carrito_id = {$carritoId} AND producto_id = {$id}");
            }
        }
    }

    public static function obtenerItems()
    {
        self::iniciar();
        return $_SESSION['carrito'] ?? [];
    }

    public static function contarItems()
    {
        self::iniciar();
        $total = 0;
        foreach (self::obtenerItems() as $item) {
            $total += (int)$item['cantidad'];
        }
        return $total;
    }

    public static function obtenerTotal()
    {
        self::iniciar();
        $total = 0.0;
        foreach (self::obtenerItems() as $item) {
            $total += (float)$item['subtotal'];
        }
        return $total;
    }

    public static function vaciar($conexionMySQL = null)
    {
        self::iniciar();
        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $carritoId = (int)($_SESSION['carrito_mysql_id'] ?? 0);
            if ($carritoId > 0) {
                $conexionMySQL->query("UPDATE carritos SET estado = 'Confirmado' WHERE carrito_id = {$carritoId}");
            }
        }
        unset($_SESSION['carrito_mysql_id']);
        $_SESSION['carrito'] = [];
    }
}
?>

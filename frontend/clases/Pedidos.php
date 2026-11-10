<?php
class Pedidos
{
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['pedidos'])) {
            $_SESSION['pedidos'] = [];
        }
    }

    public static function crearPedido($datos, $conexionMySQL = null, $conexionMongo = null)
    {
        self::iniciar();

        $numero = count($_SESSION['pedidos']) + 1;
        $codigo = 'PED-' . date('Y') . '-' . str_pad((string)$numero, 3, '0', STR_PAD_LEFT);
        
        $nuevoPedido = [
            'codigo' => $codigo,
            'cliente' => $datos['cliente'] ?? 'Cliente General',
            'telefono' => $datos['telefono'] ?? '',
            'direccion' => $datos['direccion'] ?? 'Recoger en Tienda Central',
            'tipo_entrega' => $datos['tipo_entrega'] ?? 'Recoger en Tienda',
            'metodo_pago' => $datos['metodo_pago'] ?? 'Efectivo contra entrega',
            'fecha' => date('Y-m-d H:i:s'),
            'total' => (float)($datos['total'] ?? 0.0),
            'estado' => 'En Preparación',
            'guia_tracking' => 'GT-' . rand(10000, 99999),
            'items' => $datos['items'] ?? []
        ];

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $clienteId = (int)($_SESSION['usuario_id'] ?? 1);
            $empleadoId = 1;
            $fecha = date('Y-m-d');
            $total = (float)$nuevoPedido['total'];
            $estado = $nuevoPedido['estado'];
            $nit = 'C/F';
            $metodo = $nuevoPedido['metodo_pago'];
            $entrega = $nuevoPedido['tipo_entrega'];

            $chkCli = $conexionMySQL->query("SELECT cliente_id FROM clientes WHERE cliente_id = {$clienteId} LIMIT 1");
            if (!$chkCli || $chkCli->num_rows === 0) {
                $cFirst = $conexionMySQL->query("SELECT cliente_id FROM clientes LIMIT 1");
                if ($cFirst && $r = $cFirst->fetch_assoc()) {
                    $clienteId = (int)$r['cliente_id'];
                }
            }

            $chkEmp = $conexionMySQL->query("SELECT empleado_id FROM empleados LIMIT 1");
            if ($chkEmp && $r = $chkEmp->fetch_assoc()) {
                $empleadoId = (int)$r['empleado_id'];
            }

            $stmt = $conexionMySQL->prepare("INSERT INTO pedidos (cliente_id, empleado_id, fecha_pedido, total, estado, nit, metodo_pago, tipo_entrega) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("iisdssss", $clienteId, $empleadoId, $fecha, $total, $estado, $nit, $metodo, $entrega);
                $stmt->execute();
                $pedidoId = $conexionMySQL->insert_id;

                if ($pedidoId > 0) {
                    $codigo = 'PED-' . date('Y') . '-' . str_pad((string)$pedidoId, 3, '0', STR_PAD_LEFT);
                    $nuevoPedido['codigo'] = $codigo;
                    $nuevoPedido['id'] = $pedidoId;

                    if (!empty($nuevoPedido['items'])) {
                        $stmtDet = $conexionMySQL->prepare("INSERT INTO detalle_pedidos (carrito_id, producto_id, cantidad, precio_unitario, subtotal) VALUES (?, ?, ?, ?, ?)");
                        if ($stmtDet) {
                            foreach ($nuevoPedido['items'] as $item) {
                                $prodId = (int)($item['id'] ?? 1);
                                $cant   = (int)($item['cantidad'] ?? 1);
                                $precio = (float)($item['precio'] ?? 0.0);
                                $subtot = (float)($item['subtotal'] ?? ($precio * $cant));
                                $stmtDet->bind_param("iiidd", $pedidoId, $prodId, $cant, $precio, $subtot);
                                $stmtDet->execute();
                            }
                        }
                    }
                }
            }
        }

        if ($conexionMongo) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->insert($nuevoPedido);
                $conexionMongo->executeBulkWrite('fs2026_proyecto.pedidos', $bulk);
            } catch (Exception $e) {
            }
        }

        $_SESSION['pedidos'][$codigo] = $nuevoPedido;

        return $nuevoPedido;
    }

    public static function obtenerPedidos($conexionMySQL = null, $conexionMongo = null)
    {
        self::iniciar();
        $pedidos = [];

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $sql = "SELECT p.*, c.nombre AS cliente_nombre, c.correo AS cliente_correo 
                    FROM pedidos p 
                    LEFT JOIN clientes c ON p.cliente_id = c.cliente_id 
                    ORDER BY p.carrito_id DESC";
            $res = $conexionMySQL->query($sql);
            if ($res && $res->num_rows > 0) {
                while ($row = $res->fetch_assoc()) {
                    $numId = (int)$row['carrito_id'];
                    $cod = 'PED-' . date('Y', strtotime($row['fecha_pedido'])) . '-' . str_pad((string)$numId, 3, '0', STR_PAD_LEFT);
                    
                    $items = [];
                    $qDet = $conexionMySQL->query("SELECT dp.*, pr.nombre AS producto_nombre 
                                                   FROM detalle_pedidos dp 
                                                   LEFT JOIN productos pr ON dp.producto_id = pr.productos_id 
                                                   WHERE dp.carrito_id = {$numId}");
                    if ($qDet && $qDet->num_rows > 0) {
                        while ($det = $qDet->fetch_assoc()) {
                            $items[] = [
                                'id' => (int)$det['producto_id'],
                                'nombre' => $det['producto_nombre'] ?? ('Insumo #' . $det['producto_id']),
                                'cantidad' => (int)$det['cantidad'],
                                'precio' => (float)$det['precio_unitario'],
                                'subtotal' => (float)$det['subtotal']
                            ];
                        }
                    }

                    $pedidos[$cod] = [
                        'id' => $numId,
                        'codigo' => $cod,
                        'cliente' => $row['cliente_nombre'] ?? 'Cliente General',
                        'telefono' => 'N/A',
                        'direccion' => ($row['tipo_entrega'] === 'Recoger en Tienda') ? 'Recoger en Tienda Central' : 'Entrega a Domicilio',
                        'tipo_entrega' => $row['tipo_entrega'],
                        'metodo_pago' => $row['metodo_pago'],
                        'fecha' => $row['fecha_pedido'],
                        'total' => (float)$row['total'],
                        'estado' => $row['estado'],
                        'guia_tracking' => 'GT-' . (20000 + $numId),
                        'items' => $items
                    ];
                }
            }
        }

        if (empty($pedidos) && $conexionMongo) {
            try {
                $query = new MongoDB\Driver\Query([], ['sort' => ['fecha' => -1]]);
                $cursor = $conexionMongo->executeQuery('fs2026_proyecto.pedidos', $query);
                foreach ($cursor as $doc) {
                    $docArray = (array)$doc;
                    if (isset($docArray['codigo']) && !isset($pedidos[$docArray['codigo']])) {
                        $pedidos[$docArray['codigo']] = $docArray;
                    }
                }
            } catch (Exception $e) {
            }
        }

        if (empty($pedidos) && !empty($_SESSION['pedidos'])) {
            $pedidos = $_SESSION['pedidos'];
        }

        return $pedidos;
    }

    public static function actualizarEstado($codigo, $nuevoEstado, $conexionMySQL = null, $conexionMongo = null)
    {
        self::iniciar();
        $codigo = trim($codigo);
        $nuevoEstado = trim($nuevoEstado);

        if (isset($_SESSION['pedidos'][$codigo])) {
            $_SESSION['pedidos'][$codigo]['estado'] = $nuevoEstado;
        }

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $partes = explode('-', $codigo);
            $numId = (int)end($partes);
            if ($numId > 0) {
                $stmt = $conexionMySQL->prepare("UPDATE pedidos SET estado = ? WHERE carrito_id = ?");
                if ($stmt) {
                    $stmt->bind_param("si", $nuevoEstado, $numId);
                    $stmt->execute();
                }
            }
        }

        if ($conexionMongo) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->update(['codigo' => $codigo], ['$set' => ['estado' => $nuevoEstado]]);
                $conexionMongo->executeBulkWrite('fs2026_proyecto.pedidos', $bulk);
            } catch (Exception $e) {
            }
        }

        return true;
    }
}
?>

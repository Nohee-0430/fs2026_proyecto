<?php
/**
 * Clase Pedidos
 * Registra y consulta pedidos en MongoDB (y mantiene historial en sesión)
 */
class Pedidos
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['pedidos'])) {
            $_SESSION['pedidos'] = [];
        }
    }

    /**
     * Registrar un nuevo pedido en MongoDB
     */
    public static function crearPedido(array $datos, $conexionMongo = null): array
    {
        self::iniciar();

        $codigo = 'PED-' . date('Y') . '-' . str_pad((string)(count($_SESSION['pedidos']) + 1), 2, '0', STR_PAD_LEFT);
        
        $nuevoPedido = [
            'codigo' => $codigo,
            'cliente' => $datos['cliente'] ?? 'Cliente General',
            'telefono' => $datos['telefono'] ?? '',
            'direccion' => $datos['direccion'] ?? 'Recoger en tienda',
            'tipo_entrega' => $datos['tipo_entrega'] ?? 'Recoger en tienda',
            'metodo_pago' => $datos['metodo_pago'] ?? 'Efectivo contra entrega',
            'fecha' => date('Y-m-d H:i:s'),
            'total' => (float)($datos['total'] ?? 0.0),
            'estado' => 'En Preparación',
            'guia_tracking' => 'GT-' . rand(10000, 99999),
            'items' => $datos['items'] ?? []
        ];

        // 1. Guardar en MongoDB si hay conexión activa
        if ($conexionMongo instanceof MongoDB\Driver\Manager) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->insert($nuevoPedido);
                $conexionMongo->executeBulkWrite('fs2026_proyecto.pedidos', $bulk);
            } catch (Exception $e) {
                // Registro local en caso de error
            }
        }

        // 2. Guardar en la sesión para que el estudiante siempre lo vea de inmediato
        $_SESSION['pedidos'][$codigo] = $nuevoPedido;

        return $nuevoPedido;
    }

    /**
     * Obtener listado de pedidos
     */
    public static function obtenerPedidos($conexionMongo = null): array
    {
        self::iniciar();
        $pedidos = $_SESSION['pedidos'] ?? [];

        // Si hay conexión con MongoDB, consultamos los pedidos en la base de datos
        if ($conexionMongo instanceof MongoDB\Driver\Manager) {
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
                // Manejo silencioso
            }
        }

        return $pedidos;
    }
}
?>

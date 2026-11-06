<?php
/**
 * Clase Carrito
 * Maneja los productos seleccionados usando sesiones nativas de PHP ($_SESSION)
 */
class Carrito
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

    public static function agregar(array $producto, int $cantidad = 1, string $nota = ''): void
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
    }

    public static function eliminar(int $id): void
    {
        self::iniciar();
        if (isset($_SESSION['carrito'][$id])) {
            unset($_SESSION['carrito'][$id]);
        }
    }

    public static function obtenerItems(): array
    {
        self::iniciar();
        return $_SESSION['carrito'] ?? [];
    }

    public static function contarItems(): int
    {
        self::iniciar();
        $total = 0;
        foreach (self::obtenerItems() as $item) {
            $total += (int)$item['cantidad'];
        }
        return $total;
    }

    public static function obtenerTotal(): float
    {
        self::iniciar();
        $total = 0.0;
        foreach (self::obtenerItems() as $item) {
            $total += (float)$item['subtotal'];
        }
        return $total;
    }

    public static function vaciar(): void
    {
        self::iniciar();
        $_SESSION['carrito'] = [];
    }
}
?>

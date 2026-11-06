<?php
/**
 * Clase Deseos
 * Maneja la lista de deseos en la sesión del usuario
 */
class Deseos
{
    public static function iniciar(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['deseos'])) {
            $_SESSION['deseos'] = [];
        }
    }

    public static function toggle(int $id): bool
    {
        self::iniciar();
        $pos = array_search($id, $_SESSION['deseos']);
        if ($pos !== false) {
            unset($_SESSION['deseos'][$pos]);
            $_SESSION['deseos'] = array_values($_SESSION['deseos']);
            return false; // Eliminado
        } else {
            $_SESSION['deseos'][] = $id;
            return true; // Agregado
        }
    }

    public static function contiene(int $id): bool
    {
        self::iniciar();
        return in_array($id, $_SESSION['deseos'] ?? []);
    }

    public static function contar(): int
    {
        self::iniciar();
        return count($_SESSION['deseos'] ?? []);
    }

    public static function obtenerIds(): array
    {
        self::iniciar();
        return $_SESSION['deseos'] ?? [];
    }
}
?>

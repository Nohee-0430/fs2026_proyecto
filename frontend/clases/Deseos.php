<?php
class Deseos
{
    public static function iniciar()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }
        if (!isset($_SESSION['deseos'])) {
            $_SESSION['deseos'] = [];
        }
    }

    public static function toggle($id)
    {
        self::iniciar();
        $id = (int)$id;
        $pos = array_search($id, $_SESSION['deseos']);
        if ($pos !== false) {
            unset($_SESSION['deseos'][$pos]);
            $_SESSION['deseos'] = array_values($_SESSION['deseos']);
            return false;
        } else {
            $_SESSION['deseos'][] = $id;
            return true;
        }
    }

    public static function contiene($id)
    {
        self::iniciar();
        return in_array((int)$id, $_SESSION['deseos'] ?? []);
    }

    public static function contar()
    {
        self::iniciar();
        return count($_SESSION['deseos'] ?? []);
    }

    public static function obtenerIds()
    {
        self::iniciar();
        return $_SESSION['deseos'] ?? [];
    }
}
?>

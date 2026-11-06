<?php
/**
 * Clase Usuarios
 * Gestiona el registro, autenticación (login) y sesiones con la misma lógica
 * enseñada en clase (password_hash, password_verify, variables de sesión: usuario, nombre, tipo)
 */
class Usuarios
{
    private static string $archivoUsuarios = __DIR__ . "/../conexion/usuarios.json";

    public static function iniciarSesionPHP(): void
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        // Si el archivo JSON no existe, creamos los usuarios de prueba iniciales
        if (!file_exists(self::$archivoUsuarios)) {
            $iniciales = [
                'nohelia' => [
                    'usuario' => 'nohelia',
                    'nombre' => 'Nohelia Barillas',
                    'password' => password_hash('123', PASSWORD_DEFAULT),
                    'tipo_usuario_id' => 1 // 1 = Cliente
                ],
                'admin' => [
                    'usuario' => 'admin',
                    'nombre' => 'Administrador Dulce Impresión',
                    'password' => password_hash('123', PASSWORD_DEFAULT),
                    'tipo_usuario_id' => 2 // 2 = Empleado
                ]
            ];
            @file_put_contents(self::$archivoUsuarios, json_encode($iniciales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     * Obtener listado de todos los usuarios registrados
     */
    private static function obtenerTodosLocales(): array
    {
        self::iniciarSesionPHP();
        if (file_exists(self::$archivoUsuarios)) {
            $contenido = @file_get_contents(self::$archivoUsuarios);
            $datos = json_decode($contenido, true);
            if (is_array($datos)) {
                return $datos;
            }
        }
        return [];
    }

    /**
     * Buscar usuario por su identificador (en MongoDB o archivo local)
     */
    public static function buscarUsuario(string $usuario, $conexionMongo = null): ?array
    {
        self::iniciarSesionPHP();
        $usuario = trim(strtolower($usuario));

        // 1. Buscar en MongoDB si hay conexión activa
        if ($conexionMongo instanceof MongoDB\Driver\Manager) {
            try {
                $filtro = ['usuario' => $usuario];
                $query = new MongoDB\Driver\Query($filtro);
                $cursor = $conexionMongo->executeQuery('fs2026_proyecto.usuarios', $query);
                foreach ($cursor as $doc) {
                    return (array)$doc;
                }
            } catch (Exception $e) {
                // Si falla consulta a Mongo, continuamos con archivo local
            }
        }

        // 2. Buscar en el archivo local persistente
        $locales = self::obtenerTodosLocales();
        if (isset($locales[$usuario])) {
            return $locales[$usuario];
        }

        return null;
    }

    /**
     * Registrar un nuevo usuario con contraseña encriptada (password_hash)
     */
    public static function agregarUsuario(string $usuario, string $nombre, string $contra, int $tipo = 1, $conexionMongo = null): bool
    {
        self::iniciarSesionPHP();
        $usuarioLimpio = trim(strtolower($usuario));

        // Encriptar la contraseña tal y como se enseña en clase
        $hashPassword = password_hash($contra, PASSWORD_DEFAULT);

        $nuevoUsuario = [
            'usuario' => $usuarioLimpio,
            'nombre' => trim($nombre),
            'password' => $hashPassword,
            'tipo_usuario_id' => (int)$tipo // 1 = Cliente, 2 = Empleado
        ];

        // 1. Guardar en MongoDB si está activo
        if ($conexionMongo instanceof MongoDB\Driver\Manager) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->insert($nuevoUsuario);
                $conexionMongo->executeBulkWrite('fs2026_proyecto.usuarios', $bulk);
            } catch (Exception $e) {
                // Continuar con guardado local
            }
        }

        // 2. Guardar en archivo local para que persista siempre
        $locales = self::obtenerTodosLocales();
        $locales[$usuarioLimpio] = $nuevoUsuario;
        @file_put_contents(self::$archivoUsuarios, json_encode($locales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return true;
    }

    /**
     * Iniciar sesión con verificación de contraseña (password_verify)
     */
    public static function autenticar(string $usuario, string $contra, $conexionMongo = null): ?array
    {
        self::iniciarSesionPHP();
        $datos = self::buscarUsuario($usuario, $conexionMongo);

        /* Verificar si existe el usuario y si la contraseña coincide con la almacenada */
        if ($datos && password_verify($contra, $datos['password'])) {
            /* Crear variables de sesión que persistan en las demás páginas (igual que en clase) */
            $_SESSION['usuario'] = $datos['usuario'];
            $_SESSION['nombre'] = $datos['nombre'];
            $_SESSION['tipo'] = (int)$datos['tipo_usuario_id'];
            return $datos;
        }

        return null;
    }

    /**
     * Cerrar sesión (destruir variables de sesión)
     */
    public static function cerrarSesion(): void
    {
        self::iniciarSesionPHP();
        unset($_SESSION['usuario'], $_SESSION['nombre'], $_SESSION['tipo']);
    }

    public static function estaAutenticado(): bool
    {
        self::iniciarSesionPHP();
        return isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
    }

    public static function esEmpleado(): bool
    {
        self::iniciarSesionPHP();
        return (int)($_SESSION['tipo'] ?? 0) === 2;
    }
}
?>

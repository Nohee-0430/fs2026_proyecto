<?php
class Usuarios
{
    private static $archivoUsuarios = __DIR__ . "/../conexion/usuarios.json";

    public static function iniciarSesionPHP()
    {
        if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
            @session_start();
        }

        if (!file_exists(self::$archivoUsuarios)) {
            $iniciales = [
                'nohelia' => [
                    'usuario' => 'nohelia',
                    'nombre' => 'Nohelia Barillas',
                    'password' => password_hash('123', PASSWORD_DEFAULT),
                    'tipo_usuario_id' => 1
                ],
                'admin' => [
                    'usuario' => 'admin',
                    'nombre' => 'Administrador Dulce Impresión',
                    'password' => password_hash('123', PASSWORD_DEFAULT),
                    'tipo_usuario_id' => 2
                ]
            ];
            @file_put_contents(self::$archivoUsuarios, json_encode($iniciales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }
    }

    private static function obtenerTodosLocales()
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

    public static function buscarUsuario($usuario, $conexionMySQL = null, $conexionMongo = null)
    {
        self::iniciarSesionPHP();
        $usuario = trim(strtolower($usuario));
        if ($usuario === '') {
            return null;
        }

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $stmtEmp = $conexionMySQL->prepare("SELECT empleado_id, nombre, correo, contrasenia, rol FROM empleados WHERE LOWER(correo) = ? OR LOWER(nombre) = ? LIMIT 1");
            if ($stmtEmp) {
                $stmtEmp->bind_param("ss", $usuario, $usuario);
                $stmtEmp->execute();
                $res = $stmtEmp->get_result();
                if ($res && $row = $res->fetch_assoc()) {
                    return [
                        'id' => (int)$row['empleado_id'],
                        'usuario' => $row['correo'],
                        'nombre' => $row['nombre'],
                        'password' => $row['contrasenia'],
                        'tipo_usuario_id' => 2,
                        'rol' => !empty($row['rol']) ? $row['rol'] : 'Empleado'
                    ];
                }
            }

            $stmtCli = $conexionMySQL->prepare("SELECT cliente_id, nombre, correo, contrasenia FROM clientes WHERE LOWER(correo) = ? OR LOWER(nombre) = ? LIMIT 1");
            if ($stmtCli) {
                $stmtCli->bind_param("ss", $usuario, $usuario);
                $stmtCli->execute();
                $res = $stmtCli->get_result();
                if ($res && $row = $res->fetch_assoc()) {
                    return [
                        'id' => (int)$row['cliente_id'],
                        'usuario' => $row['correo'],
                        'nombre' => $row['nombre'],
                        'password' => $row['contrasenia'],
                        'tipo_usuario_id' => 1,
                        'rol' => 'Cliente'
                    ];
                }
            }
        }

        if ($conexionMongo) {
            try {
                $filtro = ['$or' => [['usuario' => $usuario], ['correo' => $usuario]]];
                $query = new MongoDB\Driver\Query($filtro);
                $cursor = $conexionMongo->executeQuery('fs2026_proyecto.usuarios', $query);
                foreach ($cursor as $doc) {
                    $docArr = (array)$doc;
                    return [
                        'id' => $docArr['id'] ?? 1,
                        'usuario' => $docArr['usuario'] ?? $usuario,
                        'nombre' => $docArr['nombre'] ?? $usuario,
                        'password' => $docArr['password'] ?? '',
                        'tipo_usuario_id' => (int)($docArr['tipo_usuario_id'] ?? 1),
                        'rol' => ((int)($docArr['tipo_usuario_id'] ?? 1) === 2) ? 'Empleado' : 'Cliente'
                    ];
                }
            } catch (Exception $e) {
            }
        }

        $locales = self::obtenerTodosLocales();
        if (isset($locales[$usuario])) {
            $user = $locales[$usuario];
            $tipoId = (int)($user['tipo_usuario_id'] ?? 1);
            return [
                'id' => 1,
                'usuario' => $user['usuario'] ?? $usuario,
                'nombre' => $user['nombre'] ?? $usuario,
                'password' => $user['password'] ?? '',
                'tipo_usuario_id' => $tipoId,
                'rol' => ($tipoId === 2) ? 'Empleado' : 'Cliente'
            ];
        }

        return null;
    }

    public static function agregarUsuario($usuario, $nombre, $contra, $tipo = 1, $conexionMySQL = null, $conexionMongo = null)
    {
        self::iniciarSesionPHP();
        $usuarioLimpio = trim(strtolower($usuario));
        $nombreLimpio  = trim($nombre);
        $tipoUsuario   = ((int)$tipo === 2) ? 2 : 1;

        $hashPassword = password_hash($contra, PASSWORD_DEFAULT);
        $fechaActual  = date('Y-m-d');

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            if ($tipoUsuario === 2) {
                $stmt = $conexionMySQL->prepare("INSERT INTO empleados (nombre, correo, contrasenia, rol, fecha_registro) VALUES (?, ?, ?, 'Empleado', ?)");
                if ($stmt) {
                    $stmt->bind_param("ssss", $nombreLimpio, $usuarioLimpio, $hashPassword, $fechaActual);
                    $stmt->execute();
                }
            } else {
                $stmt = $conexionMySQL->prepare("INSERT INTO clientes (nombre, correo, contrasenia, fecha_registro) VALUES (?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("ssss", $nombreLimpio, $usuarioLimpio, $hashPassword, $fechaActual);
                    $stmt->execute();
                }
            }
        }

        if ($conexionMongo) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $nuevoDoc = [
                    'usuario' => $usuarioLimpio,
                    'nombre' => $nombreLimpio,
                    'password' => $hashPassword,
                    'tipo_usuario_id' => $tipoUsuario,
                    'fecha_registro' => $fechaActual
                ];
                $bulk->insert($nuevoDoc);
                $conexionMongo->executeBulkWrite('fs2026_proyecto.usuarios', $bulk);
            } catch (Exception $e) {
            }
        }

        $locales = self::obtenerTodosLocales();
        $locales[$usuarioLimpio] = [
            'usuario' => $usuarioLimpio,
            'nombre' => $nombreLimpio,
            'password' => $hashPassword,
            'tipo_usuario_id' => $tipoUsuario
        ];
        @file_put_contents(self::$archivoUsuarios, json_encode($locales, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return true;
    }

    public static function autenticar($usuario, $contra, $conexionMySQL = null, $conexionMongo = null)
    {
        self::iniciarSesionPHP();
        $datos = self::buscarUsuario($usuario, $conexionMySQL, $conexionMongo);

        if ($datos && password_verify($contra, $datos['password'])) {
            $_SESSION['usuario'] = $datos['usuario'];
            $_SESSION['nombre']  = $datos['nombre'];
            $_SESSION['tipo']    = (int)$datos['tipo_usuario_id'];
            $_SESSION['rol']     = $datos['rol'] ?? (((int)$datos['tipo_usuario_id'] === 2) ? 'Empleado' : 'Cliente');
            $_SESSION['usuario_id'] = $datos['id'] ?? 1;
            return $datos;
        }

        return null;
    }

    public static function obtenerUsuarios($conexionMySQL = null)
    {
        $resultado = [
            'empleados' => [],
            'clientes' => []
        ];

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $qEmp = $conexionMySQL->query("SELECT empleado_id, nombre, correo, rol, fecha_registro FROM empleados ORDER BY empleado_id ASC");
            if ($qEmp) {
                while ($row = $qEmp->fetch_assoc()) {
                    $resultado['empleados'][] = $row;
                }
            }

            $qCli = $conexionMySQL->query("SELECT cliente_id, nombre, correo, fecha_registro FROM clientes ORDER BY cliente_id ASC");
            if ($qCli) {
                while ($row = $qCli->fetch_assoc()) {
                    $resultado['clientes'][] = $row;
                }
            }
        } else {
            $locales = self::obtenerTodosLocales();
            foreach ($locales as $u) {
                if ((int)($u['tipo_usuario_id'] ?? 1) === 2) {
                    $resultado['empleados'][] = [
                        'empleado_id' => 1,
                        'nombre' => $u['nombre'],
                        'correo' => $u['usuario'],
                        'rol' => 'Empleado/Admin',
                        'fecha_registro' => date('Y-m-d')
                    ];
                } else {
                    $resultado['clientes'][] = [
                        'cliente_id' => 1,
                        'nombre' => $u['nombre'],
                        'correo' => $u['usuario'],
                        'fecha_registro' => date('Y-m-d')
                    ];
                }
            }
        }

        return $resultado;
    }

    public static function cerrarSesion()
    {
        self::iniciarSesionPHP();
        unset(
            $_SESSION['usuario'],
            $_SESSION['nombre'],
            $_SESSION['tipo'],
            $_SESSION['rol'],
            $_SESSION['usuario_id']
        );
        @session_destroy();
    }

    public static function estaAutenticado()
    {
        self::iniciarSesionPHP();
        return isset($_SESSION['usuario']) && !empty($_SESSION['usuario']);
    }

    public static function esEmpleado()
    {
        self::iniciarSesionPHP();
        return (int)($_SESSION['tipo'] ?? 0) === 2;
    }
}
?>

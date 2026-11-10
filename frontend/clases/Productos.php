<?php
class Productos
{
    public static function catalogoPorDefecto()
    {
        return [
            [
                'id' => 1,
                'categoria_id' => 1,
                'nombre' => 'Hojas Papel de Azúcar A4',
                'categoria' => 'Hojas Comestibles',
                'descripcion' => 'Pack x 24 hojas flexibles con acabado de gran nitidez para repostería',
                'precio' => 210.00,
                'stock' => 35,
                'disponibilidad' => 'En Stock',
                'disponibilidad_num' => 1,
                'tag' => 'Más Vendido',
                'tag_class' => 'badge-tag-mas-vendido',
                'icono' => 'bi-file-earmark-richtext',
                'imagen' => 'bi-file-earmark-richtext'
            ],
            [
                'id' => 2,
                'categoria_id' => 2,
                'nombre' => 'Kit Tintas Comestibles CMYK',
                'categoria' => 'Tintas Comestibles',
                'descripcion' => '4 botellas 100ml c/u (Cian, Magenta, Amarillo, Negro) grado alimenticio',
                'precio' => 350.00,
                'stock' => 18,
                'disponibilidad' => 'En Stock',
                'disponibilidad_num' => 1,
                'tag' => 'Oferta',
                'tag_class' => 'badge-tag-oferta',
                'icono' => 'bi-droplet-half',
                'imagen' => 'bi-droplet-half'
            ],
            [
                'id' => 3,
                'categoria_id' => 3,
                'nombre' => 'Impresión Foto Pastel A4',
                'categoria' => 'Impresiones Personalizadas',
                'descripcion' => 'Servicio personalizado con foto en hoja de azúcar de alta resolución',
                'precio' => 45.00,
                'stock' => 99,
                'disponibilidad' => 'Entrega Inmediata',
                'disponibilidad_num' => 1,
                'tag' => 'Servicio',
                'tag_class' => 'badge-tag-servicio',
                'icono' => 'bi-camera',
                'imagen' => 'bi-camera'
            ],
            [
                'id' => 4,
                'categoria_id' => 1,
                'nombre' => 'Hojas Papel de Arroz A4',
                'categoria' => 'Hojas Comestibles',
                'descripcion' => 'Pack x 24 obleas comestibles para galletas, merengues y turrón',
                'precio' => 125.00,
                'stock' => 24,
                'disponibilidad' => 'En Stock',
                'disponibilidad_num' => 1,
                'tag' => 'Insumo Base',
                'tag_class' => 'badge-tag-insumo-base',
                'icono' => 'bi-file-earmark',
                'imagen' => 'bi-file-earmark'
            ],
            [
                'id' => 5,
                'categoria_id' => 3,
                'nombre' => 'Discos Cupcake (x12 5cm)',
                'categoria' => 'Impresiones Personalizadas',
                'descripcion' => '12 toppers redondos precortados impresos en azúcar para cupcakes',
                'precio' => 35.00,
                'stock' => 50,
                'disponibilidad' => 'Entrega Inmediata',
                'disponibilidad_num' => 1,
                'tag' => 'Popular',
                'tag_class' => 'badge-tag-popular',
                'icono' => 'bi-circle',
                'imagen' => 'bi-circle'
            ],
            [
                'id' => 6,
                'categoria_id' => 2,
                'nombre' => 'Tinta Comestible Negra 100ml',
                'categoria' => 'Tintas Comestibles',
                'descripcion' => 'Alta densidad para bordes definidos y textos nítidos en pasteles',
                'precio' => 95.00,
                'stock' => 40,
                'disponibilidad' => 'En Stock',
                'disponibilidad_num' => 1,
                'tag' => 'Stock Alto',
                'tag_class' => 'badge-tag-stock-alto',
                'icono' => 'bi-paint-bucket',
                'imagen' => 'bi-paint-bucket'
            ],
            [
                'id' => 7,
                'categoria_id' => 4,
                'nombre' => 'Impresora Canon Adaptada',
                'categoria' => 'Impresoras Adaptadas',
                'descripcion' => 'Equipada y lista para uso exclusivo con tintas comestibles alimentarias',
                'precio' => 1850.00,
                'stock' => 5,
                'disponibilidad' => 'En Stock',
                'disponibilidad_num' => 1,
                'tag' => 'Equipo',
                'tag_class' => 'badge-tag-equipo',
                'icono' => 'bi-printer',
                'imagen' => 'bi-printer'
            ],
            [
                'id' => 8,
                'categoria_id' => 5,
                'nombre' => 'Limpiador Cabezales 100ml',
                'categoria' => 'Soluciones de Limpieza',
                'descripcion' => 'Líquido grado alimentario para mantenimiento y destape de inyectores',
                'precio' => 65.00,
                'stock' => 15,
                'disponibilidad' => 'En Stock',
                'disponibilidad_num' => 1,
                'tag' => 'Mantenimiento',
                'tag_class' => 'badge-tag-mantenimiento',
                'icono' => 'bi-wrench-adjustable',
                'imagen' => 'bi-wrench-adjustable'
            ]
        ];
    }

    public static function obtenerCategorias($conexionMySQL = null)
    {
        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $res = $conexionMySQL->query("SELECT categoria_id, nombre, descripcion FROM categorias ORDER BY categoria_id ASC");
            if ($res && $res->num_rows > 0) {
                $cats = [];
                while ($row = $res->fetch_assoc()) {
                    $cats[] = [
                        'id' => (int)$row['categoria_id'],
                        'nombre' => $row['nombre'],
                        'descripcion' => $row['descripcion']
                    ];
                }
                return $cats;
            }
        }

        return [
            ['id' => 1, 'nombre' => 'Hojas Comestibles', 'descripcion' => 'Papel de azúcar y arroz'],
            ['id' => 2, 'nombre' => 'Tintas Comestibles', 'descripcion' => 'Tintas CMYK alimentarias'],
            ['id' => 3, 'nombre' => 'Impresiones Personalizadas', 'descripcion' => 'Servicios personalizados'],
            ['id' => 4, 'nombre' => 'Impresoras Adaptadas', 'descripcion' => 'Equipos para impresión alimentaria'],
            ['id' => 5, 'nombre' => 'Soluciones de Limpieza', 'descripcion' => 'Mantenimiento de cabezales']
        ];
    }

    public static function obtenerProductos($conexionMySQL = null, $conexionMongo = null)
    {
        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $sql = "SELECT p.productos_id, p.categoria_id, p.nombre, p.descripcion, p.imagen, p.precio, p.stock, p.disponibilidad, 
                           COALESCE(c.nombre, 'General') AS categoria_nombre 
                    FROM productos p 
                    LEFT JOIN categorias c ON p.categoria_id = c.categoria_id 
                    ORDER BY p.productos_id ASC";
            $res = $conexionMySQL->query($sql);
            if ($res && $res->num_rows > 0) {
                $lista = [];
                while ($row = $res->fetch_assoc()) {
                    $stock = (int)$row['stock'];
                    $dispNum = (int)$row['disponibilidad'];
                    $img = !empty($row['imagen']) ? $row['imagen'] : 'bi-box-seam';

                    $tag = 'Disponible';
                    $tagClass = 'badge-tag-popular';
                    if ($stock > 30) {
                        $tag = 'Más Vendido';
                        $tagClass = 'badge-tag-mas-vendido';
                    } elseif ($stock <= 0 || $dispNum === 0) {
                        $tag = 'Agotado';
                        $tagClass = 'badge-tag-oferta';
                    }

                    $lista[] = [
                        'id' => (int)$row['productos_id'],
                        'categoria_id' => (int)$row['categoria_id'],
                        'nombre' => $row['nombre'],
                        'categoria' => $row['categoria_nombre'],
                        'descripcion' => $row['descripcion'],
                        'precio' => (float)$row['precio'],
                        'stock' => $stock,
                        'disponibilidad' => ($dispNum === 1 && $stock > 0) ? 'En Stock' : 'Agotado',
                        'disponibilidad_num' => $dispNum,
                        'imagen' => $img,
                        'icono' => (substr($img, 0, 3) === 'bi-') ? $img : 'bi-box-seam',
                        'tag' => $tag,
                        'tag_class' => $tagClass
                    ];
                }
                return $lista;
            }
        }

        if ($conexionMongo) {
            try {
                $query = new MongoDB\Driver\Query([], ['sort' => ['id' => 1]]);
                $cursor = $conexionMongo->executeQuery('fs2026_proyecto.productos', $query);
                $lista = [];
                foreach ($cursor as $doc) {
                    $docArr = (array)$doc;
                    $docArr['id'] = (int)($docArr['id'] ?? $docArr['productos_id'] ?? 1);
                    $lista[] = $docArr;
                }
                if (!empty($lista)) {
                    return $lista;
                }
            } catch (Exception $e) {
            }
        }

        return self::catalogoPorDefecto();
    }

    public static function obtenerPorId($id, $conexionMySQL = null, $conexionMongo = null)
    {
        $id = (int)$id;
        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $stmt = $conexionMySQL->prepare("SELECT p.productos_id, p.categoria_id, p.nombre, p.descripcion, p.imagen, p.precio, p.stock, p.disponibilidad, 
                                                    COALESCE(c.nombre, 'General') AS categoria_nombre 
                                             FROM productos p 
                                             LEFT JOIN categorias c ON p.categoria_id = c.categoria_id 
                                             WHERE p.productos_id = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($res && $row = $res->fetch_assoc()) {
                    $img = !empty($row['imagen']) ? $row['imagen'] : 'bi-box-seam';
                    return [
                        'id' => (int)$row['productos_id'],
                        'categoria_id' => (int)$row['categoria_id'],
                        'nombre' => $row['nombre'],
                        'categoria' => $row['categoria_nombre'],
                        'descripcion' => $row['descripcion'],
                        'precio' => (float)$row['precio'],
                        'stock' => (int)$row['stock'],
                        'disponibilidad_num' => (int)$row['disponibilidad'],
                        'disponibilidad' => ((int)$row['disponibilidad'] === 1) ? 'En Stock' : 'Agotado',
                        'imagen' => $img,
                        'icono' => (substr($img, 0, 3) === 'bi-') ? $img : 'bi-box-seam'
                    ];
                }
            }
        }

        $todos = self::obtenerProductos($conexionMySQL, $conexionMongo);
        foreach ($todos as $p) {
            if ((int)$p['id'] === $id) {
                return $p;
            }
        }
        return null;
    }

    public static function guardarProducto($datos, $conexionMySQL = null, $conexionMongo = null)
    {
        $id             = isset($datos['id']) ? (int)$datos['id'] : 0;
        $categoriaId    = isset($datos['categoria_id']) ? (int)$datos['categoria_id'] : 1;
        $nombre         = trim($datos['nombre'] ?? '');
        $descripcion    = trim($datos['descripcion'] ?? '');
        $precio         = (float)($datos['precio'] ?? 0.0);
        $stock          = (int)($datos['stock'] ?? 0);
        $disponibilidad = isset($datos['disponibilidad']) ? (int)$datos['disponibilidad'] : 1;
        $imagen         = trim($datos['imagen'] ?? 'bi-box-seam');
        if (empty($imagen)) {
            $imagen = 'bi-box-seam';
        }

        if (empty($nombre)) {
            return false;
        }

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            if ($id > 0) {
                $stmt = $conexionMySQL->prepare("UPDATE productos SET categoria_id=?, nombre=?, descripcion=?, imagen=?, precio=?, stock=?, disponibilidad=? WHERE productos_id=?");
                if ($stmt) {
                    $stmt->bind_param("isssdiis", $categoriaId, $nombre, $descripcion, $imagen, $precio, $stock, $disponibilidad, $id);
                    $stmt->execute();
                }
            } else {
                $stmt = $conexionMySQL->prepare("INSERT INTO productos (categoria_id, nombre, descripcion, imagen, precio, stock, disponibilidad) VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("isssdii", $categoriaId, $nombre, $descripcion, $imagen, $precio, $stock, $disponibilidad);
                    $stmt->execute();
                    $id = $conexionMySQL->insert_id;
                }
            }
        }

        if ($conexionMongo) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $doc = [
                    'id' => $id,
                    'categoria_id' => $categoriaId,
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'precio' => $precio,
                    'stock' => $stock,
                    'disponibilidad' => ($disponibilidad === 1) ? 'En Stock' : 'Agotado',
                    'imagen' => $imagen,
                    'icono' => $imagen
                ];
                if ($id > 0) {
                    $bulk->update(['id' => $id], ['$set' => $doc], ['upsert' => true]);
                } else {
                    $bulk->insert($doc);
                }
                $conexionMongo->executeBulkWrite('fs2026_proyecto.productos', $bulk);
            } catch (Exception $e) {
            }
        }

        return true;
    }

    public static function eliminarProducto($id, $conexionMySQL = null, $conexionMongo = null)
    {
        $id = (int)$id;
        if ($id <= 0) {
            return false;
        }

        if ($conexionMySQL && !$conexionMySQL->connect_error) {
            $stmt = $conexionMySQL->prepare("DELETE FROM productos WHERE productos_id = ?");
            if ($stmt) {
                $stmt->bind_param("i", $id);
                $stmt->execute();
            }
        }

        if ($conexionMongo) {
            try {
                $bulk = new MongoDB\Driver\BulkWrite();
                $bulk->delete(['id' => $id]);
                $conexionMongo->executeBulkWrite('fs2026_proyecto.productos', $bulk);
            } catch (Exception $e) {
            }
        }

        return true;
    }
}
?>

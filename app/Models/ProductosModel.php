<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductosModel extends Model 
{
    protected $table = 'productos';
    protected $primaryKey = 'productos_id';
    protected $allowedFields = ['productos_id', 'categoria_id', 'nombre', 'descripcion', 'imagen', 'precio', 'stock', 'disponibilidad'];
}

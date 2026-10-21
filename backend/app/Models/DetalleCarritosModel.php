<?php
namespace App\Models;
use CodeIgniter\Model;

class DetalleCarritosModel extends Model 
{
    protected $table = 'detalle_carritos';
    protected $primaryKey = 'detalle_carrito_id';
    protected $allowedFields = ['detalle_carrito_id', 'carrito_id', 'producto_id', 'cantidad', 'precio_unitario'];
}

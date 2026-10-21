<?php
namespace App\Models;
use CodeIgniter\Model;

class DetallePedidosModel extends Model 
{
    protected $table = 'detalle_pedidos';
    protected $primaryKey = 'detalle_pedido_id';
    protected $allowedFields = ['detalle_pedido_id', 'carrito_id', 'producto_id', 'cantidad', 'precio_unitario', 'subtotal'];
}

<?php
namespace App\Models;
use CodeIgniter\Model;

class PedidosModel extends Model 
{
    protected $table = 'pedidos';
    protected $primaryKey = 'carrito_id';
    protected $allowedFields = ['carrito_id', 'cliente_id', 'empleado_id', 'fecha_pedido', 'total', 'estado', 'metodo_pago', 'tipo_entrega', 'nit'];
}

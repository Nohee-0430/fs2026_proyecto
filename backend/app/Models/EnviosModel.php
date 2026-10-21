<?php
namespace App\Models;
use CodeIgniter\Model;

class EnviosModel extends Model 
{
    protected $table = 'envios';
    protected $primaryKey = 'pedido_id';
    protected $allowedFields = ['pedido_id', 'direccion', 'municipio', 'departamento', 'estado_envio', 'fecha_envio', 'fecha_entrega', 'referencia_ubicacion', 'observaciones'];
}

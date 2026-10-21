<?php
namespace App\Models;
use CodeIgniter\Model;

class CarritosModel extends Model 
{
    protected $table = 'carritos';
    protected $primaryKey = 'carrito_id';
    protected $allowedFields = ['carrito_id', 'cliente_id', 'fecha_creacion', 'estado'];
}

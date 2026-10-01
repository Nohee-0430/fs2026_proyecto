<?php
namespace App\Models;
use CodeIgniter\Model;

class ReseniasModel extends Model 
{
    protected $table = 'resenias';
    protected $primaryKey = 'resenia_id';
    protected $allowedFields = ['resenia_id', 'cliente_id', 'detalle_pedido_id', 'calificacion', 'comentario', 'estado', 'fecha_publicacion'];
}

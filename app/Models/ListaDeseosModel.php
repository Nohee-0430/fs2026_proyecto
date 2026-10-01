<?php
namespace App\Models;
use CodeIgniter\Model;

class ListaDeseosModel extends Model 
{
    protected $table = 'lista_deseos';
    protected $primaryKey = 'lista_deseo_id';
    protected $allowedFields = ['lista_deseo_id', 'cliente_id', 'producto_id', 'fecha_agregado'];
}

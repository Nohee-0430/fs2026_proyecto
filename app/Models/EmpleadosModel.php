<?php
namespace App\Models;
use CodeIgniter\Model;

class EmpleadosModel extends Model 
{
    protected $table = 'empleados';
    protected $primaryKey = 'empleado_id';
    protected $allowedFields = ['empleado_id', 'nombre', 'correo', 'contrasenia', 'rol', 'fecha_registro'];
}
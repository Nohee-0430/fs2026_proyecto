<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\EmpleadosModel;

class EmpleadosController extends BaseController
{
    public function index()
    {
        $empleado = new EmpleadosModel();
        $datos["datos"] = $empleado->findAll();
        return view("empleados", $datos);
    }

    public function buscarId($id)
    {
        $empleado = new EmpleadosModel();
        $datos["datos"] = $empleado->where('empleado_id', $id)->first();
        return view("empleados_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_empleado_id');
        
        $datos = [
            'nombre'         => $this->request->getVar('txt_nombre'),
            'correo'         => $this->request->getVar('txt_correo'),
            'contrasenia'    => $this->request->getVar('txt_contrasenia'),
            'rol'            => $this->request->getVar('txt_rol'),
            'fecha_registro' => $this->request->getVar('txt_fecha_registro')
        ];

        $empleado = new EmpleadosModel();
        $empleado->update($id, $datos);
        
        return redirect()->to(base_url('empleados'));
    }

    public function insertar()
    {
        $datos = [
            'nombre'         => $this->request->getVar('txt_nombre'),
            'correo'         => $this->request->getVar('txt_correo'),
            'contrasenia'    => $this->request->getVar('txt_contrasenia'),
            'rol'            => $this->request->getVar('txt_rol'),
            'fecha_registro' => $this->request->getVar('txt_fecha_registro')
        ];

        $empleado = new EmpleadosModel();
        $empleado->insert($datos);
        
        return redirect()->to(base_url('empleados'));
    }

    public function eliminar($id)
    {
        $empleado = new EmpleadosModel();
        $empleado->delete($id);

        return redirect()->to(base_url('empleados'));
    }
}

<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\EnviosModel;

class EnviosController extends BaseController
{
    public function index()
    {
        $modelo = new EnviosModel();
        $datos["datos"] = $modelo->findAll();
        return view("envios", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new EnviosModel();
        $datos["datos"] = $modelo->where('pedido_id', $id)->first();
        return view("envios_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_pedido_id');
        $datos = [
            'direccion' => $this->request->getVar('txt_direccion'),
            'municipio' => $this->request->getVar('txt_municipio'),
            'departamento' => $this->request->getVar('txt_departamento'),
            'estado_envio' => $this->request->getVar('txt_estado_envio'),
            'fecha_envio' => $this->request->getVar('txt_fecha_envio'),
            'fecha_entrega' => $this->request->getVar('txt_fecha_entrega'),
            'referencia_ubicacion' => $this->request->getVar('txt_referencia_ubicacion'),
            'observaciones' => $this->request->getVar('txt_observaciones')
        ];
        $modelo = new EnviosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('envios'));
    }

    public function insertar()
    {
        $datos = [
            'direccion' => $this->request->getVar('txt_direccion'),
            'municipio' => $this->request->getVar('txt_municipio'),
            'departamento' => $this->request->getVar('txt_departamento'),
            'estado_envio' => $this->request->getVar('txt_estado_envio'),
            'fecha_envio' => $this->request->getVar('txt_fecha_envio'),
            'fecha_entrega' => $this->request->getVar('txt_fecha_entrega'),
            'referencia_ubicacion' => $this->request->getVar('txt_referencia_ubicacion'),
            'observaciones' => $this->request->getVar('txt_observaciones')
        ];
        $modelo = new EnviosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('envios'));
    }

    public function eliminar($id)
    {
        $modelo = new EnviosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('envios'));
    }
}

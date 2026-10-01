<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CarritosModel;

class CarritosController extends BaseController
{
    public function index()
    {
        $modelo = new CarritosModel();
        $datos["datos"] = $modelo->findAll();
        return view("carritos", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new CarritosModel();
        $datos["datos"] = $modelo->where('carrito_id', $id)->first();
        return view("carritos_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_carrito_id');
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'fecha_creacion' => $this->request->getVar('txt_fecha_creacion'),
            'estado' => $this->request->getVar('txt_estado')
        ];
        $modelo = new CarritosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('carritos'));
    }

    public function insertar()
    {
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'fecha_creacion' => $this->request->getVar('txt_fecha_creacion'),
            'estado' => $this->request->getVar('txt_estado')
        ];
        $modelo = new CarritosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('carritos'));
    }

    public function eliminar($id)
    {
        $modelo = new CarritosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('carritos'));
    }
}

<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ClientesModel;

class ClientesController extends BaseController
{
    public function index()
    {
        $modelo = new ClientesModel();
        $datos["datos"] = $modelo->findAll();
        return view("clientes", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new ClientesModel();
        $datos["datos"] = $modelo->where('cliente_id', $id)->first();
        return view("clientes_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_cliente_id');
        $datos = [
            'nombre' => $this->request->getVar('txt_nombre'),
            'correo' => $this->request->getVar('txt_correo'),
            'contrasenia' => $this->request->getVar('txt_contrasenia'),
            'fecha_registro' => $this->request->getVar('txt_fecha_registro')
        ];
        $modelo = new ClientesModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('clientes'));
    }

    public function insertar()
    {
        $datos = [
            'nombre' => $this->request->getVar('txt_nombre'),
            'correo' => $this->request->getVar('txt_correo'),
            'contrasenia' => $this->request->getVar('txt_contrasenia'),
            'fecha_registro' => $this->request->getVar('txt_fecha_registro')
        ];
        $modelo = new ClientesModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('clientes'));
    }

    public function eliminar($id)
    {
        $modelo = new ClientesModel();
        $modelo->delete($id);
        return redirect()->to(base_url('clientes'));
    }
}

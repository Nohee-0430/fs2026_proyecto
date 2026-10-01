<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ListaDeseosModel;

class ListaDeseosController extends BaseController
{
    public function index()
    {
        $modelo = new ListaDeseosModel();
        $datos["datos"] = $modelo->findAll();
        return view("lista_deseos", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new ListaDeseosModel();
        $datos["datos"] = $modelo->where('lista_deseo_id', $id)->first();
        return view("lista_deseos_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_lista_deseo_id');
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'producto_id' => $this->request->getVar('txt_producto_id'),
            'fecha_agregado' => $this->request->getVar('txt_fecha_agregado')
        ];
        $modelo = new ListaDeseosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('lista_deseos'));
    }

    public function insertar()
    {
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'producto_id' => $this->request->getVar('txt_producto_id'),
            'fecha_agregado' => $this->request->getVar('txt_fecha_agregado')
        ];
        $modelo = new ListaDeseosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('lista_deseos'));
    }

    public function eliminar($id)
    {
        $modelo = new ListaDeseosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('lista_deseos'));
    }
}

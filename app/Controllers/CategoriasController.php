<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CategoriasModel;

class CategoriasController extends BaseController
{
    public function index()
    {
        $modelo = new CategoriasModel();
        $datos["datos"] = $modelo->findAll();
        return view("categorias", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new CategoriasModel();
        $datos["datos"] = $modelo->where('categoria_id', $id)->first();
        return view("categorias_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_categoria_id');
        $datos = [
            'nombre' => $this->request->getVar('txt_nombre'),
            'descripcion' => $this->request->getVar('txt_descripcion')
        ];
        $modelo = new CategoriasModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('categorias'));
    }

    public function insertar()
    {
        $datos = [
            'nombre' => $this->request->getVar('txt_nombre'),
            'descripcion' => $this->request->getVar('txt_descripcion')
        ];
        $modelo = new CategoriasModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('categorias'));
    }

    public function eliminar($id)
    {
        $modelo = new CategoriasModel();
        $modelo->delete($id);
        return redirect()->to(base_url('categorias'));
    }
}

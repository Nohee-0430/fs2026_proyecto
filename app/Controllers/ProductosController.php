<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ProductosModel;

class ProductosController extends BaseController
{
    public function index()
    {
        $modelo = new ProductosModel();
        $datos["datos"] = $modelo->findAll();
        return view("productos", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new ProductosModel();
        $datos["datos"] = $modelo->where('productos_id', $id)->first();
        return view("productos_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_productos_id');
        $datos = [
            'categoria_id' => $this->request->getVar('txt_categoria_id'),
            'nombre' => $this->request->getVar('txt_nombre'),
            'descripcion' => $this->request->getVar('txt_descripcion'),
            'imagen' => $this->request->getVar('txt_imagen'),
            'precio' => $this->request->getVar('txt_precio'),
            'stock' => $this->request->getVar('txt_stock'),
            'disponibilidad' => $this->request->getVar('txt_disponibilidad')
        ];
        $modelo = new ProductosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('productos'));
    }

    public function insertar()
    {
        $datos = [
            'categoria_id' => $this->request->getVar('txt_categoria_id'),
            'nombre' => $this->request->getVar('txt_nombre'),
            'descripcion' => $this->request->getVar('txt_descripcion'),
            'imagen' => $this->request->getVar('txt_imagen'),
            'precio' => $this->request->getVar('txt_precio'),
            'stock' => $this->request->getVar('txt_stock'),
            'disponibilidad' => $this->request->getVar('txt_disponibilidad')
        ];
        $modelo = new ProductosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('productos'));
    }

    public function eliminar($id)
    {
        $modelo = new ProductosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('productos'));
    }
}

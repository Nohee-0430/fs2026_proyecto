<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\DetalleCarritosModel;

class DetalleCarritosController extends BaseController
{
    public function index()
    {
        $modelo = new DetalleCarritosModel();
        $datos["datos"] = $modelo->findAll();
        return view("detalle_carritos", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new DetalleCarritosModel();
        $datos["datos"] = $modelo->where('detalle_carrito_id', $id)->first();
        return view("detalle_carritos_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_detalle_carrito_id');
        $datos = [
            'carrito_id' => $this->request->getVar('txt_carrito_id'),
            'producto_id' => $this->request->getVar('txt_producto_id'),
            'cantidad' => $this->request->getVar('txt_cantidad'),
            'precio_unitario' => $this->request->getVar('txt_precio_unitario')
        ];
        $modelo = new DetalleCarritosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('detalle_carritos'));
    }

    public function insertar()
    {
        $datos = [
            'carrito_id' => $this->request->getVar('txt_carrito_id'),
            'producto_id' => $this->request->getVar('txt_producto_id'),
            'cantidad' => $this->request->getVar('txt_cantidad'),
            'precio_unitario' => $this->request->getVar('txt_precio_unitario')
        ];
        $modelo = new DetalleCarritosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('detalle_carritos'));
    }

    public function eliminar($id)
    {
        $modelo = new DetalleCarritosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('detalle_carritos'));
    }
}

<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\DetallePedidosModel;

class DetallePedidosController extends BaseController
{
    public function index()
    {
        $modelo = new DetallePedidosModel();
        $datos["datos"] = $modelo->findAll();
        return view("detalle_pedidos", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new DetallePedidosModel();
        $datos["datos"] = $modelo->where('detalle_pedido_id', $id)->first();
        return view("detalle_pedidos_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_detalle_pedido_id');
        $datos = [
            'carrito_id' => $this->request->getVar('txt_carrito_id'),
            'producto_id' => $this->request->getVar('txt_producto_id'),
            'cantidad' => $this->request->getVar('txt_cantidad'),
            'precio_unitario' => $this->request->getVar('txt_precio_unitario'),
            'subtotal' => $this->request->getVar('txt_subtotal')
        ];
        $modelo = new DetallePedidosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('detalle_pedidos'));
    }

    public function insertar()
    {
        $datos = [
            'carrito_id' => $this->request->getVar('txt_carrito_id'),
            'producto_id' => $this->request->getVar('txt_producto_id'),
            'cantidad' => $this->request->getVar('txt_cantidad'),
            'precio_unitario' => $this->request->getVar('txt_precio_unitario'),
            'subtotal' => $this->request->getVar('txt_subtotal')
        ];
        $modelo = new DetallePedidosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('detalle_pedidos'));
    }

    public function eliminar($id)
    {
        $modelo = new DetallePedidosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('detalle_pedidos'));
    }
}

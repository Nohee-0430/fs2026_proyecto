<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\PedidosModel;

class PedidosController extends BaseController
{
    public function index()
    {
        $modelo = new PedidosModel();
        $datos["datos"] = $modelo->findAll();
        return view("pedidos", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new PedidosModel();
        $datos["datos"] = $modelo->where('carrito_id', $id)->first();
        return view("pedidos_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_carrito_id');
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'empleado_id' => $this->request->getVar('txt_empleado_id'),
            'fecha_pedido' => $this->request->getVar('txt_fecha_pedido'),
            'total' => $this->request->getVar('txt_total'),
            'estado' => $this->request->getVar('txt_estado'),
            'metodo_pago' => $this->request->getVar('txt_metodo_pago'),
            'tipo_entrega' => $this->request->getVar('txt_tipo_entrega'),
            'nit' => $this->request->getVar('txt_nit')
        ];
        $modelo = new PedidosModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('pedidos'));
    }

    public function insertar()
    {
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'empleado_id' => $this->request->getVar('txt_empleado_id'),
            'fecha_pedido' => $this->request->getVar('txt_fecha_pedido'),
            'total' => $this->request->getVar('txt_total'),
            'estado' => $this->request->getVar('txt_estado'),
            'metodo_pago' => $this->request->getVar('txt_metodo_pago'),
            'tipo_entrega' => $this->request->getVar('txt_tipo_entrega'),
            'nit' => $this->request->getVar('txt_nit')
        ];
        $modelo = new PedidosModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('pedidos'));
    }

    public function eliminar($id)
    {
        $modelo = new PedidosModel();
        $modelo->delete($id);
        return redirect()->to(base_url('pedidos'));
    }
}

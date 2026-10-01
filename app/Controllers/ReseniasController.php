<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ReseniasModel;

class ReseniasController extends BaseController
{
    public function index()
    {
        $modelo = new ReseniasModel();
        $datos["datos"] = $modelo->findAll();
        return view("resenias", $datos);
    }

    public function buscarId($id)
    {
        $modelo = new ReseniasModel();
        $datos["datos"] = $modelo->where('resenia_id', $id)->first();
        return view("resenias_editar", $datos);
    }

    public function actualizar()
    {
        $id = $this->request->getVar('txt_resenia_id');
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'detalle_pedido_id' => $this->request->getVar('txt_detalle_pedido_id'),
            'calificacion' => $this->request->getVar('txt_calificacion'),
            'comentario' => $this->request->getVar('txt_comentario'),
            'estado' => $this->request->getVar('txt_estado'),
            'fecha_publicacion' => $this->request->getVar('txt_fecha_publicacion')
        ];
        $modelo = new ReseniasModel();
        $modelo->update($id, $datos);
        return redirect()->to(base_url('resenias'));
    }

    public function insertar()
    {
        $datos = [
            'cliente_id' => $this->request->getVar('txt_cliente_id'),
            'detalle_pedido_id' => $this->request->getVar('txt_detalle_pedido_id'),
            'calificacion' => $this->request->getVar('txt_calificacion'),
            'comentario' => $this->request->getVar('txt_comentario'),
            'estado' => $this->request->getVar('txt_estado'),
            'fecha_publicacion' => $this->request->getVar('txt_fecha_publicacion')
        ];
        $modelo = new ReseniasModel();
        $modelo->insert($datos);
        return redirect()->to(base_url('resenias'));
    }

    public function eliminar($id)
    {
        $modelo = new ReseniasModel();
        $modelo->delete($id);
        return redirect()->to(base_url('resenias'));
    }
}

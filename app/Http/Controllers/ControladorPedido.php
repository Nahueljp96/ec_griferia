<?php

namespace App\Http\Controllers;


use App\Entidades\Pedido; 
use App\Entidades\Sucursal; 
use App\Entidades\Cliente; 
use App\Entidades\Estado; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo pedido";
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $cliente = new Cliente();
        $aClientes = $cliente->obtenerTodos();

        $estado = new Estado();
        $aEstados = $estado->obtenerTodos();
      

        return view( 'pedido.pedido-nuevo', compact ('titulo', 'aSucursales', 'aClientes', 'aEstados'));
    }

    public function index()
    {
        $titulo = "Listado de Pedidos";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("MENUCONSULTA")) { //otra validación
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('pedido.pedido-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Pedido();
        $aPedidos = $entidad->obtenerFiltrado();
        
        $data = array(); #variables de configuración 
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPedidos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/pedido/" .$aPedidos[$i]->idpedido. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aPedidos[$i]->fecha;
            $row[] = $aPedidos[$i]->descripcion;
            $row[] = number_format ($aPedidos[$i]->total, 2, ",", "."); 
            $row[] = $aPedidos[$i]->fk_idsucursal;
            $row[] = $aPedidos[$i]->cliente. "<a href='/admin/cliente/" . '  '. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aPedidos[$i]->estado;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPedidos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPedidos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request) {
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Pedido";
            $entidad = new Pedido ();
            $entidad->cargarDesdeRequest($request);

           //print_r($_REQUEST);
           //exit;
            //validaciones
            if ($entidad->fk_idcliente == "" || $entidad->fecha == "" || $entidad->estado == "" || $entidad->total == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                     
                if ($_POST["id"] > 0) {
                    //Es actualizacion
                    $entidad->guardar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                } else {
                    //Es nuevo
                    $entidad->insertar();

                    $msg["ESTADO"] = MSG_SUCCESS;
                    $msg["MSG"] = OKINSERT;
                }
                
                $_POST["id"] = $entidad->idpedido;
                return view('pedido.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->pedido;
        $pedido = new Pedido();
        $pedido->obtenerPorId($id);

      

        return view('pedido.pedido-nuevo', compact('msg', 'cliente', 'titulo')) . '?id=' . $pedido->idpedido;

    }


}
?>
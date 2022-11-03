<?php

namespace App\Http\Controllers;


use App\Entidades\Sucursal; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorSucursal extends Controller
{
    public function nuevo()
    {
        $titulo = "Nueva Sucursal";
        return view( 'sucursal.sucursal-nuevo', compact ('titulo'));
    }

    public function index()
    {
        $titulo = "Listado de Sucursales";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("MENUCONSULTA")) { //otra validación
                $codigo = "MENUCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('sucursal.sucursal-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function guardar(Request $request) {
        
        try {
            //Define la entidad servicio
            $titulo = "Modificar Pedido";
            $entidad = new Sucursal ();
            $entidad->cargarDesdeRequest($request);

           //print_r($_REQUEST);
           //exit;
            //validaciones
            if ($entidad->nombre == "" || $entidad->direccion == "") {
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
                
                $_POST["id"] = $entidad->idsucursal;
                return view('pedido.pedido-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->sucursal;
        $sucursal = new Sucursal();
        $sucursal->obtenerPorId($id);

      

        return view('sucursal.sucursal-nuevo', compact('msg', 'titulo')) . '?id=' . $sucursal->idsucursal;

    }


}
?>
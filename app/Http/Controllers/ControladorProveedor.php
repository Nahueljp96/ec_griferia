<?php

namespace App\Http\Controllers;


use App\Entidades\Proveedor; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorProveedor extends Controller
{
    public function nuevo()
    {   
        $titulo = "Nuevo proveedor";

        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("CLIENTECONSULTA")) { //otra validación
                $codigo = "CLIENTECONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $proveedor = new Proveedor();
                return view('proveedor.proveedor-nuevo', compact('titulo', 'proveedor'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Listado de Proveedores";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("CLIENTECONSULTA")) { //otra validación
                $codigo = "CLIENTECONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('proveedor.proveedor-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Proveedor();
        $aProveedores = $entidad->obtenerFiltrado();

        $data = array(); #variables de configuración 
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProveedores) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/proveedor/" .$aProveedores[$i]->idproveedor. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aProveedores[$i]->nombre;
            $row[] = $aProveedores[$i]->descripcion;
            $row[] = $aProveedores[$i]->correo;
            $row[] = $aProveedores[$i]->telefono;
            $row[] = $aProveedores[$i]->direccion;
            
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProveedores), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProveedores), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Proveedor";
            $entidad = new Proveedor ();
            $entidad->cargarDesdeRequest($request);

            //validaciones
            if ($entidad->nombre == "") {
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
                
                $_POST["id"] = $entidad->idproveedor;
                return view('proveedor.proveedor-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->proveedor;
        $proveedor = new Proveedor();
        $proveedor->obtenerPorId($id);

      

        return view('proveedor.proveedor-nuevo', compact('msg', 'proveedor', 'titulo')) . '?id=' . $proveedor->idproveedor;

    }

    public function editar($id)
    {
        $titulo = "Modificar Proveedor";
        //pregunta si el usuario esta autentificado
        if (Usuario::autenticado() == true) {
            
            if (!Patente::autorizarOperacion("CLIENTEEDITAR")) {
                $codigo = "CLIENTEEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $proveedor = new Proveedor();
                $proveedor->obtenerPorId($id);
                
                return view('proveedor.proveedor-nuevo', compact('proveedor', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request){
        
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("CLIENTEELIMINAR")) {

                $entidad = new Proveedor();
                $entidad->cargarDesdeRequest($request);
                $entidad->eliminar();

               
                $aResultado["err"] = EXIT_SUCCESS; //eliminado correctamente
            } else {
                $codigo = "ELIMINARPROFESIONAL";
                $aResultado["err"] = "No tiene pemisos para la operaci&oacute;n.";
            }
            echo json_encode($aResultado);
        } else {
            return redirect('admin/login');
        }
    }
}
?>
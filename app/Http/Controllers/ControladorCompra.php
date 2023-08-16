<?php

namespace App\Http\Controllers;


use App\Entidades\Compra; 
use App\Entidades\Proveedor; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCompra extends Controller
{
    public function nuevo()
    {   
        $titulo = "Nueva Compra";

        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) { //otra validación
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $compra = New Compra;
                $proveedor = new Proveedor();
                $aProveedores = $proveedor->obtenerTodos();
                return view( 'compra.compra-nuevo', compact ('titulo','compra', 'aProveedores') );
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Listado de Compras";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) { //otra validación
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('compra.compra-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Compra();
        $aCompras = $entidad->obtenerFiltrado();

        $data = array(); #variables de configuración 
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aCompras) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/compra/" .$aCompras[$i]->idcompra. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aCompras[$i]->proveedor;
            $row[] = $aCompras[$i]->nombre;
            $row[] = $aCompras[$i]->descripcion;
            $row[] = "$". number_format ($aCompras[$i]->total, 2, ",", ".");
            $row[] = $aCompras[$i]->fecha;
            $row[] = "<img src='/files/" .$aCompras[$i]->imagen. "' class='img-thumbnail'>"; 
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aCompras), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aCompras), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Compra";
            $entidad = new Compra ();
            $entidad->cargarDesdeRequest($request);

            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta imagen
                $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                 $nombre = date("Ymdhmsi") . ".$extension";
                 $archivo = $_FILES["archivo"]["tmp_name"];
                 move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre"); //guardaelarchivo
                 $entidad->imagen = $nombre;
            }
  

            //validaciones
            if ($entidad->nombre == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                if ($_POST["id"] > 0) {
                    $compraAnt = new Compra();
                    $compraAnt->obtenerPorId($entidad->idcompra);

                    if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        //Eliminar imagen anterior
                        @unlink(env('APP_PATH') . "/public/files/$compraAnt->imagen");                          
                    } else {
                        $entidad->imagen = $compraAnt->imagen;
                    }
 
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
                
                $_POST["id"] = $entidad->idcompra;
                return view('compra.compra-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->compra;
        $compra = new Compra();
        $compra->obtenerPorId($id);

      

        return view('compra.compra-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $compra->idcompra;

    }

    public function editar($id)
    {
        $titulo = "Modificar Producto";
        //pregunta si el usuario esta autentificado
        if (Usuario::autenticado() == true) {
            if (!Patente::autorizarOperacion("PRODUCTOEDITAR")) {
                $codigo = "PRODUCTOEDITAR";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $compra = new Compra();
                $compra->obtenerPorId($id);

                $proveedor = new Proveedor();
                $aProveedores = $proveedor->obtenerTodos();

                return view('compra.compra-nuevo', compact('compra', 'titulo', 'aProveedores'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request){
        
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("PRODUCTOELIMINAR")) {

                $entidad = new Compra();
                //$entidad->cargarDesdeRequest($request); asi hizo profe
                $entidad->obtenerPorId($id);
                @unlink(env('APP_PATH') . "/public/files/$entidad->imagen");                          
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
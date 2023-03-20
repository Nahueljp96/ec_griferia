<?php

namespace App\Http\Controllers;


use App\Entidades\Postulacion; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPostulacion extends Controller
{
    public function nuevo()
    {   
        $titulo = "Nueva postulacion";

        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("POSTULACIONALTA")) { //otra validación
                $codigo = "POSTULACIONCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $postulacion = new Postulacion();

                return view( 'postulacion.postulacion-nuevo', compact ('titulo', 'postulacion'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Listado de Postulaciones";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("POSTULACIONCONSULTA")) { //otra validación
                $codigo = "POSTULACIONCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('postulacion.postulacion-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Postulacion();
        $aPostulaciones = $entidad->obtenerFiltrado();

        $data = array(); #variables de configuración 
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aPostulaciones) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/postulacion/" .$aPostulaciones[$i]->idpostulacion. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aPostulaciones[$i]->nombre;
            $row[] = $aPostulaciones[$i]->apellido;
            $row[] = $aPostulaciones[$i]->celular; 
            $row[] = $aPostulaciones[$i]->correo;
            $row[] = "<a href='/files/" . $aPostulaciones[$i]->curriculum . "' class= 'btn btn-secondary' target=”_blank”><i class='fa-solid fa-download'></i>";
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aPostulaciones), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aPostulaciones), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request) {
       
        try {
            //Define la entidad servicio
            $titulo = "Modificar Postulacion";
            $entidad = new Postulacion ();
            $entidad->cargarDesdeRequest($request);

            if ($_FILES["archivo"]["error"] === UPLOAD_ERR_OK) { //Se adjunta el archivo
                $extension = pathinfo($_FILES["archivo"]["name"], PATHINFO_EXTENSION);
                 $nombre = date("Ymdhmsi") . ".$extension"; //ponemos la variable extension para que concatene la extension del archivo subido.
                 $archivo = $_FILES["archivo"]["tmp_name"];
                 move_uploaded_file($archivo, env('APP_PATH') . "/public/files/$nombre"); //guarda el archivo
                 $entidad->curriculum = $nombre;
            }
  
            
            //validaciones
            if ($entidad->nombre == "" || $entidad->correo == "") {
                $msg["ESTADO"] = MSG_ERROR;
                $msg["MSG"] = "Complete todos los datos";
            } else {
                     
                if ($_POST["id"] > 0) {
                    $postulacionAnt = new Postulacion();
                    $postulacionAnt->obtenerPorId($entidad->idpostulacion);

                    if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        //Eliminar archivo anterior
                        @unlink(env('APP_PATH') . "/public/files/$postulacionAnt->curriculum");                          
                    } else {
                        $entidad->curriculum = $postulacionAnt->curriculum;
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
                
                $_POST["id"] = $entidad->idpostulacion;
                return view('postulacion.postulacion-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->postulacion;
        $postulacion = new Postulacion();
        $postulacion->obtenerPorId($id);

      

        return view('postulacion.postulacion-nuevo', compact('msg', 'titulo')) . '?id=' . $postulacion->idpostulacion;

    }

    public function editar($id)
    {
        $titulo = "Modificar Postulacion";
        //pregunta si el usuario esta autentificado
        if (Usuario::autenticado() == true) {
            
            if (!Patente::autorizarOperacion("POSTULACIONEDITAR")) {
                $codigo = "POSTULACIONMODIFICACION";
                $mensaje = "No tiene pemisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $postulacion = new Postulacion();
                $postulacion->obtenerPorId($id);
                
                return view('postulacion.postulacion-nuevo', compact('postulacion', 'titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request)
    {           
        $id = $request->input("id");

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("POSTULACIONBAJA")) {

                $entidad = new Postulacion();
                $entidad->cargarDesdeRequest($request);
               // $entidad->obtenerPorId($id);
                //print_r($entidad); exit;
                    @unlink(env('APP_PATH') . "/public/files/$entidad->curriculum");
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
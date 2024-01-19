<?php

namespace App\Http\Controllers;


use App\Entidades\Producto; 
use App\Entidades\Categoria; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

require app_path() . '/start/constants.php';

class ControladorProducto extends Controller
{
    public function nuevo()
    {   
        $titulo = "Nuevo Producto";

        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) { //otra validación
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                $producto = New Producto;
                $categoria = new Categoria();
                $aCategorias = $categoria->obtenerTodos();
                return view( 'producto.producto-nuevo', compact ('titulo','producto', 'aCategorias') );
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function index()
    {
        $titulo = "Listado de Productos";
        if (Usuario::autenticado() == true) { //validación
            if (!Patente::autorizarOperacion("PRODUCTOCONSULTA")) { //otra validación
                $codigo = "PRODUCTOCONSULTA";
                $mensaje = "No tiene permisos para la operaci&oacute;n.";
                return view('sistema.pagina-error', compact('titulo', 'codigo', 'mensaje'));
            } else {
                return view('producto.producto-listar', compact('titulo'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Producto();
        $aProductos = $entidad->obtenerFiltrado();

        $data = array(); #variables de configuración 
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/producto/" .$aProductos[$i]->idproducto. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aProductos[$i]->nombre;
            $row[] = $aProductos[$i]->cantidad;
            $row[] = "$". number_format ($aProductos[$i]->precio, 2, ",", "."); 
            $row[] = "<img src='/files/" .$aProductos[$i]->imagen. "' class='img-thumbnail'>";
            $row[] = $aProductos[$i]->categoria;
            $row[] = $aProductos[$i]->descripcion;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }

    public function guardar(Request $request) {
        try {
            //Define la entidad servicio
            $titulo = "Modificar Producto";
            $entidad = new Producto ();
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
                    $productAnt = new Producto();
                    $productAnt->obtenerPorId($entidad->idproducto);

                    if($_FILES["archivo"]["error"] === UPLOAD_ERR_OK){
                        //Eliminar imagen anterior
                        @unlink(env('APP_PATH') . "/public/files/$productAnt->imagen");                          
                    } else {
                        $entidad->imagen = $productAnt->imagen;
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
                
                $_POST["id"] = $entidad->idproducto;
                return view('producto.producto-listar', compact('titulo', 'msg'));
            }
        } catch (Exception $e) {
            $msg["ESTADO"] = MSG_ERROR;
            $msg["MSG"] = ERRORINSERT;
        }

        $id = $entidad->producto;
        $producto = new Producto();
        $producto->obtenerPorId($id);

      

        return view('producto.producto-nuevo', compact('msg', 'producto', 'titulo')) . '?id=' . $producto->idproducto;

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
                $producto = new Producto();
                $producto->obtenerPorId($id);

                $categoria = new Categoria();
                $aCategorias = $categoria->obtenerTodos();

                return view('producto.producto-nuevo', compact('producto', 'titulo', 'aCategorias'));
            }
        } else {
            return redirect('admin/login');
        }
    }

    public function eliminar(Request $request){
        
        $id = $request->input('id');

        if (Usuario::autenticado() == true) {
            if (Patente::autorizarOperacion("PRODUCTOELIMINAR")) {

                $entidad = new Producto();
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

    public function editarPrecio()
    {
        $titulo = "Editar Precio";

        $producto = new Producto();
        $aProductos =$producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        return view('producto.producto-editarPrecio', compact('aProductos', 'aCategorias', 'titulo', 'producto'));
        
    }
    public function editarPrecioCategoria()
    {
        $titulo = "Editar Precio por Categoria";

        $producto = new Producto();
        $aProductos =$producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        return view('producto.producto-editarPrecioCategoria', compact('aProductos', 'aCategorias', 'titulo', 'producto'));
        
    }
    
    public function subirPrecios(Request $request)
    {   
        
                $porcentaje = $request->input('txtPorcentaje');

            // Obtener todos los productos
            $productos = DB::table('productos')->get();

            // Iterar sobre cada producto y actualizar el precio
            foreach ($productos as $producto) {
                $nuevoPrecio = $producto->precio * (1 + ($porcentaje / 100)); // Calcular el nuevo precio
                DB::table('productos')->where('idproducto', $producto->idproducto)->update(['precio' => $nuevoPrecio]);
    }

    return redirect()->back()->with('success', 'Los precios se han actualizado correctamente.');
    }

    public function subirPreciosCategoria(Request $request) 
    {

            $idCategoria = $request->input('lstCategoria');
            $porcentaje = $request->input('txtPorcentaje');

            // Validar y asegurarse de que $idCategoria y $porcentaje tengan valores válidos

            // Obtener productos de la categoría seleccionada
            $productos = Producto::where('fk_idcategoria', $idCategoria)->get();

            // Subir los precios según el porcentaje
            foreach ($productos as $producto) {
                $nuevoPrecio = $producto->precio * (1 + ($porcentaje / 100));

                // Especificar la clave primaria al realizar la actualización
                Producto::where('idproducto', $producto->idproducto)->update(['precio' => $nuevoPrecio]);
            }

            return redirect()->back()->with('success', 'Los precios de la categoría se han actualizado correctamente.');
    }
}
?>
<?php

namespace App\Http\Controllers;
use App\Entidades\Producto; 
use App\Entidades\Categoria;
use Illuminate\Http\Request;
use App\Entidades\Sucursal;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use App\Entidades\CarritoProducto;
use Session;


require app_path() . '/start/constants.php';

class ControladorWebTakeaway extends Controller
{
    public function index()
    {       
            $pg= "takeaway";
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $producto = new Producto();
            $aProductos = $producto->obtenerTodos();

            $categoria= new Categoria();
            $aCategorias= $categoria->obtenerTodos();
            return view("web.takeaway", compact("pg", "aSucursales", "aProductos", "aCategorias"));
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
    
    public function cargarCarrito(Request $request){

        $producto = new Producto();
        $aProductos = $producto->obtenerTodos();

        $categoria = new Categoria();
        $aCategorias = $categoria->obtenerTodos();

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        
        $pg = "takeaway";

        //asigna variables a los datos cargados en los input
        $cantidadProducto = $request->input("txtCantidadProducto");
        $idProductoSelect = $request->input("txtIdProducto");
        //asigna la variable $idcliente = idcliente de la sesion...
        $idcliente = Session::get("idcliente");

        //si hay cliente logueado
        if($idcliente >0){
            $carrito = new Carrito();
            $carrito_producto = new Carrito_producto();

            //si tiene carrito,
            if($carrito->obtenerPorCliente($idcliente) != null){
                $carrito_producto->fk_idcarrito = $carrito->idcarrito;
            }else{
                //si no tiene carrito asignado//crear un carrito con ese id de cliente
                $carrito->fk_idcliente = $idcliente;
                $carrito->insertar();
                $carrito_producto->fk_idcarrito = $carrito->idcarrito;

            }
            //agrega el id del producto y la cantidad obtenida del input
            $carrito_producto->fk_idproducto = $idProductoSelect;
            $carrito_producto->cantidad = $cantidadProducto;
            $carrito_producto->indexx = 0;
            $carrito_producto->insertar();

            //forma mejorada de poner los msg:
            $msg = ['estado' => 'success', 'msg' => 'Producto agregado al carrito!!'];
            

            return view("web.takeaway", compact("pg", "aSucursales", "aProductos", "aCategorias" , "msg"));
        } else{
            $msg = ['estado' => 'danger', 'msg' => 'Debe iniciar sesion!!'];
            
            return view("web.takeaway", compact("pg", "aSucursales", "aProductos", "aCategorias" , "msg"));
        }

        
    

    }
}

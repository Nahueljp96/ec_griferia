<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entidades\Producto;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Carrito;
use App\Entidades\Carrito_producto;
use App\Entidades\Pedido;
use DB;
use Session;
require app_path().'/start/constants.php';


class ControladorWebCarrito extends Controller
{
     public function index(){
      $idcliente= Session::get('idcliente');
      //si hay cliente logueado
      if($idcliente >0){
            $carrito = new Carrito();

            //si tiene carrito
            if ($carrito->obtenerPorCliente($idcliente) != null){
                  $carrito_producto = new Carrito_producto();
                  if($carrito_producto->obtenerPorCarrito($carrito->idcarrito) !=null){
                        $idcarrito=$carrito->idcarrito;
                        $aCarrito_productos = $carrito_producto->obtenerPorCarrito($carrito->idcarrito);
                  }else{
                        $aCarrito_productos = array();
                        $sucursal =new Sucursal();
                        $aSucursales = $sucursal->obtenerTodos();

                        $pg= "carrito";
                        return view("web.carrito", compact("pg","aSucursales", 'carrito_producto', 'carrito', 'aCarrito_productos'));
                  }
                  
            }
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $pg= "carrito";
            return view("web.carrito", compact("pg","aSucursales", 'carrito_producto', 'carrito', 'aCarrito_productos'));


      }
     }
     public function finalizarPedido(Request $request){
            $pedido = new Pedido();
            $pedido->fecha = Date('Y-m-d-H:i:s');
            
            $carrito_producto = new Carrito_producto();
            $aCarritoProductos = $carrito_producto->obtenerPorCliente(Session::get("idcliente"));

            foreach ($aCarritoProductos as $carrito){
                $pedido->descripcion .=  $carrito->producto ." - ";
                $pedido->total = $carrito->cantidad * $carrito->precio;  
            }
            
            
            $pedido->fk_idsucursal = $request->input('lstSucursal');
            $pedido->fk_idcliente = Session::get("idcliente");
            $pedido->fk_idestado= PEDIDO_PENDIENTE;
            
            $pedido->insertar();

            //Vaciar el carrito
            $carrito_producto->eliminarPorCliente(Session::get("idcliente"));

            $carrito = new Carrito();
            $carrito->eliminarPorCliente(Session::get("idcliente"));
            return redirect('/mi-cuenta')->with('success', 'El pedido se ha procesado correctamente.');
     }
     
     public function eliminarProducto(Request $request)
            {
             $productoId = $request->input('producto_id');
                  // Eliminar el producto del carrito en la base de datos
                  DB::table('carrito_productos')->where('fk_idproducto', $productoId)->delete();

                  return redirect()->back()->with('success', 'El producto ha sido eliminado del carrito.');

            
            }

     
}



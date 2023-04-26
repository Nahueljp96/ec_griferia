<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Illuminate\Http\Request;

class ControladorWebCambiarClave extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            
            

            return view("web.cambiar-clave", compact('aSucursales'));
    }

    public function guardar(Request $request){

        $pg= "Cambiar clave";

        $clave = trim($request->input('txtClave')); //trim elemina los espacios en blanco a la hora de ingresar los datos a la variable.
        $reclave= trim($request->input('txtReClave'));
            
        if($clave == $reclave){
            $cliente = new Cliente();
            $cliente->obtenerPorId(Session::get ('idcliente'));
            $cliente->clave = bcrypt($clave); #forma mas optima de y sencilla de encriptar clave y levemente mas segura que hash
            $cliente->guardar();
            

            
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            $msg['estado']= "success";
            $msg['msg']= "Clave  cambiada correctamente";
            return view("web.cambiar-clave", compact ('pg', 'aSucursales', 'msg'));

        }else{
        $msg['estado']= "danger";
        $msg['msg']= "Las Claves no coinciden";
        
        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();
        return view ("web.cambiar-clave", compact('pg', 'aSucursales', 'msg'));
      }
    }
}

?>
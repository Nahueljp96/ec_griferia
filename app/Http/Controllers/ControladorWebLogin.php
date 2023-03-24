<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;
use Session;



class ControladorWebLogin extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            
            return view("web.login", compact('aSucursales'));

    }

    public function ingresar(Request $request){

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $correo = $request->input('txtCorreo');
        $clave = $request->input('txtClave');

        

        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($correo);
        
        if($cliente->idcliente > 0 && password_verify($clave, $cliente->clave)){
            //NOTA: Solo va a poder loguearse si la passwd esta encriptada.
            $cliente->obtenerPorId ($cliente->idcliente);
            Session::put("idcliente", $cliente->idcliente);
            return view("web.mi-cuenta", compact ('cliente', 'aSucursales'));
        }else {
            $msg= "Usuario o clave incorrecto";
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.login", compact ('msg', 'aSucursales'));
        }
        

        
    }
}


?> 
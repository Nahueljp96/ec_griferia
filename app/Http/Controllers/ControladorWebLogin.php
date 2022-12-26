<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;




class ControladorWebLogin extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.login", compact('aSucursales'));
    }

    public function ingresar(Request $request){
        $correo = $request->input('txtCorreo');
        $clave = $request->input('txtClave');

        $cliente = new Cliente();
        $cliente->obtenerPorCorreo($correo);
        if($cliente->idcliente > 0 && password_verify($clave, $cliente->clave)){
            return redirect("/mi-cuenta");
        }else {
            $msg= "Usuario o clave incorrecto";
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.login", compact ('msg', 'aSucursales'));
        }
        

        
    }
}
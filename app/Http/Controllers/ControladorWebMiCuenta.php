<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Iluminate\Http\Request;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            
            if (Session::get ('idcliente') >0){
            $cliente = new Cliente();
            $cliente->obtenerPorId(Session::get('idcliente'));
            }else{
                $cliente = new Cliente();
            }

            

            return view("web.mi-cuenta", compact('aSucursales','cliente'));
    }
}

?>
<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;

class ControladorWebMiCuenta extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            $cliente = new Cliente();
            $aClientes = $cliente->obtenerTodos();
            return view("web.mi-cuenta", compact('aSucursales', 'aClientes' ,'cliente'));
    }
}

?>
<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;



class ControladorWebNosotros extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.nosotros", compact("aSucursales"));
    }
}

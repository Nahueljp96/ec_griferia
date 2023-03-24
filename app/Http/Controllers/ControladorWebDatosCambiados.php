<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;



class ControladorWebDatosCambiados extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.datos-cambiados", compact("aSucursales"));
    }

    
}

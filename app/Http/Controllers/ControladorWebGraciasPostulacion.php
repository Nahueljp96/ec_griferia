<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;



class ControladorWebGraciasPostulacion extends Controller
{
    public function graciasPostulacion()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.gracias-postulacion", compact("aSucursales"));
    }

    
}

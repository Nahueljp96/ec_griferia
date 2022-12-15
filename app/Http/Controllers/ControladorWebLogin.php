<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;




class ControladorWebLogin extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            return view("web.login", compact('aSucursales'));
    }
}
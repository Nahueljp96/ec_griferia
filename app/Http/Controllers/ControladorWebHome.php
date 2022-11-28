<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sistema\Sucursal;
use Session;

class ControladorWebHome extends Controller
{
    public function index()
    {
            $pg= "home";
            return view("web.inicio", compact ('pg'));
    }
}

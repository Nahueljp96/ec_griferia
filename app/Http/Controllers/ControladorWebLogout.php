<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use App\Entidades\Sucursal;
use Session;

class ControladorWebLogout extends Controller
{
    public function logout()
    {
            Session::put("idcliente", "");
            
            return redirect ("/");
    }
}



?>
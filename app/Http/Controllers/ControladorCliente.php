<?php

namespace App\Http\Controllers;


use App\Entidades\Cliente; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCliente extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo cliente";
        return view( 'cliente.cliente-nuevo', compact ('titulo'));
    }


}
?>
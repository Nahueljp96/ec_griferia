<?php

namespace App\Http\Controllers;


use App\Entidades\Estado; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorEstado extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo Estado";
        return view( 'estado.estado-nuevo', compact ('titulo'));
    }


}
?>
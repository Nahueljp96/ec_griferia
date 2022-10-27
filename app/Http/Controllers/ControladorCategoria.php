<?php

namespace App\Http\Controllers;


use App\Entidades\Categoria; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorCategoria extends Controller
{
    public function nuevo()
    {
        $titulo = "Nueva Categoria";
        return view( 'categoria.categoria-nuevo', compact ('titulo'));
    }


}
?>
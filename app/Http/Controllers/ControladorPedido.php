<?php

namespace App\Http\Controllers;


use App\Entidades\Pedido; 
use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorPedido extends Controller
{
    public function nuevo()
    {
        $titulo = "Nuevo pedido";
        return view( 'pedido.pedido-nuevo', compact ('titulo'));
    }


}
?>
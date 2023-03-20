<?php

namespace App\Http\Controllers;

use App\Entidades\Sistema\Patente;
use App\Entidades\Sistema\Usuario;
use Session;
use App\Entidades\Sucursal;
use App\Entidades\Cliente;
use App\Entidades\Pedido;
use Illuminate\Http\Request;

class ControladorWebCambiarDatos extends Controller
{
    public function index()
    {
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
            
            if (Session::get ('idcliente') >0){
            $cliente = new Cliente();
            $cliente->obtenerPorId(Session::get('idcliente'));
            }else{
                $cliente = new Cliente();
            }

            return view("web.cambiar-datos", compact('aSucursales','cliente'));
    }

    public function guardar(Request $request){

        $sucursal = new Sucursal();
        $aSucursales = $sucursal->obtenerTodos();

        $msg = "cambiado correctamente";
        
        
        $nombre = $request->input('txtNombre');
        $apellido = $request->input('txtApellido');
        $celular = $request->input('txtCelular');
        $correo = $request->input('txtCorreo');
        $direccion = $request->input('txtDireccion');

        $cliente = new Cliente();
        $cliente->nombre = $nombre;
        $cliente->apellido = $apellido;
        $cliente->celular = $celular;
        $cliente->correo = $correo;
        $cliente->direccion = $direccion;
        $cliente->guardar();
        return view ("web.mi-cuenta", compact('cliente', 'aSucursales'));
    }
}

?>
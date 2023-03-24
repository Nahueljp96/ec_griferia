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

    public function editar(Request $request){

        $cliente = new Cliente();
        $cliente->obtenerPorId(Session::get('idcliente'));

        $pg= "Cambiar-Datos";
        
        
        $nombre = $request->input('txtNombre');
        $apellido = $request->input('txtApellido');
        $celular = $request->input('txtCelular');
        $dni = $request->input('txtDni');
        $correo = $request->input('txtCorreo');
        $direccion = $request->input('txtDireccion');

            
            $cliente->nombre = $nombre;
            $cliente->apellido = $apellido;
            $cliente->dni = $dni;
            $cliente->celular = $celular;
            $cliente->correo = $correo;
            $cliente->direccion = $direccion;
            $cliente->guardar();

            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();
        
        $msg["estado"]= "success";
        $msg["msg"]= "Cambiado Correctamente";
        return view ("web.mi-cuenta", compact('cliente', 'aSucursales', 'msg', 'pg'));
    }
}

?>
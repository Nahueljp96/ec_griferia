<?php

namespace App\Http\Controllers;
use App\Entidades\Sucursal;
use Illuminate\Http\Request;
use App\Entidades\Cliente;

class ControladorWebNuevoRegistro extends Controller{
      public function index(){

            $pg = "nuevo-registro";
            $sucursal = new Sucursal();
            $aSucursales = $sucursal->obtenerTodos();

            return view("web.nuevo-registro", compact ('pg', 'aSucursales'));
      }
      
      public function enviar(Request $request){
           $nombre = $request->input('txtNombre'); 
           $apellido = $request->input('txtApellido'); 
           $correo = $request->input('txtCorreo'); 
           $dni = $request->input('txtDni'); 
           $celular = $request->input('txtCelular'); 
           $clave = $request->input('txtClave');
           
           $cliente = new Cliente();
           $cliente->nombre = $nombre;
           $cliente->apellido = $apellido;
           $cliente->correo = $correo;
           $cliente->dni = $dni;
           $cliente->celular = $celular;
           $cliente->clave = password_hash($clave, PASSWORD_DEFAULT);
           $cliente->insertar();

           return redirect ("/login");
      }
}


?>
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Entidades\Pedido;
use App\Entidades\Cliente;
use Log;

use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;


#use Barryvdh\DomPDF\PDF as DomPDFPDF; pruebas, prestar atención esto hace como cambiar el llamado a la biblitoteca.
use Illuminate\Support\Facades\Route;



class BoletaController extends Controller

{
    public function generarBoleta($idPedido)
{
    
    $pedido = Pedido::find($idPedido);

    

    // Añade esta línea para verificar la variable antes de cargar la vista
    

    $pdf = FacadePdf::loadView('pedido.boleta', ['pedido' => $pedido]);

    return $pdf->download('boleta.pdf');
}

}





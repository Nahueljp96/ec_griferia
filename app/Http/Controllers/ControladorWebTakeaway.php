<?php

namespace App\Http\Controllers;
use App\Entidades\Producto; 
use App\Entidades\Categoria;
use Illuminate\Http\Request;

require app_path() . '/start/constants.php';

class ControladorWebTakeaway extends Controller
{
    public function index()
    {
            return view("web.takeaway");
    }

    public function cargarGrilla()
    {
        $request = $_REQUEST;

        $entidad = new Producto();
        $aProductos = $entidad->obtenerFiltrado();

        $data = array(); #variables de configuración 
        $cont = 0;

        $inicio = $request['start'];
        $registros_por_pagina = $request['length'];


        for ($i = $inicio; $i < count($aProductos) && $cont < $registros_por_pagina; $i++) {
            $row = array();
            $row[] = "<a href='/admin/producto/" .$aProductos[$i]->idproducto. "' class='btn btn-secondary'><i class='fa-solid fa-pencil'></i></a>";
            $row[] = $aProductos[$i]->nombre;
            $row[] = $aProductos[$i]->cantidad;
            $row[] = "$". number_format ($aProductos[$i]->precio, 2, ",", "."); 
            $row[] = "<img src='/files/" .$aProductos[$i]->imagen. "' class='img-thumbnail'>";
            $row[] = $aProductos[$i]->categoria;
            $row[] = $aProductos[$i]->descripcion;
            $cont++;
            $data[] = $row;
        }

        $json_data = array(
            "draw" => intval($request['draw']),
            "recordsTotal" => count($aProductos), //cantidad total de registros sin paginar
            "recordsFiltered" => count($aProductos), //cantidad total de registros en la paginacion
            "data" => $data,
        );
        return json_encode($json_data);
    }
}

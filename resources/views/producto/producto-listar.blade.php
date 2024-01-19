@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/home">Inicio</a></li>
    <li class="breadcrumb-item active">Productos</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/producto/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/clientes");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div>
    <a title="Nuevo" href="{{ route('producto.editarPrecio') }}" class="fa fa-plus-circle" aria-hidden="true"><span>Subir Precios</span></a>
 </div>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Cantidad </th>
            <th>Precio</th>
            <th>Imagen</th>
            <th>Categoria</th>
            <th>Descripción</th>
        </tr>
    </thead>
</table> 
<script>
	$(document).ready( function () {
        var dataTable = $('#grilla').DataTable({
	    "processing": true, // que se Procesa
        "serverSide": true, // que se ejecuta del lado del servidor 
	    "bFilter": true, // que tiene el filtro/sistema de filtrado
	    "bInfo": true,
	    "bSearchable": true, //barra de busqueda
        "pageLength": 25, // cantidad de registros por página
        "order": [[ 0, "asc" ]], // ordenamiento desde la primera columna de manera ascendente
	    "ajax": "{{ route('producto.cargarGrilla') }}" //atributo que busca los datos para la grilla.
	});
} );   
</script>
@endsection
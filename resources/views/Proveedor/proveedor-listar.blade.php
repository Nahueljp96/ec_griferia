@extends('plantilla')

@section('titulo', "$titulo")

@section('scripts')
<link href="{{ asset('css/datatables.min.css') }}" rel="stylesheet">
<script src="{{ asset('js/datatables.min.js') }}"></script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin">Inicio</a></li>
    <li class="breadcrumb-item active">Proveedores</a></li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/proveedor/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Recargar" href="#" class="fa fa-refresh" aria-hidden="true" onclick='window.location.replace("/admin/proveedores");'><span>Recargar</span></a></li>
</ol>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<table id="grilla" class="display">
    <thead>
        <tr>
            <th></th>
            <th>Nombre</th>
            <th>Correo </th>
            <th>Telefono</th>
            <th>Direccion</th>
            <th>Descripcion</th>
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
	    "ajax": "{{ route('proveedor.cargarGrilla') }}" //atributo que busca los datos para la grilla.
	});
} );   
</script>
@endsection


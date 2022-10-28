@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')
<script>
    globalId = '<?php echo isset($postulacion->idppostulacion) && $postulacion->idpostulacion > 0 ? $postulacion->idppostulacion : 0; ?>';
    <?php $globalId = isset($postulacion->idpostulacion) ? $postulacion->idpostulacion : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/postulaciones">Postulaciones</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/cliente/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/postulacion";
}
</script>
@endsection
@section('contenido')
<?php
if (isset($msg)) {
    echo '<div id = "msg"></div>';
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>
<div class="panel-body">
        <div id = "msg"></div>
        <?php
if (isset($msg)) {
    echo '<script>msgShow("' . $msg["MSG"] . '", "' . $msg["ESTADO"] . '")</script>';
}
?>

      <form id="form1" method="POST">
            <div class="row">
                
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input> <!--Linea de seguridad !-->
                  <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required> <!--Almacena el Id en el caso de estar editando !-->
                  <div class="form-group col-lg-6">
                  <label>Nombre: *</label>
                        <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="" required>
                  </div> 
                 
                <div class="form-group col-lg-6">
                <label>Correo: *</label>
                    <input type="email" id="txtCorreo" name="txtCorreo" class="form-control" value="" required>
                </div> 
                 
                <div class="form-group col-lg-6">
                <label>Apellido: *</label>
                    <input type="text" id="txtApellido" name="txtApellido" class="form-control" value="" required>
                </div> 
            
                <div class="form-group col-lg-6">
                <label>Celular: *</label>
                    <input type="text" id="txtCelular" name="txtCelular" class="form-control" value="" required>
                </div> 

                <div class="form-group col-lg-6">
                <label>Cv: *</label>
                    <input type="text" id="txtCv" name="txtCv" class="form-control" value="" required>
                </div> 
            </div>
      </form>           
@endsection
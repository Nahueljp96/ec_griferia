@extends('plantilla')
@section('titulo', "$titulo")
@section('scripts')

<script>
    globalId = '<?php echo isset($compra->idcompra) && $compra->idcompra > 0 ? $compra->idcompra : 0; ?>';
    <?php $globalId = isset($compra->idcompra) ? $compra->idcompra : "0";?>
</script>
@endsection
@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="/admin/home">Inicio</a></li>
    <li class="breadcrumb-item"><a href="/admin/compras">Compras</a></li>
    <li class="breadcrumb-item active">Modificar</li>
</ol>
<ol class="toolbar">
    <li class="btn-item"><a title="Nuevo" href="/admin/compra/nuevo" class="fa fa-plus-circle" aria-hidden="true"><span>Nuevo</span></a></li>
    <li class="btn-item"><a title="Guardar" href="#" class="fa fa-floppy-o" aria-hidden="true" onclick="javascript: $('#modalGuardar').modal('toggle');"><span>Guardar</span></a>
    </li>
    @if($globalId > 0)
    <li class="btn-item"><a title="Eliminar" href="#" class="fa fa-trash-o" aria-hidden="true" onclick="javascript: $('#mdlEliminar').modal('toggle');"><span>Eliminar</span></a></li>
    @endif
    <li class="btn-item"><a title="Salir" href="#" class="fa fa-arrow-circle-o-left" aria-hidden="true" onclick="javascript: $('#modalSalir').modal('toggle');"><span>Salir</span></a></li>
</ol>
<script>
function fsalir(){
    location.href ="/admin/compras";
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

      <form id="form1" method="POST" enctype="multipart/form-data">
            <div class="row">
                
                  <input type="hidden" name="_token" value="{{ csrf_token() }}"></input> <!--Linea de seguridad !-->
                  <input type="hidden" id="id" name="id" class="form-control" value="{{$globalId}}" required> <!--Almacena el Id en el caso de estar editando !-->
                  <div class="form-group col-lg-6">
                  <label>Nombre: *</label>
                        <input type="text" id="txtNombre" name="txtNombre" class="form-control" value="{{$compra->nombre}}" required>
                  </div>

                <div class="form-group col-6"> <!--Como traer al editar el desplegable ¡-->
                  <label>Proveedor: *</label>
                  <select id="lstProveedor" name="lstProveedor" class="form-control selectpicker" required>
                        <option value="" disabled selected>Seleccionar</option>
                              @foreach($aProveedores as $proveedor)
                              @if($proveedor->idproveedor == $compra->fk_idproveedor)
                        <option selected value="{{ $proveedor->idproveedor }}">{{ $proveedor->nombre }}</option>
                              @else
                        <option value="{{ $proveedor->idproveedor }}">{{ $proveedor->nombre }}</option>
                              @endif
                              @endforeach
                  </select>
                </div> 
                 
                <div class="form-group col-lg-6">
                <label>Total: *</label>
                    <input type="number" id="txtTotal" name="txtTotal" class="form-control" value="{{$compra->total}}" required>
                </div>
                <div class="form-group col-lg-6">
                  <label>Fecha: *</label>
                        <input type="date" id="txtFecha" name="txtFecha" class="form-control" value="{{$compra->fecha}}" required>
                  </div>  
            
                  <div class="col-6">
                  <label>Archivo: *</label>
                  <input type="file" id="archivo" name="archivo" class="" value="{{$compra->imagen}}">
                  <div id="vistaPreviaContainer" style="max-width: 300px; max-height: 300px;"></div>
                  </div>


                <div class="form-group col-lg-6">
                    <div class="form-group col-lg-6">
                    <label>Descripcion: *</label>
                    <textarea id="txtDescripcion" name="txtDescripcion" class="form-control" rows="4" required>{{$compra->descripcion}}</textarea>
                </div>

                
            </div>
                
            </div>
      </form>
    </div>
    <div class="modal fade" id="mdlEliminar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Eliminar registro?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">¿Deseas eliminar el registro actual?</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-primary" onclick="eliminar();">Sí</button>
          </div>
        </div>
      </div>
    </div>
<script>

    $("#form1").validate();

    function guardar() {
        if ($("#form1").valid()) {
            modificado = false;
            form1.submit();
        } else {
            $("#modalGuardar").modal('toggle');
            msgShow("Corrija los errores e intente nuevamente.", "danger");
            return false;
        }
    }

    function eliminar() {
        $.ajax({
            type: "GET",
            url: "{{ asset('admin/compra/eliminar') }}",
            data: { id:globalId },
            async: true,
            dataType: "json",
            success: function (data) {
                if (data.err = "0") {
                    msgShow("Registro eliminado exitosamente.", "success");
                    $("#btnEnviar").hide();
                    $("#btnEliminar").hide();
                    $('#mdlEliminar').modal('toggle');
                } else {
                    msgShow("Error al eliminar", "success");
                }
            }
        });
    }

</script>

<script> 
      // Script para mostrar la imagen, y tambien vista previa del pdf segun el navegador (no anda bien ver pdf)
    $("#archivo").on("change", function() {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var fileType = input.files[0].type;

                if (fileType.startsWith("image")) {
                    // Si es una imagen, mostrar la vista previa como imagen
                    $("#vistaPreviaContainer").html(`<img src="${e.target.result}" alt="Vista previa" style="max-width: 100%; max-height: 100%;">`);
                
                } else {
                    // Otros tipos de archivos
                    $("#vistaPreviaContainer").html("Vista previa no disponible para este tipo de archivo.");
                }
            };

            reader.readAsDataURL(input.files[0]);
        }
    });
</script>

@endsection
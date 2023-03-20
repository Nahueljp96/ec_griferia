@extends ('web.plantilla')

@section('contenido')

      <div class="container">
            <div class="heading_container">
            <h2 class="">
            Mi Cuenta:
            </h2>
            @if (Session::get("idcliente") > 0)
            <h3 class="pt-5">
                  <label for="">Nombre y Apellido:</label>
                  {{$cliente->nombre ." " . $cliente->apellido}}
            </h3>
            <h3 class="">
                  <label for="">Correo:</label>
                  {{$cliente->correo}}
            </h3>
            <h3 class="">
                  <label for="">Dni:</label>
                  {{$cliente->dni}}
            </h3>
            <h3 class="">
                  <label for="">Celular:</label>
                  {{$cliente->celular}}
            </h3>
            <h3 class="">
                  <label for="">Direccion:</label>
                  {{$cliente->direccion}}
            </h3>
            <div class="pt-5">
            <a href="/cambiar-datos" class="link-warning">
                  Editar Datos
                  <i class="fa fa-user" aria-hidden="true"></i>
            <a>
            </div>      
            @else

            <h3 class="md-10">
                  Por favor, ingrese para ver su cuenta!!
            </h3>
            @endif

            </div>
            <div class="row">
            <div class="col-md-6">
            <div class="form_container">

                  <div>
                       
                  </div>
                  
                 
                  
                 
            </div>
            </div>
            </div>
      </div>
@endsection
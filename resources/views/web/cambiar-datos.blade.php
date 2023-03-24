@extends('web.plantilla')
@section('contenido')


  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Cambiar Datos
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="" method="post" enctype="multipart/form-data">
              @if(isset($msg))
                <div class="alert arlet-{{$msg['estado']}}" role="alert">
                  {{$msg["msg"]}}
                </div>
              @endif  
              @csrf
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              
              <div>
                  <label for="">Nombre:</label>
                <input type="text" class="form-control" name="txtNombre" placeholder="Nombre" value="{{$cliente->nombre}}" />
              </div>
              <div>
                  <label for="">Apellido:</label>
                <input type="text" class="form-control"name="txtApellido" placeholder="Apellido" value="{{$cliente->apellido}}" />
              </div>
              <div>
                <label for="">DNI:</label>
              <input type="text" class="form-control"name="txtDni" placeholder="Dni" value="{{$cliente->dni}}" />
              </div>
              <div>
                  <label for="">Telefono:</label>
                <input type="text" class="form-control"name="txtCelular" placeholder="Telefono" value="{{$cliente->celular}}" />
              </div>
              <div>
                  <label for="">Correo:</label>
                <input type="email" class="form-control"name="txtCorreo" placeholder="Correo"  value="{{$cliente->correo}}"/>
              </div>
              <div>
                  <label for="">Direccion:</label>
                <input type="text" class="form-control"name="txtDireccion" placeholder="Direccion" value="{{$cliente->direccion}}" />
              </div>
              
              
              
              
              <div class="btn_box">
                <button type="submit">
                  Cambiar Datos
                </button>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6">
          <div class="map_container ">
            <div id="googleMap"></div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end book section -->

@endsection
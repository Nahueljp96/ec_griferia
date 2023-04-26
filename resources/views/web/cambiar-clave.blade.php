@extends('web.plantilla')
@section('contenido')


  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Cambiar Clave
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
                  <label for="">Clave:</label>
                <input type="text" class="form-control" name="txtClave"/>
              </div>
              <div>
                  <label for="">Repetir Clave:</label>
                <input type="text" class="form-control"name="txtReClave"/>
              </div>
              
              <div class="btn_box">
                <button type="submit">
                  Cambiar Clave
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
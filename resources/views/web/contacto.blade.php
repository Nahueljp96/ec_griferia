@extends('web.plantilla')
@section('contenido')


  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Contactanos!
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              
              <div>
                <input type="text" class="form-control" name="txtNombre" placeholder="Nombre" />
              </div>
              <div>
                <input type="text" class="form-control"name="txtApellido" placeholder="Apellido" />
              </div>
              <div>
                <input type="text" class="form-control"name="txtTelefono" placeholder="Telefono" />
              </div>
              <div>
                <input type="email" class="form-control"name="txtCorreo" placeholder="Correo" />
              </div>
              <div>
                <textarea name="txtMensaje" id="txtMensaje" class="form-control" placeholder="Mensaje:"></textarea>
              </div>
              
              
              <div class="btn_box">
                <button>
                  Enviar
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
 
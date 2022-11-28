@extends('web.plantilla')
@section('contenido')


  <!-- book section -->
  <section class="book_section layout_padding">
    <div class="container">
      <div class="heading_container">
        <h2>
          Book A Table
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form action="" method="post" enctype="multipart/form-data">
              <div>
                <input type="text" class="form-control" placeholder="Nombre y Apellido" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Telefono" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo" />
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
 
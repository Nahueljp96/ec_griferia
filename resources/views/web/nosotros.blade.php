@extends("web.plantilla")
@section('contenido')

  <!-- about section -->

  <section class="about_section layout_padding">
    <div class="container  ">

      <div class="row">
        <div class="col-md-6 ">
          <div class="img-box">
            <img src="web/images/about-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6">
          <div class="detail-box">
            <div class="heading_container">
              <h2>
                Estamos listos!
              </h2>
            </div>
            <p>
              ¿Te gustaría participar de nuestra creciente familia? En AllBulgersNow, estamos en busqueda de nuevos talentos que se sumen a nuestro amplio equipo,
              si te interesa formar parte por favor, envianos un mensaje adjuntando tu Cv, nos comunicaremos con vos!
            </p>
           
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->
  <!-- client section -->

  <section class="client_section pt-5">
    <div class="container">
      <div class="heading_container heading_center psudo_white_primary mb_45">
        <h2>
          Que dicen nuestros clientes
        </h2>
      </div>
      <div class="carousel-wrap row ">
        <div class="owl-carousel client_owl-carousel">
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Moana Michell
                </h6>
                <p>
                  magna aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client1.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="detail-box">
                <p>
                  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam
                </p>
                <h6>
                  Mike Hamell
                </h6>
                <p>
                  magna aliqua
                </p>
              </div>
              <div class="img-box">
                <img src="web/images/client2.jpg" alt="" class="box-img">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <section class="book_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container">
        <h2>
          Trabaja con nosotros!
        </h2>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form_container">
            <form method="POST"  action="" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">  
              <div>
                <input type="text" class="form-control" placeholder="Nombre" name="txtNombre" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Apellido" name="txtApellido" />
              </div>
              <div>
                <input type="text" class="form-control" placeholder="Celular" name="txtCelular" />
              </div>
              <div>
                <input type="email" class="form-control" placeholder="Correo" name="txtEmail" />
              </div>
              <div>
                <textarea name="txtMensaje" id="txtMensaje" class="form-control" placeholder="Mensaje:"></textarea>
              </div>
              <div>
                <label for="archivo" class="d-block">Adjunta tu CV:</label>
                <input type="file" name="archivo" id="archivo" class="">
              </div>
              
              <div class="btn_box text-center">
                <button type="submit">
                  ENVIAR
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end client section -->
@endsection
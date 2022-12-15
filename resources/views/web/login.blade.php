@extends ("web.plantilla")

@section ("contenido")
<section class="book_section layout_padding-bottom">
      <div class="container">
      <div class=" mx-auto mt-5">
      <div class="heading_container">Ingresar</div>
      <div class="card-body">
      
            <form name="fr" class="form_container" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
            <div class="col-6">
                  <label for="txtUsuario">Usuario</label>
                  <input type="text" id="txtUsuario" name="txtUsuario" class="form-control" placeholder="Usuario" required autofocus>
                  
            </div>
            </div>
            <div class="form-group">
            <div class="col-6">
                  <label for="txtClave">Clave</label>
                  <input type="password" id="txtClave" name="txtClave" class="form-control" placeholder="Clave" required>
                  
            </div>
            </div>
            <div class="form-group">
            <div class="checkbox">
                  <label>
                  <input type="checkbox" value="remember-me">
                  Recordar clave
                  </label>
            </div>
            </div>
            <div class="row">
                  <div class="col-4">
                  <button class="btn btn-primary c" type="submit">Entrar</button>
                  </div>
                  <div class="col-4">
                        <a class="" href="/admin/recupero-clave">¿No tienes cuenta? Registrarme</a>
                  </div>
            </div>      
            </form><br>
            <div class=" col-6">
            <a class="d-block small" href="/admin/recupero-clave">Recuperar clave</a>
            </div>
            
      </div>
      </div>
      </div>
</section>



@endsection
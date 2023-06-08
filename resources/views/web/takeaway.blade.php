 @extends('web.plantilla')
 @section('contenido')
   <!-- food section -->

   <section class="food_section layout_padding-bottom">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Take away
        </h2>
        <h3> <!-- mejor forma de poner lo de la variable msg -->
          
          @if(isset($msg) && isset($msg['estado'])) 
              <div class="alert alert-{{ $msg['estado']}}" role="alert">
                  {{$msg["msg"]}}
              </div>
          @endif
        </h3>
      </div>

      <ul class="filters_menu">
        <li class="active" data-filter="*">Todos</li>
        @foreach($aCategorias as $categoria)
          <li data-filter=".{{$categoria->nombre}}"> {{$categoria->nombre}} </li>

        @endforeach 
      </ul>

      <div class="filters-content">
        <div class="row grid">
        @foreach($aProductos as $producto)
          @foreach($aCategorias as $categoria)
              @if($producto->fk_idcategoria == $categoria->idcategoria) 
                <div class="col-sm-6 col-lg-4 all {{$categoria->nombre}}">
              @endif
         @endforeach   
            <div class="box">
              <div>
                <div class="img-box">
                  <img src='/files/{{$producto->imagen}}' alt="">
                </div>
                <div class="detail-box">
                  <h5>
                    {{$producto->nombre}}
                  </h5>
                  
                  <p>
                    {{$producto->descripcion}}
                  </p>
                  <div class="options">
                    <h6>
                      {{$producto->precio . "$"}}
                    </h6>
                    <form action="" method="POST">
                      @csrf
                      <div class="btn selectCant" style="backgroud: #f1f2f3; border-radius: 20px;margin-top: 2px;padding-bottom: 4px;padding-top:4px;">
                        <input type="hidden" name="txtIdProducto" value="{{ $producto->idproducto}}">
                        
                        <input type="number" name="txtCantidadProducto" value="1">
                      </div>
                      <button type="submit"><i class="fa-solid fa-cart-shopping"></i></button>
                    </form>
                  </div>
                </div>
            
              </div>
            </div>
             
          </div>
        @endforeach
        </div>
      </div>
      <div class="btn-box">
        <a href="">
          View More
        </a>
      </div>
    </div>
  </section>

  <!-- end food section -->
@endsection  

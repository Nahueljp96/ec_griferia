@extends ("web.plantilla")

@section ("contenido")
<section class="fodd_section layout_padding carrito">
           
            <div class="container">
            
                  <div class="heading_container heading_center">
                        <h2>Mi Carrito</h2>
                  </div>
                  <!-- mejor forma de poner lo de la variable msg -->
                  @if(session('success'))
                  <div class="alert alert-success">
                        {{ session('success') }}
                  </div>
                  @endif
                  @if(session('error'))
                  <div class="alert alert-danger">
                        {{ session('error') }}
                  </div>
                  @endif

                  @csrf      
            <div class="row">
                        <div class="col-12 my-5">
                              <table class="col-12 my-5">  
                                    <thead>
                                          <tr>
                                                <th class="lead">Imagen</th>
                                                <th class="lead">Producto</th>
                                                <th class="lead">Precio</th>
                                                <th class="lead">Cantidad</th>
                                                <th class="lead">Total</th>
                                          </tr>

                                    </thead>
                                    <tbody>
                                          <?php $total = 0 ?>
                                          <?php #Se agrega el $index para colocarle un indice al bucle foreach y poder eliminar cualquier producto del carrito#?>
                                          @foreach($aCarrito_productos as $indexx => $producto)
                                               
                                              <?php $subtotal = $producto->precioproducto * $producto->cantidad;  ?>
                                              <tr>
                                                  <td><img src="/files/{{ $producto->imagenproducto}}" alt="" width="100" ></td>
                                                  <td>{{$producto->nombreproducto}}</td>    
                                                  <td>${{ number_format($producto->precioproducto, 2, ",", ".")}}</td>    
                                                  <td>{{$producto->cantidad}}</td>    
                                                  <td>{{ number_format($subtotal, 2, ",", ".") }}</td>
                                                  <td>
                                                      <form action="/eliminarProducto" method="POST">
                                                          @csrf
                                                          <input type="hidden" name="producto_id" value="{{$producto->fk_idproducto}}">
                                                          <input type="hidden" name="indexx" value="{{$indexx}}">
                                                          <button type="submit" class="btn btn-danger" id="eliminar-{{ $indexx }}">Eliminar</button>
                                                      </form>
                                                  </td>   
                                              </tr>
                                              
                                              <?php $total += $subtotal; ?>
                                              
                                          @endforeach
                                          
                                    </tbody>
                                      
                              </table>
                              <div class="float-right lead">
                                    <h4>Total: ${{$total}}</h4>
                              </div>
                              
                        </div>
            <form action="" method="POST">
                              @csrf 
                        <div class="col-6">
                              <label for="" class="d-block">Selecciona la sucursal donde retirar el pedido:</label>
                              
                              <select name="lstSucursal" id="lstSucursal" class="form-control">
                              @foreach($aSucursales as $sucursal)
                                    <option value="{{ $sucursal->idsucursal}}">{{ $sucursal->nombre}}</option>
                              </select>
                              @endforeach
                              
                        </div>   
                        <div class="col-6">
                              <label for="" class="d-block">Selecciona el medio de pago:</label>
                              <select name="lstMedioDePago" id="lstMedioDePago" class="form-control">
                                    <option value="mercadopago">Mercado Pago</option>
                                    <option value="sucursal">Pago en sucursal</option>
                              </select>

                        </div> 
                        <div class="col-12">
                              <a href="/takeaway" class="lead">AGREGAR MAS PRODUCTOS</a>
                        </div>
                        <div class="col-12">
                              <button type="submit" class=" float-right btn btn-primary lead"> Finalizar mi pedido </button>
   
                        </div> 
            </form>       
                  
            
            </div>
      
      
</section>



@endsection
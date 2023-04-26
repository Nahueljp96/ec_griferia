@extends ('web.plantilla')
@section('contenido')


     <section> 
            <div class="container">
            
                  <div class="heading_container">
                  
                        <h2 class=" py-5">
                        Mi Cuenta:
                        </h2>
                              @if(isset ($msg))
                                          <div class="alert alert-{{ $msg['estado']}}" role="alert">
                                                {{$msg["msg"]}}
                                          </div>
                              @endif
                        @if (Session::get("idcliente") > 0)
                        <h3 class="pt-3">
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
                        <h4>
                              <div class="pt-5">
                                    <a href="/cambiar-datos" class="order_online ">
                                          Editar Datos
                                          <i class="" aria-hidden="true"></i>
                                    </a>                    
                              </div>      
                              <div class= "pt-2">    
                                    <a href="/cambiar-clave" class="order_online">
                                          Cambiar clave
                                          <i class="" aria-hidden="true"></i>
                                    </a>
                              </div>  
                        </h4>    
                        @else

                        <h3 class="md-10">
                              Por favor, ingrese para ver su cuenta!!
                        </h3>
                        @endif

                        </div>
                  </div>
            </div>
     </section>      
@endsection
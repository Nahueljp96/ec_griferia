@extends ('web.plantilla')

@section('contenido')

      <div class="container">
            <div class="heading_container">
            <h2>
            Trabaja con nosotros!
            </h2>
            </div>
            <div class="row">
            <div class="col-md-6">
            <div class="form_container">

                  <div>
                        @foreach ($aClientes as $cliente)
                        <h5>{{$cliente->nombre}}</h5>
                        @endforeach
                  </div>
                  
                  <button type="submit">
                        ENVIAR
                  </button>
                  
                 
            </div>
            </div>
            </div>
      </div>
@endsection
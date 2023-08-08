@extends('web.plantilla')

@section('contenido')
<section>
    <div class="container">
        <div class="heading_container">
            <h2 class="py-5">Mi Cuenta:</h2>
            @if(isset($msg))
            <div class="alert alert-{{ $msg['estado'] }}" role="alert">
                {{ $msg["msg"] }}
            </div>
            @endif
            <h2>
                <h3 class="pt-3  ">
                    <label for="">Nombre y Apellido:</label>
                    {{ $cliente->nombre ." " . $cliente->apellido }}
                </h3>
                <h3 class="">
                    <label for="">Correo:</label>
                    {{ $cliente->correo }}
                </h3>
                <h3 class="">
                    <label for="">Dni:</label>
                    {{ $cliente->dni }}
                </h3>
                <h3 class="">
                    <label for="">Celular:</label>
                    {{ $cliente->celular }}
                </h3>
                <h3 class="">
                    <label for="">Direccion:</label>
                    {{ $cliente->direccion }}
                </h3>
                <h4>
                    <div class="pt-5">
                        <a href="/cambiar-datos" class="order_online btn btn-warning">
                            Editar Datos
                            <i class="" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="pt-2">
                        <a href="/cambiar-clave" class="order_online btn btn-warning">
                            Cambiar clave
                            <i class="" aria-hidden="true"></i>
                        </a>
                    </div>
                </h4>
            </h2>
        </div>
        <div class="heading_container">
            <div class="card border-light mb-33 col-12">
                <div class="card-body">
                    <div>
                        <h2 class="text-center p-4">Pedidos</h2>
                        <table class="table table-striped table-hover border">
                            <thead>
                                <tr>
                                    <th>Pedido</th>
                                    <th>Fecha</th>
                                    <th>Descripción</th>
                                    <th>Total</th>
                                    <th>Sucursal</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Linea 68, validamos la variable y consultamos que sea un array asi no tira error (en caso que no haya ningun pedido) !-->
                                @if(isset($aPedidos) && is_array($aPedidos))
                                
                                @foreach($aPedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->idpedido }}</td>
                                    <td>{{ date_format(date_create($pedido->fecha), "d/m/Y H:i") }}</td>
                                    <td>{{ $pedido->descripcion }}</td>
                                    <td>{{ number_format($pedido->total, 2, ",", ".") . "$" }}</td>
                                    <td>{{ $pedido->sucursal }}</td>
                                    <td>{{ $pedido->estado }}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

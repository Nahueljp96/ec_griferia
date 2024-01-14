<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boleta</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        p {
            margin-bottom: 10px;
        }
        .info {
            margin-top: 20px;
        }
        .button-container {
            text-align: center;
            margin-top: 20px;
        }
        .generate-button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <h1>Boleta</h1>
    <div class="info">
        <p>ID del Pedido: {{ $pedido->idpedido }}</p>
        <p>Fecha: {{ $pedido->fecha }}</p>
        <p>Descripción: {{ $pedido->descripcion }}</p>
        <p>Total: {{ $pedido->total }}</p>
        <!-- Agrega más detalles según sea necesario -->
    </div>
    <div class="button-container">
        <a class="generate-button" href="{{ route('generar.boleta', ['idPedido' => $pedido->idpedido]) }}">Generar Boleta</a>
    </div>
</body>
</html>

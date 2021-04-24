<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        body{
            font-family: 'Montserrat', sans-serif;
            padding: 20px 0;
        }
        h1{
            text-align: center;
            font-weight: 700;
            padding-top: 1rem;
            padding-bottom: 1rem;
            color: #242526;
        }
        .container{
            width: 95%;
            box-shadow: 10px 10px 28px -3px rgba(0,0,0,0.40);
            -webkit-box-shadow: 10px 10px 28px -3px rgba(0,0,0,0.40);
            -moz-box-shadow: 10px 10px 28px -3px rgba(0,0,0,0.40);
            border-radius: 5px;
            background-color: #eeeeee;
            margin: auto;
            letter-spacing: 1px;
            line-height: 1.6;
        }
        .logo{
            width: 100%;
            margin: auto;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        table{
            width: 100%; 
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
        }
        thead tr{
            background-color: yellowgreen;
        }
        td{
            border-right: 1px solid darkgray;
            text-align: center      ;
        }
        @media only screen and (min-width: 750px) {
            .container {
                width: 80%;
                margin: auto;
            }
            table{
                width: 90%;
                margin: auto;
            }
        }
    </style>
    <title>VenMarket</title>
</head>
<body>
    <div class="container">
        <div class="logo">
            <img src="{{ $message->embed('storage/venmarket-logo.png') }}" style="width: 60%; padding: 10px 10px;">
        </div>
        <h1 class="text-center font-semibold text-lg py-2 text-gray-700">pedido Realizado</h1>
        <p class="py-2 font-semibold text-md">Hola! Su Pedido con VenMarket ha sido procesado correctamente</p>
        <p> le informamos que su pedido <strong>#{{ $buyOrder }}</strong> a nombre de <strong>{{ $datos['c_nombre'] }} {{ $datos['c_email'] }}</strong> el cual sera entregado en el transcurso 
        de las proximas 24 horas a la direccion <strong>{{ $datos['c_direccion'] }} {{ $comuna }}</strong>.</p>
        <div class="py-5">
            <table>
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Articulo</th>
                    <th>Qty</th>
                    <th>Precio</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($order as $item)
                        <tr>
                            <td data-column="#">{{ $loop->index + 1}}</td>
                            <td data-column="Articulo">{{ Str::limit($item['item']->name, 10) }}</td>
                            <td data-column="Qty">{{ $item['qty'] }}</td>
                            <td data-column="Precio">${{ $item['item']->productValue->price }}</td>
                            <td data-column="Total">${{ $item['price'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>
        <p class="font-semibold">Si tiene alguna duda o quiere realizar algun cambio por favor comunicarse a los siguientes numeros o escribenos a nuestro correo. De igual manera si necesitamos comunicarlo, lo
            contactaremos al numero proporcionado{{ $datos['c_telefono'] }}
        </p>
    </div>
</body>
</html>
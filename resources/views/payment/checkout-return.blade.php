
@extends('layouts.app')

@section('title', 'VenMarket  |  Pago')

@section('content')
    @if ($status)
        @if ($status == 'Orden completa')  
            <div class="w-full lg:w-3/5 px-3 border-2 border-gray-200 shadow-lg rounde-lg m-auto">
                <div class="w-full py-3 flex justify-center">
                    <div class="w-1/5">
                        <img src="storage/venmarket-logo.png" class="w-full" alt="">
                    </div>
                </div>
                <p class="text-3xl font-semibold text-yellow-500 text-center py-4">Pedido Realizado</p>
                <p class="py-6 w-full font-semibold text-lg">Su pedido #98437539 se ha realizado correctament, Los detalles de la compra son los siguientes:</p>
                <div class="w-11/12 lg:w-4/5 border-2 border-yellow-500 rounded-lg m-auto">
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between"># PEDIDO:<span>{{ $response->getBuyOrder() }}</span></p>
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">MONTO DE LA TRANSACCION:<span>${{ number_format($response->getAmount()) }}</span></p>
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">CODIGO DE AUTORIZACION:<span>{{ $response->getAuthorizationCode() }}</span></p>
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">FECHA DE LA TRANSACCION: <span>{{ $response->getAccountingDate() }}</span></p>
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">METODO DE PAGO: <span>{{ $response->getPaymentTypeCode() }}</span></p>
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">CANTIDAD DE CUOTAS: <span>{{ $response->getInstallmentsNumber() }}</span></p>
                    <p class="border-b-2 border-yellow-300 mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">MONTO DE CUOTAS: <span>${{ number_format($response->getInstallmentsAmount()) }}</span></p>       
                    <p class="mx-3 py-2 text-sm lg:text-md font-bold text-gray-700 flex justify-between">PRODUCTOS: <span>Abarrotes</span></p>               
                </div>
            </div>
        @else
            <div class="w-full bg-red-500 text-white rounded-md shadow text-center mt-1">
                <p>{{ $status }}</p>
            </div>
            <div class="py-10 w-full lg:w-3/5 bg-white rounded-lg shadow-lg m-auto">
                <p class="text-semibold text-lg text-left">
                    La transaccion ha sido rechazada Las posibles causas de este rechazo son:<br>
                    Error en el ingreso de los datos de su tarjeta de Crédito o Débito (fecha y/o código de seguridad)<br>
                    Su tarjeta de Crédito o Débito no cuenta con saldo suficiente<br>
                    Tarjeta aún no habilitada en el sistema financiero<br>
                </p>
            </div>
        @endif
    @endif
@endsection
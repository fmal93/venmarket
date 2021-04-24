@extends('layouts.app')

@section('title', 'VenMarket  |  Pago')

@section('content')
<div class="w-full h-full py-3">
    <div class="flex justify-center items-center py-4 m-1 px-3">
        <div class="w-full lg:w-3/5 bg-white rounded-lg shadow-lg">
            <div class="w-full py-3 flex justify-center">
                {{-- <img src="{{ asset('storage/settings/logo.png')}}" class="img-responsive w-25" alt=""> --}}
                <div class="w-1/5">
                    <img src="storage/venmarket-logo.png" class="w-full" alt="">
                </div>
            </div>
            <h1 class="text-center p-2 text-lg font-bold" style="letter-spacing: 2px;">REALIZAR PAGO</h1>
            <p class="text-muted"></p>
            @if ($errors->any())
                <div class="w-full bg-red-500 text-white rounded-md shadow text-center mt-1">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="/checkout" method="POST" role="form" id="pay-form">
                @csrf
                <div class="flex flex-col lg:flex-row justify-between items-center pt-4 lg:px-6 pb-2">
                    <div class="w-full lg:w-1/2 flex justify-around py-2">
                        <label for="c_nombre" class="px-1 w-1/5 lg:w-2/5 text-center text-gray-600">Nombre</label>
                        <input type="text" class="w-3/4 lg:w-3/5 bg-gray-50 border-2 text-sm lg:text-md rounded border-yellow-100 p-1 shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-transparent" name="c_nombre" placeholder="Ingreasa tu Nombre completo" required>
                    </div>
                    <div class="w-full lg:w-1/2 flex justify-around py-2">
                        <label for="c_telefono" class="px-1 w-1/5 lg:w-2/5 text-center text-gray-600">Telefono</label>
                        <input type="tel" class="w-3/4 lg:w-3/5 bg-gray-50 border-2 text-sm lg:text-md rounded border-yellow-100 p-1 shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-transparent" name="c_telefono" placeholder="ejemplo +56 9 1234 5678" required>
                    </div>
                </div>
                <div class="flex flex-row justify-around items-center pt-4 lg:px-6 pb-2">
                    <label for="c_email" class="px-1 w-1/5 text-center text-gray-600">Email</label>
                    <input type="email" class="w-3/4 lg:w-4/5 bg-gray-50 border-2 text-sm lg:text-md rounded border-yellow-100 p-1 shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-transparent" name="c_email" placeholder="ejemplo@ejemplo.com" required>
                </div>
                <div class="flex flex-row justify-around items-center pt-4 lg:px-6 pb-2">
                    <label for="c_direccion" class="px-1 w-1/5 text-center text-gray-600">Direccion</label>
                    <input type="text" class="w-3/4 lg:w-4/5 bg-gray-50 border-2 text-sm lg:text-md rounded border-yellow-100 p-1 shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:border-transparent" name="c_direccion" placeholder="Ingreasa tu Direccion de envio" required>
                </div>
                <select-comuna total="{{ $total }}"></select-comuna>
                <button type="submit" id="submit-payment" class="block m-auto my-10 hover:text-gray-200 py-2 w-3/5 lg:w-2/6 rounded-md shadow-md font-bold bg-yellow-400">Avanzar </button>                   
            </form>
        </div>
    </div>
</div>
@endsection
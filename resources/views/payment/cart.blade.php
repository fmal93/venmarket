
@extends('layouts.app')

@section('title', 'VenMarket  |  Carrito')

@section('content')
    @if (session('status'))
        @if (session('status') == 'cupon aplicado correctamente')  
            <div class="w-full bg-green-500 rounded shadow-lg text-white text-center mt-1">
                {{ session('status') }}
            </div>
        @else
            <div class="w-full bg-red-500 text-white rounded-md shadow text-center mt-1">
                {{ session('status') }}
            </div>
        @endif
    @endif
    @if (Session::has('cart'))
        <div class="p-2 m-auto w-full flex justify-around flex-col lg:flex-row py-10">
            <div class="w-full lg:w-3/5 border-2 border-gray-300 shadow-lg rounded-lg bg-white h-full order-2 lg:order-1">
                <div class="w-full flex justify-center py-5">
                    <img src="storage/venmarket-logo.png" class="w-1/5" alt="">
                </div>
                <h3 class="font-light text-center text-gray-500"><em>Tienes {{ Session::has('cart') ? Session::get('cart')->totalQty : '0' }} articulo en el carrito!!</em></h3>
                    <div class="flex w-full flex-shrink-0 flex-wrap">
                        
                        @foreach ($products as $product)
                            <div class="w-1/5 flex-shrink-0">
                                <a href="/product/{{ $product['item']['slug']}}">
                                    <img src="/storage/{{ $product['item']['productImage']['img_url'] }}" class="w-full" alt="">
                                </a>
                            </div>
                            <div class="w-3/5 lg:w-1/5 flex flex-shrink-0 items-center">
                                <a href="/product/{{ $product['item']['slug']}}">
                                    <p class="m-2 text-blue-600 underline lg:text-lg">{{ $product['item']['name'] }}</p>
                                </a>
                            </div>
                            <div class="w-1/5 flex flex-col flex-shrink-0 justify-center items-center">
                                <p class="text-center font-light text-md lg:text-xl">Precio</p>
                                <p class="font-bold text-green-500 lg:text-xl">${{ number_format($product['item']['productValue']['price'])}}</p>
                            </div>
                            <div class="w-full lg:w-2/5 flex items-center justify-around flex-shrink-0">
                                <form action="/update-cart" method="GET" class="p-1 flex justify-around w-3/5">
                                    <input type="hidden" name="id" value="{{$product['item']['id']}}">
                                    <input type="number" name="qty" value="{{ $product['qty']}}" min="0" max="" class="w-2/5 text-center p-1 ring-1 ring-yellow-400 rounded-lg shadow-lg">
                                    <button type="submit" formaction="/update-cart" class="text-md font-bold bg-yellow-400 py-1 px-2 rounded-lg shadow-lg">Actualizar</button> 
                                </form>
                                <div class="w-2/5 flex justify-center p-2">
                                    <a href="/remove/{{ $product['item']['id'] }}">
                                        <svg class="w-6 h-6 lg:w-8 lg:h-8 stroke-current text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    
                </div>
            </div>
            <div class="w-full order-1 lg:order-2 lg:w-1/4 p-2 my-2 border-gray-300 border-2 shadow-lg rounded bg-white flex justify-center flex-col">
                <h1 class="w-full text-center py-5 font-bold text-2xl underline"><em>Resumen del Pedido</em></h1>
                <div class="w-full border-2 rounded-lg">
                    <div class="w-full text-sm flex justify-center px-5 font-bold py-4">
                        <p class="w-4/6 border-r-2 border-l-2 mr-1 border-gray-600 font-bold">Articulo</p>
                        <p class="w-1/6 border-r-2 mr-1 border-gray-600 font-bold">Qty</p>
                        <p class="w-1/6">Precio</p>
                    </div>
                    @foreach ($products as $product)
                    <div class="w-full text-sm flex justify-center px-5 py-2">
                        <p class="w-4/6 font-light">{{Str::limit($product['item']['name'], 25)}}</p>
                        <p class="w-1/6 text-center mr-1 font-bold">{{$product['qty']}}</p>
                        <p class="w-1/6 text-center text-green-500 mr-1 ">{{number_format($product['price'])}}</p>
                    </div>
                    @endforeach
                </div> 
                <p class="text-center py-10 p-3 font-bold text-xl text-black">Subtotal: &#36; {{ number_format(Session::has('cart') ? (Session::get('cart')->totalPrice) : '0')}}</p>
                <div class="w-full flex justify-center">
                    <a href="/checkout-form" class="block-w-3/5 text-center bg-yellow-400 rounded py-1 px-3 mb-2 shadow-md text-black font-bold">HACER PEDIDO</a>
                </div> 
            </div>
        </div>
    @else
        <div class="w-full lg:w-3/5 m-auto mt-5 bg-red-500 text-white rounded-md shadow text-center mt-1">
            Carro Vacio
        </div>
    @endif
@endsection
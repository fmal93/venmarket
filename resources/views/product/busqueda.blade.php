@extends('layouts.app')

@section('title', 'VenMarket  |  Busqueda')

@section('content')
    <div class="w-full py-3 flex flex-wrap h-full text-black font-bold">
        @foreach ($products as $product)
            <div class="w-1/2 md:w-1/5 hover:shadow-2xl py-2 rounde-md bg-white">
                <div class="w-4/5 mx-auto flex h-36 lg:h-56">
                    <a href="product/{{ $product->slug}}">
                        <img src="/storage/{{ $product->productImage->img_url}}" class="w-full" alt="{{ $product->name }}">
                    </a>
                </div>
                <a href="product/{{ $product->slug}}" class="w-4/5 m-auto block">
                    <p class="w-full text-black hover:text-yellow-400 leading-tight h-20 lg:h-12 tracking-wider">{{ $product->name}}</p>
                </a>
                <div class="w-4/5 m-auto block">
                    <p class="w-4/5 text-black leading-tight font-light">{{ $product->brand->name }}  {{ $product->productValue->detail }}</p>
                </div>
                <p class="w-full text-center text-black text-xl py-3 tracking-wider">&#36;{{ $product->productValue->price }}</p>
                <a href="/add-to-cart/{{ $product->id }}" class="w-4/5 rounded-md p-1 m-auto block text-center bg-yellow-400 cursor-pointer hover:text-white tracking-wider">Agregar</a>                
            </div>
        @endforeach
    </div>
    
@endsection
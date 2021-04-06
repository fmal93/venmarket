@extends('layouts.app')

@section('title', $product->name )

@section('content')
    <div class="w-full lg:flex lg:flex-row flex-col">
        <div class="w-full flex-shrink-0 lg:w-1/2 h-full">
            <div class="w-4/5 m-auto">
                <img src="/storage/{{ $product->productImage->img_url}}" alt="">
            </div>
        </div>
        <div class="w-full flex-shrink-0 lg:w-1/2 m-auto">
            <div class="w-full m-auto">
                <p class="text-2xl p-4 tracking-widest">{{ $product->name }}</p>
                <p class="text-lg p-4 font-light tracking-widest">{{ Str::upper($product->brand->name) }} - {{ $product->productValue->detail }}</p>
                <p class="text-2xl p-4 font-bold text-center tracking-widest">${{ $product->productValue->price}}</p>
            </div>
            <div class="m-auto w-full">
                <a href="/add-to-cart/{{ $product->id }}" class="block m-auto text-center p-3 tracking-widest rounded-md shadow-md text-extrabold text-sm w-4/5 bg-yellow-400">AGREGAR</a>
            </div>
        </div>
    </div>    
@endsection
 
@extends('layouts.app')

@section('title', $product->name )

@section('content')
    <div class="lg:flex lg:flex-wrap">
        <div class="w-full flex-shrink-0 lg:w-1/2 h-full">
            <div class="w-4/5 m-auto shadow-lg">
                <img src="/storage/{{ $product->productImage->img_url}}" alt="" class="lg:w-full w-auto">
            </div>
        </div>
        <div class="w-full lg:w-1/2">
            <div class="lg:fixed lg:w-1/2 lg:my-8">
                <div class="w-full lg:w-2/3 px-4">
                    <p class="text-2xl lg:text-4xl font-bold p-4 lg:py-8 tracking-widest">{{ $product->name }}</p>
                    <p class="text-lg p-4 font-light text-yellow-500 lg:py-4 font-bold tracking-widest">{{ Str::upper($product->brand->name) }} - {{ $product->productValue->detail }}</p>
                    <p class="text-4xl p-4 lg:py-4 font-bold tracking-widest">${{ $product->productValue->price}}</p>
                </div>
                <div class="w-full lg:w-2/6 hover:text-white">
                    @if ( $product->productValue->productStock->stock > 0)
                        <a href="/add-to-cart/{{ $product->id }}" class="block m-auto text-center p-3 tracking-widest rounded-md shadow-md text-extrabold text-sm w-full bg-yellow-400"><span class="flex p-2 justify-around"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>Agragar al carro</span></a>
                    @else
                        <p class="block m-auto text-center p-3 tracking-widest rounded-md shadow-md text-extrabold text-sm w-4/5 bg-yellow-400 opacity-50"><span class="flex p-2 justify-around"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>Agotado</span></a>        
                    @endif  
                    
                </div>
            </div>
        </div>
        <div class="w-full flex-shrink-0 lg:w-1/2 h-full mb-4">
            <p class="text-2xl font-bold text-gray-800 p-4 lg:pl-16 lg:pt-16">Descripcion</p>
            <p class="text-2xl font-bold text-gray-800 p-4 lg:pl-16 lg:pt-8 tracking-widest">{{ $product->description }}</p>
            @if (isset( $product->productValue->nutritional_info ))
                <p class="text-lg font-bold text-gray-800 p-4 lg:pl-16 lg:pt-8 tracking-widest">Informacion Nutricional</p>
                <div class="w-11/12 border m-auto">
                    <div class="w-full border border-black">
                        <p class="px-2">Porción: {{ $product->productValue->nutritional_info->portion }}</p>
                        <p class="px-2">Porciones por envase: {{ $product->productValue->nutritional_info->portions_per_pack }}</p>
                    </div>
                    <div class="w-full border-r border-l border-black h-auto flex">
                        <div class="w-4/5 border-r border-b-4 border-black h-auto"></div>
                        <div class="w-1/5 border-b-4 border-black h-full text-right px-3">100g</div>
                    </div>
                    <div class="w-full border-r border-l border-b border-black flex">
                        <div class="w-4/5 border-r border-black h-full p-1">
                            <p class="px-2">Energía (kCal)</p>
                        </div>
                        <div class="w-1/5 border-black h-full">
                            <p class="text-right px-3">{{ $product->productValue->nutritional_info->calories }}</p>
                        </div>
                    </div>
                    <div class="w-full border-r border-l border-b border-black flex">
                        <div class="w-4/5 border-r border-black h-full p-1">
                            <p class="px-2">Proteínas (g)</p>
                        </div>
                        <div class="w-1/5 border-black h-full">
                            <p class="text-right px-3">{{ $product->productValue->nutritional_info->proteins }}</p>
                        </div>
                    </div>
                    <div class="w-full border-r border-l border-b border-black flex">
                        <div class="w-4/5 border-r border-black h-full p-1">
                            <p class="px-2">Grasas Totales (g)</p>
                        </div>
                        <div class="w-1/5 border-black h-full">
                            <p class="text-right px-3">{{ $product->productValue->nutritional_info->fats }}</p>
                        </div>
                    </div>
                    <div class="w-full border-r border-l border-b border-black flex">
                        <div class="w-4/5 border-r border-black h-full p-1">
                            <p class="px-2 text-sm lg:text-base">Hidratos de carbono disponibles (g)</p>
                        </div>
                        <div class="w-1/5 border-black h-full">
                            <p class="text-right px-3">{{ $product->productValue->nutritional_info->carbs }}</p>
                        </div>
                    </div>
                    <div class="w-full border-r border-l border-b border-black flex">
                        <div class="w-4/5 border-r border-black h-full p-1">
                            <p class="px-2">Azúcares totales (g)</p>
                        </div>
                        <div class="w-1/5 border-black h-full">
                            <p class="text-right px-3">{{ $product->productValue->nutritional_info->sugar }}</p>
                        </div>
                    </div>
                    <div class="w-full border-r border-l border-b border-black flex">
                        <div class="w-4/5 border-r border-black h-full p-1">
                            <p class="px-2">Sodio (mg)</p>
                        </div>
                        <div class="w-1/5 border-black h-full">
                            <p class="text-right px-3">{{ $product->productValue->nutritional_info->sodium }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>    
@endsection
 
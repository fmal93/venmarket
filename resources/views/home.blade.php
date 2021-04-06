
@extends('layouts.app')

@section('title', 'VenMarket  |  Inicio')

@section('content')
     <!-- Swiper -->
    <div class="swiper-container swiper-1">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <img src="storage/various-pantry-products-copy-space.jpg">
            </div>
            <div class="swiper-slide">
                <img src="storage/front-view-pantry-food-ingredients.jpg">
            </div>
            <div class="swiper-slide">
                <img src="storage/milk-products-on-white-table-with-copyspace.jpg">
            </div>
            <div class="swiper-slide">
                <img src="storage/delicious-pieces-of-cheese.jpg">
            </div>
            <div class="swiper-slide">
                <img src="storage/different-vegetables-in-textile-bag-on-beige.jpg">
            </div>
        </div>
        <!-- Add Arrows -->
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <div class="w-full flex items-center justify-center pt-10 px-3 lg:px-5">
        <div class="py-2 w-full border-2 border-gray-400 shadow-lg rounded-md flex">
            <div class="w-1/3 lg:flex hidden">
                <img src="storage/various-pantry-products-copy-space.jpg" class="w-full" alt="pantry">
            </div>
            <div class="w-full lg:w-4/5 h-48 lg:h-auto">
                <div class="swiper-container swiper-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">slide 1</div>
                        <div class="swiper-slide">slide 2</div>
                        <div class="swiper-slide">slide 3</div>
                        <div class="swiper-slide">slide 4</div>
                        <div class="swiper-slide">slide 5</div>
                        <div class="swiper-slide">slide 6</div>
                        <div class="swiper-slide">slide 7</div>
                        <div class="swiper-slide">slide 8</div>
                        <div class="swiper-slide">slide 9</div>

                    </div>
                    <!-- Add Pagination -->
                </div>
            </div>
        </div>
    </div>

    <div class="w-full flex items-center justify-center py-3 px-3 lg:px-5">
        <div class="py-2 w-full border-2 border-gray-400 shadow-lg rounded-md flex">
            <div class="w-full lg:w-4/5 h-48 lg:h-auto">
                <div class="swiper-container swiper-2">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">slide 1</div>
                        <div class="swiper-slide">slide 2</div>
                        <div class="swiper-slide">slide 3</div>
                        <div class="swiper-slide">slide 4</div>
                        <div class="swiper-slide">slide 5</div>
                        <div class="swiper-slide">slide 6</div>
                        <div class="swiper-slide">slide 7</div>
                        <div class="swiper-slide">slide 8</div>
                        <div class="swiper-slide">slide 9</div>

                    </div>
                    <!-- Add Pagination -->
                </div>
            </div>
            <div class="w-1/3 lg:flex hidden">
                <img src="storage/various-pantry-products-copy-space.jpg" class="w-full" alt="pantry">
            </div>
        </div>
    </div>
@endsection
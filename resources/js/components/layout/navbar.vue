<template>
    <div class="flex justify-between flex-wrap bg-white bg-opacity-75 text-black font-extrabold p-2 sticky top-0 z-30 pt-5">
        <div class="order-3 lg:order-1 w-full lg:w-1/12 flex justify-center items-start lg:py-0 py-1">
            <img src="/storage/venmarket-logo.png" class="w-1/2 lg:w-full" alt="logo">
        </div>
        <transition name="fade">
            <div class="order-4 lg:order-2 w-full lg:w-2/5 pb-3" v-show="isOpen == true">
            
                <ul class="px-5 lg:flex lg:justify-between">
                    <li class="tracking-wider hover:text-yellow-300"><a href="/"><em>Inicio</em></a></li>
                    <li class="tracking-wider lg:relative" @mouseenter="isOpenPro = true" @mouseleave="isOpenPro = false">
                        <div class="cursor-pointer hover:text-yellow-300 w-full" @touchstart="isOpenPro = !isOpenPro"><em>Productos</em></div>
                        <div class="flex justify-center py-3 lg:absolute lg:bg-white rounded border-t-2 lg:border-2 border-gray-300" v-show="isOpenPro == true">
                            <ul class="w-4/5 lg:w-full lg:px-10 lg:pb-5">
                                <li class="w-full hover:text-yellow-300 py-1 lg:py-2" v-for="category in categories" v-bind:key="category.id">
                                    <a v-bind:href="'/product/categoria/'+ category.id"><em>{{ category.name }}</em></a>
                                </li>
                                <hr>
                                <li class="w-full hover:text-yellow-300 py-1 lg:py-2">
                                    <a href="/product"><em>Ver todo</em></a>
                                </li>
                            </ul>
                       </div>
                    </li>
                    <li class="tracking-wider hover:text-yellow-300"><a href="/carrito"><em>Carrito</em></a></li>
                    <li class="tracking-wider hover:text-yellow-300"><a href="#"><em>Contactanos</em></a></li>
                </ul>
            </div>
        </transition>
        <div class="order-1 lg:order-3 w-4/5 lg:w-2/5">
            <form action="/busqueda" method="GET" class="w-full flex items-center justify-between">
                <input type="text" name="keyword" required class="w-full rounded shadow-md bg-gray-300 px-4 text-gray-600 ring-1">
                <button type="submit" class="px-2 hover:text-yellow-300 bg-transparent border-0 ring-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
        <div class="order-2 lg:order-4 w-1/6 lg:w-1/12 flex">
            <a href="/carrito" class="relative cursor-pointer">
                <svg class="w-6 h-6 mx-1 hover:text-yellow-300 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <div class="badge absolute rounded-full h-3 w-3 lg:h-4 lg:w-4 bg-black"><span class="badge-text absolute text-white text-xs">{{ badge }}</span></div>
            </a>
            
            <svg class="w-6 h-6 mx-1 lg:hidden hover:text-yellow-300 cursor-pointer" @touchstart="isOpen = !isOpen" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"></path>
            </svg>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isOpenPro: false,
            isOpen: screen.width < 1000 ? false:true,
            categories: [],
        }
    },
    props: ['badge'],
    mounted(){
        window.addEventListener('resize', this.onResize);
        this.loadCategories();
    },

    beforeDestroy() {
        // Unregister the event listener before destroying this Vue instance
        window.removeEventListener('resize', this.onResize)
    },

    computed: {
        
    },

    methods: {
        onResize(event) {
            if (screen.width > 1000) return this.isOpen = true;
            this.isOpen = false;     
        },
        loadCategories: function () {
            axios.get('/api/categories', {
                params: _.omit(this.selected, 'categories')
            })
            .then((response) => {
                this.categories = response.data.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
    },

    watch: {
    
    },
};
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
    .badge{
        left: 50%;
        top: -13%
    }
    .badge-text{
        left: 22%;
        top: -25%
    }
    @media only screen and (min-width: 600px) {
        .slider-container {
            height: 600px;
        }
        .badge-text{
            left: 33%;
            top: -7%
        }
    }
</style>

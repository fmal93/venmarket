<template>
    <div class="lg:mx-5">
        <div class="w-full block lg:flex lg:justify-around pt-3 lg:pt-6 px-3">
            <div class="w-full lg:w-1/4 relative" @mouseleave="cat_dropdown = false" v-show="showCatTabProp == true">
                <div class="flex z-0 justify-between w-full bg-yellow-400 text-black font-bold text-center mb-1 items-center rounded-lg py-1 cursor-pointer hover:text-gray-200" @touchstart="cat_dropdown = !cat_dropdown" @mouseenter="cat_dropdown = true">
                    <p class="ml-5">Categorias</p>
                    <svg class="w-4 h-4 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
                <div class="w-full rounded-lg absolute z-10 bg-gray-100 h-56 border-2 overflow-auto" v-show="cat_dropdown == true">
                    <div class="w-4/5 m-auto relative">
                        <ul class="p-2 w-full">
                            <li v-for="(category, index) in categories" v-bind:key="category.id">
                                <input type="checkbox" :value="category.id" :id="'category'+index" v-model="selected.categories">
                                <label :for="'category'+index">
                                    <span class="text-md lg:text-lg px-3">{{ category.name }} ({{ category.products_count }})</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/4 relative" @mouseleave="marcas_dropdown = false">
                <div class="flex z-0 justify-between w-full bg-yellow-400 text-black font-bold text-center mb-1 items-center rounded-lg py-1 cursor-pointer hover:text-gray-200" @mouseenter="marcas_dropdown = true" @touchstart="marcas_dropdown = !marcas_dropdown">
                    <p class="ml-5">Marcas</p>
                    <svg class="w-4 h-4 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
                <div class="w-full bg-gray-100 h-56 overflow-auto rounded-lg absolute z-10" v-show="marcas_dropdown == true">
                    <div class="w-4/5 m-auto">
                        <ul class="p-2 w-full"> 
                            <li v-for="(brand, index) in brands" v-bind:key="brand.id">
                                <input type="checkbox" :value="brand.id" :id="'brand-'+ index" v-model="selected.brands" v-show="brand.products_count > 0">
                                <label :for="'brand-'+ index" v-show="brand.products_count > 0">
                                    <span class="text-md lg:text-lg px-3">{{ brand.name }} ({{ brand.products_count }})</span>
                                </label>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/4 relative" @mouseleave="subcat_dropdown = false">
                <div class="flex z-0 justify-between w-full bg-yellow-400 text-black font-bold text-center pb-1 items-center rounded-lg py-1 cursor-pointer hover:text-gray-200" @touchstart="subcat_dropdown = !subcat_dropdown" @mouseenter="subcat_dropdown = true">
                    <p class="ml-5">SubCategorias</p>
                    <svg class="w-4 h-4 mr-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
                <div class="w-full bg-gray-100 h-56 overflow-auto rounded-lg absolute z-10" v-show="subcat_dropdown == true">
                    <div class="w-4/5 m-auto">
                        <ul class="p-2 w-full">
                            <li v-for="(type, index) in types" v-bind:key="type.id">
                                <input type="checkbox" :value="type.id" :id="'type'+index" v-model="selected.subcategories" v-show="type.products_count > 0">
                                <label :for="'type'+index" v-show="type.products_count > 0">
                                    <span class="text-md lg:text-lg px-3">{{ type.name }} ({{ type.products_count }})</span>
                                </label>
                            </li>
                        </ul>
                    </div>   
                </div>
            </div>
        </div>
        <div class="loader" v-if="loading == true">Loading...</div>
        <div class="w-full py-3 flex flex-wrap h-full text-black font-bold">
            <div class="w-1/2 md:w-1/5 hover:shadow-2xl py-2 rounde-md bg-white" v-for="product in products" v-bind:key="product.id">
                <div class="w-4/5 mx-auto flex h-36 lg:h-56">
                    <a :href="'/product/' + product.slug">
                        <img :src="'/storage/' + product.img_url" class="w-full" :alt="product.name">
                    </a>
                </div>
                <a :href="'product/' + product.slug" class="w-4/5 m-auto block">
                    <p class="w-full text-black hover:text-yellow-400 leading-tight h-20 lg:h-12 tracking-wider">{{ product.name | truncate(50, '...') }}</p>
                </a>
                <div href="#" class="w-4/5 m-auto block">
                    <p class="w-4/5 text-black leading-tight font-light">{{ product.brand + ' ' + product.product_value }}</p>
                </div>
                <p class="w-full text-center text-black text-xl py-3 tracking-wider">&#36;{{ product.price }}</p>
                <a :href="'/add-to-cart/' + product.id" class="w-4/5 rounded-md p-1 m-auto block text-center bg-yellow-400 cursor-pointer hover:text-white tracking-wider">Agregar</a>                
            </div>
        </div>
        <ul class="w-full flex justify-center">
            <div class="bg-yellow-4 flex justify-center">
                <li class="border-2 bg-yellow-400 px-2 rounded shadow-md text-black">
                    <a :disabled="!links.prev" :class="[{'opacity-50 cursor-not-allowed': !links.prev}]" href="" @click.prevent="loadPagination(links.prev), scrollToTop()">prev</a>
                </li>
                <li v-show=" n != pagination.current_page" class="border-2 bg-yellow-400 px-2 rounded shadow-md text-black" v-for="n in pagination.last_page" v-bind:key="n">
                    <a class="" href="" @click.prevent="loadPagination('/api/products?page=' + n +''), scrollToTop()">{{n}}</a>
                </li>
                <li class="border-2 bg-yellow-400 px-2 rounded shadow-md text-black">
                    <a href="" :disabled="!links.next" :class="[{'opacity-50 cursor-not-allowed': !links.next}]" @click.prevent="loadPagination(links.next), scrollToTop()" >Next</a>
                </li>
            </div>
            
        </ul>
    </div>       
</template>
<script>
    export default {
        
        data(){
            return {
                loading: true,
                cat_dropdown: false,
                marcas_dropdown: false,
                subcat_dropdown: false,
                categories: [],
                brands: [],
                types: [],
                products: [],
                selected: {
                    categories: this.catIds,
                    subcategories: [],
                    brands: []                    
                },
                product_id: '',
                pagination: {},
                links: {}
            }
        },
        props: {
            showCatTabProp: Boolean,
            catIds: Array,
        },
        methods: {
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
            loadProducts: function () {
                axios.get('/api/products', {
                    params: this.selected
                })
                .then((response) => {
                    this.products = response.data.data;
                    this.pagination = response.data.meta;
                    this.links = response.data.links;
                    this.loading = false;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadBrands: function () {
                axios.get('/api/brands', {
                    params: _.omit(this.selected, 'brands')
                })
                .then((response) => {
                    this.brands = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadTypes: function () {
                axios.get('/api/subcategories', {
                    params: _.omit(this.selected, 'subcategories')
                })
                .then((response) => {
                    this.types = response.data.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            loadPagination(link){
                axios.get(link, {
                    params: this.selected
                })
                .then((response) => {
                    this.products = response.data.data;
                    this.pagination = response.data.meta;
                    this.links = response.data.links;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            scrollToTop() {
                window.scrollTo(0,0);
            }
        },
        mounted() {
            this.loadCategories();
            this.loadBrands();
            this.loadTypes();
            this.loadProducts();
        },
        watch: {
            selected: {
                handler: function () {
                    this.loading = true,
                    this.cat_dropdown = false,
                    this.marcas_dropdown = false,
                    this.subcat_dropdown = false,
                    this.loadCategories();
                    this.loadBrands();
                    this.loadTypes();
                    this.loadProducts();
                },
                deep: true
            },
        },
        filters: {
            truncate: function (text, length, suffix) {
                if (text.length > length) {
                    return text.substring(0, length) + suffix;
                } else {
                    return text;
                }
            },
        },
    }    
</script>

<style scoped>
.loader,
.loader:after {
  border-radius: 50%;
  width: 10em;
  height: 10em;
}
.loader {
  margin: 60px auto;
  font-size: 10px;
  position: relative;
  text-indent: -9999em;
  border-top: 1.1em solid rgba(255, 165, 0, 0.5);
  border-right: 1.1em solid rgba(255, 165, 0, 0.5);
  border-bottom: 1.1em solid rgba(255, 165, 0, 0.5);
  border-left: 1.1em solid #ffffff;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
  -webkit-animation: load8 1.1s infinite linear;
  animation: load8 1.1s infinite linear;
}
@-webkit-keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load8 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
</style>
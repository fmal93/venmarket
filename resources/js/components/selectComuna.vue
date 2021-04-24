<template>
    <div>
        <div class="flex flex-col lg:flex-row justify-between items-center pt-4 lg:px-6 pb-2">
            <div class="w-full lg:w-1/2 flex justify-center py-2">
                <label for="c_region" class="px-1 w-1/5 lg:w-2/5 text-center text-gray-600">Region</label>
                <div class="inline-block relative w-64">
                    <select id="inputState" name="c_region" v-model="selected" class="block appearance-none w-full bg-white border border-yellow-100 curosor-pointer hover:border-yellow-500 px-4 py-1 pr-8 rounded shadow-lg leading-tight focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:shadow-outline">
                        <option selected disabled>Selecciona tu Comuna</option>
                        <option class="font-bold text-black italic" v-for="region in regions" v-bind:key="region.id" v-bind:value="region.id">{{ region.name }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <div class="w-full lg:w-1/2 flex justify-center py-2">
                <label for="c_comuna" class="px-1 w-1/5 lg:w-2/5 text-center text-gray-600">Comuna</label>
                <div class="inline-block relative w-64">
                    <select id="inputState" name="c_comuna" v-model="comunaSelected" class="block appearance-none w-full bg-white border border-yellow-100 curosor-pointer hover:border-yellow-500 px-4 py-1 pr-8 rounded shadow-lg leading-tight focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:shadow-outline">
                        <option selected disabled>Selecciona tu Comuna</option>
                        <option class="font-bold text-black italic" v-for="comuna in comunas" v-bind:key="comuna.id" v-bind:value="comuna.id">{{ comuna.name }}</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex justify-around px-2 py-4">
            <div class="w-1/3 flex flex-col items-center py-1">
                <p class="w-4/5 text-center border-b-2 border-gray-200 py-1 lg:text-lg text-gray-600">Sub-Total</p>
                <p class="w-1/2 text-center my-3 text-green-500 font-bold text-lg">${{ total }}</p>
            </div>
            <div class="w-1/3 flex flex-col items-center py-1">
                <p class="w-4/5 text-center border-b-2 border-gray-200 py-1 lg:text-lg text-gray-600">Envio</p>
                <p class="w-1/2 text-center my-3 text-green-500 font-bold text-lg">${{ envio }}</p>
            </div>
            <div class="w-1/3 flex flex-col items-center py-1">
                <p class="w-4/5 text-center border-b-2 border-gray-200 py-1 lg:text-lg text-gray-600">Total</p>
                <p class="w-1/2 text-center my-3 text-green-500 font-bold text-lg">${{ Number(total) + Number(envio) }}</p>
            </div>
        </div>
        <input type="hidden" name="c_amount" v-bind:value="Number(total) + Number(envio)">
    </div>
</template>

<script>
export default {
    data() {
        return {
            regions: [],
            comunas: [],
            envio: 0,
            selected: '',
            comunaSelected: '',
        }
    },
    props: ['total'],
    methods: {
        loadRegiones: function() {
            axios.get('/api/regions').then((response) => {
                this.comunas = '';
                this.regions = response.data.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        loadComunas(id) {
            axios.get('/api/comuna/'+ id).then((response) => {
                this.comunas = response.data.data;
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        actualizarEnvio(id) {
            this.envio = 0;
            axios.get('/api/comunas/'+ id).then((response) => {
                this.envio = response.data.data.shipping;
            })
            .catch(function (error) {
                console.log(error);
            });
        }
    },
    mounted() {
        this.loadRegiones();
    },
    watch: {
        selected: {
            handler: function () {
                this.loadComunas(this.selected);
            },
            deep: true
        },
        comunaSelected: {
            handler: function () {
                this.actualizarEnvio(this.selected);
            }
        }
    },
}
</script>

<style>
    .btndisabled{
        cursor: default;
        opacity: 50%;
    }
</style>
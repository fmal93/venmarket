<template>
    <div class="slider-container bg-black bg-opacity-50 flex ">
        <div class="w-full flex-shrink-0 h-full relative">
            <div class="absolute w-full h-full">
                <img :src="'/storage/' + images[index] " class="h-full w-full" alt="">
            </div>
            <div class="absolute h-full left-0 px-3 flex items-center cursor-pointer">
                <div class="p-3 bg-yellow-400 bg-opacity-25 rounded-full hover:bg-opacity-100" @click="prevImg()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path>
                    </svg>
                </div>
            </div>
            <div class="absolute h-full right-0 px-3 flex items-center cursor-pointer">
                <div class="p-3 bg-yellow-400 bg-opacity-25 rounded-full hover:bg-opacity-100" @click="nextImg()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>
        </div>        
    </div>
</template>

<script>
export default {
    data() {
        return {
            images: [
                'banner.png',
                'banner3.png',
            ],
            index: 0,
        }
    },

    mounted(){
        setInterval(this.nextImg, 5000)
    },

    methods: {
        nextImg(){
            if (this.index >= (this.images.length - 1)){
                this.index = 0
            }else {
                this.index += 1
            }
        },
        prevImg(){
           if (this.index <= 0){
                this.index = this.images.length - 1
            }else {
                this.index -= 1
            }
        },
    },

    watch: {
        
    },
}
</script>

<style scoped>
    .slider-container{
        height: 200px;
    }

    @media only screen and (min-width: 600px) {
        .slider-container {
            height: 600px;
        }
    }
</style>
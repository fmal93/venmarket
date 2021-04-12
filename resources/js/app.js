require('./bootstrap');

import Swiper from 'swiper/bundle';
// import Swiper styles
import 'swiper/swiper-bundle.css';

window.Vue = require('vue').default;

Vue.component('layout-navbar', require('./components/layout/navbar.vue').default)
Vue.component('img-slider', require('./components/imageSlider.vue').default)
Vue.component('shop-index', require('./components/productShopComponent.vue').default)

const app = new Vue({
    el: '#app'
});

const swiper1 = new Swiper('.swiper-1', {
  slidesPerView: 1,
  spaceBetween: 30,
  loop: true,
  lazy: true,
  autoplay: {
      delay: 2500,
      disableOnInteraction: false,
  },
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});

const swiper2 = new Swiper('.swiper-2', {
  slidesPerView: 2,
  spaceBetween: 0,
  freeMode: true,
  lazy: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  },
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
  },
  breakpoints: {
    640: {
      slidesPerView: 3,
      spaceBetween: 10,
    },
    768: {
      slidesPerView: 5,
      spaceBetween: 40,
    },
  }
});


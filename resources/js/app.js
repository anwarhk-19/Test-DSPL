import Vue from 'vue';

Vue.component('dialer', require('./components/Dialer.vue').default);

const app = new Vue({
    el: '#app',
});

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
window.Swal=Swal
import VueRouter from 'vue-router';
import Swal from 'sweetalert2'
import Vue from 'vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Vuetify from '../plugins/vuetify'
import store from './vuex';
import Multiselect from 'vue-multiselect'

// Vue.use(IconsPlugin)

export const eventBus = new Vue();
 Vue.use(VueRouter)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('adminpanel-component',require('./components/adminpanel/adminpanelComponent').default);
Vue.component('pagination',require('laravel-vue-pagination'));
Vue.component('userpanel-component',require('./components/userpanel/userPanelComponent').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 * 
 */
import routes from './routefolder/mangaroute'
 const router=new VueRouter({
    mode:'history',
    routes
    
  })
const app = new Vue({
    el: '#app',
    router,
    vuetify:Vuetify,
    store,
   
});

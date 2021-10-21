/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all')
window.Vue = require('vue');

Vue.config.debug = true;
Vue.config.devtools = true;
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
import VueConfirmDialog from 'vue-confirm-dialog';
import VueSweetalert2 from 'vue-sweetalert2';
// import '@sweetalert2/theme-bootstrap-4/bootstrap-4.css';
import 'animate.css';
import 'sweetalert2/src/sweetalert2.scss'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import InfiniteLoading from 'vue-infinite-loading';

global.jQuery = require('jquery');
var $ = global.jQuery;
window.$ = $;


const loading_options = {
    backgroundColor: '#000000',
    color: '#ffffff',
};


const swal_options = {
    showClass: {
        popup: 'animate__animated animate__bounceIn animate__faster',
      },
    hideClass: {
        popup: 'animate__animated animate__bounceOut animate__faster'
      },
  };
Vue.use(InfiniteLoading, { /* options */ });
Vue.use(Loading, loading_options);
Vue.use(VueSweetalert2, swal_options);
Vue.use(VueConfirmDialog)

//MIXINS
//import responseHelper from './mixins/responseHelper'



Vue.component('vue-confirm-dialog', VueConfirmDialog.default)
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-to-cart', require('./components/AddToCart.vue').default);
Vue.component('change-qty', require('./components/ChangeQuantity.vue').default);
Vue.component('cart-count', require('./components/CartCount.vue').default);
Vue.component('cart-view', require('./components/CartView.vue').default);
Vue.component('checkout-view', require('./components/CheckoutView.vue').default);
Vue.component('search-input', require('./components/SearchInput.vue').default);
Vue.component('cart-view-total-amount', require('./components/CartViewTotalAmount.vue').default);
Vue.filter('toCurrency', function (value) {
    if (typeof value !== "number") {
        return value;
    }
    var formatter = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
        minimumFractionDigits: 2
    });
    return formatter.format(value);
});
//GLOBAL DATA
Vue.prototype.$csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
Vue.prototype.$bearerAPITOKEN = {
                'Accept' : 'application/json',
                'Authorization' : 'Bearer ' + document.querySelector("meta[name='api-token']").getAttribute('content'),
                };






const app = new Vue({
	mode: 'history'
}).$mount('#shop')



jQuery("#search-filter-input").on('keypress',function (e) {
   if (e.keyCode == 13) {
       window.location.replace("/search/"+$("#search-filter-input").val())
   }
});

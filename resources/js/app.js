/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all')
window.Vue = require('vue');
import VueRouter from 'vue-router';

window.Vue.use(VueRouter);
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
import '@sweetalert2/theme-bootstrap-4/bootstrap-4.css';
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
import responseHelper from './mixins/responseHelper'

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// PERSONAL

//import Security from './components/Security.vue';

// MANAGER
import DashboardIndex from './components/dashboard/DashboardIndex.vue';

import CustomersIndex from './components/customers/CustomersIndex.vue';
import CustomersCreate from './components/customers/CustomersCreate.vue';
import CustomersEdit from './components/customers/CustomersEdit.vue';

import PermissionsIndex from './components/permissions/PermissionsIndex.vue';
import PermissionsCreate from './components/permissions/PermissionsCreate.vue';

import CategoriesIndex from './components/categories/CategoriesIndex.vue';
//import CategoriesCreate from './components/categories/CategoriesCreate.vue';
import CategoriesEdit from './components/categories/CategoriesEdit.vue';

import StaffIndex from './components/staff/StaffIndex.vue';
import StaffCreate from './components/staff/StaffCreate.vue';
import StaffEdit from './components/staff/StaffEdit.vue';

import ProductsIndex from './components/products/ProductsIndex.vue';
import ProductsCreate from './components/products/ProductsCreate.vue';
import ProductsEdit from './components/products/ProductsEdit.vue';

import HandleOrdersIndex from './components/orders/HandleOrdersIndex.vue';
import ShipOrdersIndex from './components/orders/ShipOrdersIndex.vue';
import CompleteOrdersIndex from './components/orders/CompleteOrdersIndex.vue';

import SettingIndex from './components/settings/Setting.vue';

const routes = [
    {
        path: '/',
        components: {
            security: Security,
        	customersIndex: CustomersIndex,
            categoriesIndex: CategoriesIndex,
            productsIndex: ProductsIndex,
            dashboardIndex: DashboardIndex,
            permissionsIndex: PermissionsIndex,
            staffIndex: StaffIndex,
            shipordersIndex: ShipOrdersIndex,
            completeordersIndex: CompleteOrdersIndex,
        }
    },

    {path: '/customer', component: CustomersIndex, name: 'indexCustomer'},
    {path: '/create-customer', component: CustomersCreate, name: 'createCustomer'},
    {path: '/edit-customer/:id', component: CustomersEdit, name: 'editCustomer'},

    {path: '/permission', component: PermissionsIndex, name: 'indexPermission'},
    {path: '/create-permission', component: PermissionsCreate, name: 'createPermission'},

    {path: '/category', component: CategoriesIndex, name: 'indexCategory'},
    //{path: '/create-category', component: CategoriesCreate, name: 'createCategory'},
    {path: '/edit-category/:id', component: CategoriesEdit, name: 'editCategory'},

    {path: '/product', component: ProductsIndex, name: 'indexProduct'},
    {path: '/create-product', component: ProductsCreate, name: 'createProduct'},
    {path: '/edit-product/:id', component: ProductsEdit, name: 'editProduct'},

    {path: '/staff', component: StaffIndex, name: 'indexStaff'},
    {path: '/create-staff', component: StaffCreate, name: 'createStaff'},
    {path: '/edit-staff/:id', component: StaffEdit, name: 'editStaff'},

    {path: '/setting', component: SettingIndex, name: 'indexSetting'},

    {path: '/handle-order', component: HandleOrdersIndex, name: 'indexHandleOrder'},
    {path: '/ship-order', component: ShipOrdersIndex, name: 'indexShipOrder'},
    {path: '/complete-order', component: CompleteOrdersIndex, name: 'indexCompleteOrder'},
]
//GLOBAL DATA
Vue.prototype.$csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
Vue.prototype.$bearerAPITOKEN = {
                'Accept' : 'application/json',
                'Authorization' : 'Bearer ' + document.querySelector("meta[name='api-token']").getAttribute('content'),
                };

const router = new VueRouter({
	routes,
})






const app = new Vue({ 
    router 
}).$mount('#app')



jQuery("#search-filter-input").on('keypress',function (e) {
   if (e.keyCode == 13) {
       window.location.replace("/search/"+$("#search-filter-input").val())
   }
});

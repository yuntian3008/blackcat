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
Vue.use(VueConfirmDialog)
Vue.component('vue-confirm-dialog', VueConfirmDialog.default)
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('add-to-cart', require('./components/AddToCart.vue').default);
Vue.component('change-qty', require('./components/ChangeQuantity.vue').default);
Vue.component('cart-count', require('./components/CartCount.vue').default);
Vue.component('cart-view', require('./components/CartView.vue').default);
Vue.component('checkout-view', require('./components/CheckoutView.vue').default);
Vue.component('cart-view-total-amount', require('./components/CartViewTotalAmount.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// PERSONAL


import Security from './components/Security.vue';

// MANAGER
import DashboardIndex from './components/dashboard/DashboardIndex.vue';

import CustomersIndex from './components/customers/CustomersIndex.vue';
import CustomersCreate from './components/customers/CustomersCreate.vue';
import CustomersEdit from './components/customers/CustomersEdit.vue';

import PermissionsIndex from './components/permissions/PermissionsIndex.vue';
import PermissionsCreate from './components/permissions/PermissionsCreate.vue';

import CategoriesIndex from './components/categories/CategoriesIndex.vue';
import CategoriesCreate from './components/categories/CategoriesCreate.vue';
import CategoriesEdit from './components/categories/CategoriesEdit.vue';

import StaffIndex from './components/staff/StaffIndex.vue';
import StaffCreate from './components/staff/StaffCreate.vue';
import StaffEdit from './components/staff/StaffEdit.vue';

import ProductsIndex from './components/products/ProductsIndex.vue';
import ProductsCreate from './components/products/ProductsCreate.vue';
import ProductsEdit from './components/products/ProductsEdit.vue';

import GetOrdersIndex from './components/orders/GetOrdersIndex.vue';
import ShipOrdersIndex from './components/orders/ShipOrdersIndex.vue';
import CompleteOrdersIndex from './components/orders/CompleteOrdersIndex.vue';

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
            getordersIndex: GetOrdersIndex,
            shipordersIndex: ShipOrdersIndex,
            completeordersIndex: CompleteOrdersIndex,
        }
    },

    {path: '/create-customer', component: CustomersCreate, name: 'createCustomer'},
    {path: '/edit-customer/:id', component: CustomersEdit, name: 'editCustomer'},

    {path: '/create-permission', component: PermissionsCreate, name: 'createPermission'},

    {path: '/create-category', component: CategoriesCreate, name: 'createCategory'},
    {path: '/edit-category/:id', component: CategoriesEdit, name: 'editCategory'},

    {path: '/create-product', component: ProductsCreate, name: 'createProduct'},
    {path: '/edit-product/:id', component: ProductsEdit, name: 'editProduct'},

    {path: '/create-staff', component: ProductsCreate, name: 'createStaff'},
    {path: '/edit-staff/:id', component: ProductsEdit, name: 'editStaff'},
]
//GLOBAL DATA
Vue.prototype.$csrfToken = document.querySelector("meta[name='csrf-token']").getAttribute('content');
Vue.prototype.$bearerAPITOKEN = {
                'Accept' : 'application/json',
                'Authorization' : 'Bearer ' + document.querySelector("meta[name='api-token']").getAttribute('content'),
                }

const router = new VueRouter({
	routes,
})
const app = new Vue({ router }).$mount('#app')

$("#search-filter-input").on('keypress',function (e) {
   if (e.keyCode == 13) {
       window.location.replace("/search/"+$("#search-filter-input").val())
   }
});

<style>
.colored-toast.swal2-icon-success {
    background-color: rgba(55, 65, 81, 1) !important;
}
.text-white {
    color: white !important;
  /*background-color: #a5dc86 !important;*/
}
</style>
<template>
    <div>
        <loading :active.sync="isLoading"
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="w-full">
            <div class="p-4 rounded-full flex justify-between">
                <h1 class="ml-2 font-bold uppercase">Cart</h1>
                <h1 class="ml-2 font-bold uppercase">{{ cartItems.length }} items</h1>
            </div>
        </div>
        <table class="w-full text-sm lg:text-base" cellspacing="0">
            <thead class="bg-gray-700 text-white ">
                <tr class="h-12 uppercase">
                    <th class="hidden md:table-cell"></th>
                    <th class="text-left">Product</th>
                    <th class="lg:text-left text-left pl-5 lg:pl-0">
                        <span class="lg:hidden" title="Quantity">Qtd</span>
                        <span class="hidden lg:inline">Quantity</span>
                    </th>
                    <th class="hidden text-left md:table-cell">Unit price</th>
                    <th class="text-left">Total price</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-if="!(cartItems.length > 0)">
                    <td colspan="5"><div class="py-4 flex justify-center text-3xl font-extrabold text-gray-700">Nothing</div></td>
                </tr>
                <tr v-else v-for="item, index in cartItems">
                    <td class="hidden pb-4 md:table-cell">
                  <a href="#">
                    <img :src="item.product.image[0]" class="w-20 rounded" alt="Thumbnail">
                  </a>
                    </td>
                    <td>
                        <a href="#">
                            <p class="mb-2 md:ml-4">{{ item.product.product_name }}</p>
                        </a>
                    </td>
                    <td class="justify-start items-center md:flex mt-6">
                        <div class="w-20 h-10">
                            <div class="relative flex flex-row w-full h-8">
                                <input type="number" class="text-center rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-0 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent"  v-model="item.quantity" @change="changeQty(item)" min="1" max="100" step="1"/>
                            </div>
                        </div>
                    </td>
                    <td class="hidden text-left md:table-cell">
                        <span class="text-sm lg:text-base font-medium">
                            {{ item.product.product_price | toCurrency }}
                        </span>
                    </td>
                    <td class="text-left">
                        <span class="text-sm lg:text-base font-medium">
                            {{item.quantity * item.product.product_price | toCurrency}}
                        </span>
                    </td>
                    <td>
                        <button type="button" class="text-gray-700 hover:text-red-500 md:ml-4" @click="deleteItem(index,item)">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
    export default {
        components: {
            Loading,
        },
        data() {
            return {
                cartItems: [],
                isLoading: false,
                fullPage: true,
            }
        },
        mounted() {
            var app = this;

            if (window.localStorage.getItem("cart") == null) {
                    let initCart = [];
                    window.localStorage.setItem("cart",JSON.stringify(initCart));
                }

            app.isLoading = true;
            axios.get('api/customer/carts', {
                    params: JSON.parse(window.localStorage.getItem('cart')),
                    headers: app.$bearerAPITOKEN
                })
                .then(function (resp) {
                    app.isLoading = false;
                    app.cartItems = resp.data;
                    app.$root.$emit("updateTotal",app.cartItems);
                    //console.log(resp);
                })
                .catch(function () {
                    app.isLoading = false;
                    app.$swal.fire({
                      icon: 'error',
                      title: 'Oops...',
                      text: 'Something went wrong!',
                    });
                });
        },
        methods: {
            changeQty: function (item) {
                var app = this;
                let cart = JSON.parse(window.localStorage.getItem("cart"));
                let obj = cart.find(o => o.product_id === item.product_id);
                let index = cart.indexOf(obj);

                if (index >= 0)
                    cart.fill(obj.quantity = item.quantity,index,index++);

                window.localStorage.setItem('cart',JSON.stringify(cart));
                app.$root.$emit("updateTotal",app.cartItems);
                // app.isLoading = true;
                // axios.patch('api/customer/carts/'+ item.id, {
                //     quantity: item.quantity,
                // },{
                //         headers: app.$bearerAPITOKEN
                //     })
                // .then(function (resp) {
                //     app.isLoading = false;
                //     app.$root.$emit("updateTotal",app.cartItems);
                //     //console.log(resp);
                // })
                // .catch(function () {
                //     app.isLoading = false;
                //     app.$swal.fire({
                //       icon: 'error',
                //       title: 'Oops...',
                //       text: 'Something went wrong!',
                //     });
                // });
            },
            deleteItem: function (index,item) {
                var app = this;
                const Toast = app.$swal.mixin({
                  toast: true,
                  position: 'center',
                  iconColor: 'white',
                  customClass: {
                    popup: 'colored-toast',
                    title: 'text-white',
                  },
                  showClass: {
                    popup: 'animate__animated animate__jackInTheBox animate__fast'
                  },
                  hideClass: {
                    popup: 'animate__animated animate__fadeOut animate__fast'
                  },
                  showConfirmButton: false,
                  timer: 1500
                })
                this.$confirm({
                    title: 'Are you sure?',
                    message: 'Are you sure you want to remove '+ item.product.product_name + ' from the cart ?',
                    button: {
                        no: 'No',
                        yes: 'Yes'
                    },
                    /**
                    * Callback Function
                    * @param {Boolean} confirm
                    */
                    callback: a => {
                        if (a) {
                            let cart = JSON.parse(window.localStorage.getItem("cart"));
                            let obj = cart.find(o => o.product_id === item.product_id);
                            let indexCart = cart.indexOf(obj);

                            let arr = [];
                            if (index >= 0)
                                cart.splice(indexCart,1 );

                            window.localStorage.setItem('cart',JSON.stringify(cart));

                            app.cartItems.splice(index, 1);
                            app.$root.$emit("updateTotal",app.cartItems);
                            // app.isLoading = true;
                            //  axios.delete('api/customer/carts/'+ item.id,{
                            //         headers: app.$bearerAPITOKEN
                            // })
                            // .then(function (resp) {
                            //     app.isLoading = false;
                            //     app.cartItems.splice(index, 1);
                            //     app.$root.$emit("updateTotal",app.cartItems);
                            //     Toast.fire({
                            //       icon: 'success',
                            //       title: item.product.product_name + ' has been deleted to your cart'
                            //     })
                            //     //console.log(resp);
                            // })
                            // .catch(function () {
                            //     app.isLoading = false;
                            //     Toast.fire({
                            //       icon: 'success',
                            //       title: 'Could not remove' + item.product.product_name,
                            //     })
                            // });
                        }
                    },
                });
            },
        },
        computed: {
            total: function(){
                let sum = 0;
                this.cartItems.forEach(function(item) {
                    sum+= item.quantity;
                });

                return sum;
            }
        },
    }
</script>

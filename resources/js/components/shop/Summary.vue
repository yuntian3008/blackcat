<template>
    <div class="flex flex-col w-full ml-0 lg:ml-12 lg:w-2/5">
        <loading :active.sync="isLoading"
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <div class="pt-12 md:pt-0 2xl:ps-4">
            <h2 class="text-xl font-bold">Order Summary
            </h2>
            <div class="my-8">
                <div class="overflow-auto h-96">
                <div class="flex flex-col space-y-4">
                    <div class="flex space-x-4" v-for="item, index in cartItems" :key="item.product_id">
                        <div>
                            <img :src="item.product.images[0]" alt="image"
                                class="w-60">
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">{{ item.product.product_name > 30 ?  item.product.product_name.substring(0,30) + "..." : item.product.product_name }}</h2>
                            <!-- {{-- <p class="text-sm">{{ $product->find($item->product_id)->product_desc }}</p> --}} -->
                            <strong class="text-gray-700 mr-3">Price:</strong>{{ item.product.product_price | toCurrency }} x {{ item.quantity }}
                        </div>
                    </div>
                </div>
                </div>

            </div>
            <div
                class="flex items-center w-full py-4 text-xl font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:pb-0">
                Subtotal:<span class="ml-2">{{ temporaryAmount | toCurrency }}</span></div>
            <div
                class="flex items-center w-full py-4 text-xl font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:pb-0">
                Shipping:  <span class="ml-2">Gratis</span></div>
            <div
                class="flex items-center w-full py-4 text-xl font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:pb-0">
                Total:<span class="ml-2">{{ temporaryAmount | toCurrency }}</span></div>
        </div>
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
        },
        computed: {
            temporaryAmount: function(){
                let sum = 0;
                this.cartItems.forEach(function(item) {
                    sum+= item.quantity * item.product.product_price;
                });

                return sum;
            },
            totalAmount: function() {
                return this.temporaryAmount + this.shipping
            }
        },
    }
</script>

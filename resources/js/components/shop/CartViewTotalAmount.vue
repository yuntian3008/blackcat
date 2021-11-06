<template>
    <div class="lg:px-2 lg:w-1/2">
      <div class="px-4">
          <!-- <div class="flex justify-between border-b">
            <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
              Subtotal
            </div>
            <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
              {{temporaryAmount | toCurrency}}
            </div>
          </div> -->
            <!-- <div class="flex justify-between pt-4 border-b">
              <div class="flex lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-gray-800">
                <form action="" method="POST">
                  <button type="submit" class="mr-2 mt-1 lg:mt-2">
                    <svg aria-hidden="true" data-prefix="far" data-icon="trash-alt" class="w-4 text-red-600 hover:text-red-800" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M268 416h24a12 12 0 0012-12V188a12 12 0 00-12-12h-24a12 12 0 00-12 12v216a12 12 0 0012 12zM432 80h-82.41l-34-56.7A48 48 0 00274.41 0H173.59a48 48 0 00-41.16 23.3L98.41 80H16A16 16 0 000 96v16a16 16 0 0016 16h16v336a48 48 0 0048 48h288a48 48 0 0048-48V128h16a16 16 0 0016-16V96a16 16 0 00-16-16zM171.84 50.91A6 6 0 01177 48h94a6 6 0 015.15 2.91L293.61 80H154.39zM368 464H80V128h288zm-212-48h24a12 12 0 0012-12V188a12 12 0 00-12-12h-24a12 12 0 00-12 12v216a12 12 0 0012 12z"/></svg>
                  </button>
                </form>
                Coupon "90off"
              </div>
              <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-green-700">
                -133,944.77€
              </div>
            </div> -->
            <!-- <div class="flex justify-between pt-4 border-b">
              <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
                New Subtotal
              </div>
              <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
                14,882.75€
              </div>
            </div> -->
            <!-- <div class="flex justify-between pt-4 border-b">
              <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
                Shipping
              </div>
              <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
                {{ shipping === 0 ? "Gratis" : (shipping | toCurrency) }}
              </div>
            </div> -->
            <div class="flex justify-between pt-4 border-b">
              <div class="lg:px-4 lg:py-2 m-2 text-lg lg:text-xl font-bold text-center text-gray-800">
                Total (including VAT)
              </div>
              <div class="lg:px-4 lg:py-2 m-2 lg:text-lg font-bold text-center text-gray-900">
                {{ totalAmount | toCurrency }}
              </div>
            </div>
          <a href="#">
            <button type="button" @click="checkout()" class="flex justify-center w-full px-10 py-3 mt-6 font-medium text-white uppercase bg-gray-700 rounded-full shadow items-center hover:bg-gray-700 focus:shadow-outline focus:outline-none">
              <svg aria-hidden="true" data-prefix="far" data-icon="credit-card" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="currentColor" d="M527.9 32H48.1C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48.1 48h479.8c26.6 0 48.1-21.5 48.1-48V80c0-26.5-21.5-48-48.1-48zM54.1 80h467.8c3.3 0 6 2.7 6 6v42H48.1V86c0-3.3 2.7-6 6-6zm467.8 352H54.1c-3.3 0-6-2.7-6-6V256h479.8v170c0 3.3-2.7 6-6 6zM192 332v40c0 6.6-5.4 12-12 12h-72c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h72c6.6 0 12 5.4 12 12zm192 0v40c0 6.6-5.4 12-12 12H236c-6.6 0-12-5.4-12-12v-40c0-6.6 5.4-12 12-12h136c6.6 0 12 5.4 12 12z"/></svg>
              <span class="ml-2 mt-5px">Procceed to checkout</span>
            </button>
          </a>
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
                shipping : 0,
            }
        },
        mounted() {
            var app = this;
            this.$root.$on("updateTotal", (cartItems) => {
                app.cartItems = cartItems;
            });
        },
        methods: {
            checkout: function () {
                var app = this;
                if (app.cartItems.length == 0) {
                    app.$swal.fire({
                      icon: 'warning',
                      title: 'Invalid',
                      text: 'You need to have at least 1 product in your cart.',
                    });
                    return;
                }
                location.href = "/checkout";
            }
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

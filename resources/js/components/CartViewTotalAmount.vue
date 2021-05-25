<template>
    <div class="card-body pt-4">
        <h5 class="mb-3">The total amount of</h5>

        <ul class="list-group list-group-flush">
          <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
            Temporary amount
            <span id="total" class="font-weight-bold">$ {{temporaryAmount}}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center px-0">
            Shipping
            <span>{{ shipping === 0 ? "Gratis" : '$ '+ shipping}}</span>
          </li>
          <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
            <div>
              <strong>The total amount of</strong>
              <strong>
                <p class="mb-0">(including VAT)</p>
              </strong>
            </div>
            <span><strong id="total-final">$ {{ totalAmount }}</strong></span>
          </li>
        </ul>
        <form method="POST" action="/checkout">
            <input type="hidden" name="_token" :value="$csrfToken">
             <input type="hidden" name="shipping" :value="shipping">
              <input type="hidden" name="temporaryAmount" :value="temporaryAmount">
               <input type="hidden" name="totalAmount" :value="totalAmount">
            <button type="submit" class="btn btn-dark btn-block bg-brown">Proceed to order</button>
        </form>
        
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
            checkout: function() {
                var app = this;
                axios.post('/carts', {
                    secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
                    shipping : app.shipping,
                    temporaryAmount: app.temporaryAmount,
                    totalAmount: app.totalAmount,
                },{
                    _token: app.$csrfToken,
                })
                .then(function (resp) {
                    //console.log(resp);
                })
                .catch(function () {
                    alert("ERROR")
                });
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

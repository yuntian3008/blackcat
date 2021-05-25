<template>
    <div>
        <loading :active.sync="isLoading" 
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="d-flex justify-content-between">
            <h3 class="mb-4" v-if="cartItems.length">Cart ({{ cartItems.length }} items)</h3>
        </div>
        <div class="row mb-4" v-for="item, index in cartItems">
            <div class="col-md-5 col-lg-3 col-xl-3 d-flex align-items-center">
                <div class="rounded mb-3 mb-md-0">
                    <img class="img-fluid d-block" :src="item.product.product_image" alt="Sample"/>
                </div>
            </div>
            <div class="col-md-7 col-lg-9 col-xl-9">
                <div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <h5>{{ item.product.product_name }}</h5>
                            <p class="mb-3 text-muted small">
                                <strong>Unit price:</strong> $ {{ item.product.product_price }}
                            </p>
                            <p class="mb-2 text-muted text-uppercase small">
                            </p>
                        </div>
                        <div>
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text" id="inputGroup-sizing-sm">Qty.</span>
                                    </div>
                                    <input class="form-control form-control-sm"  type="number" v-model="item.quantity" @change="changeQty(item.product_id, item.quantity)" min="1" max="100" step="1"/>
                                </div>
                                
                            <small id="passwordHelpBlock" class="form-text text-muted text-center"></small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="#" data-confirm="Do you really want to remove this product?" type="button" class="text-danger small mr-3 remove" @click="deleteItem(index,item.product_id,item.product.product_name)">
                                <i class="fas fa-trash-alt mr-1"></i> Remove item 
                            </a> <!-- <a href="#!" type="button" class="card-link-secondary small text-uppercase"><i class="fas fa-heart mr-1"></i> Move to wish list </a> -->
                        </div>
                        <p class="mb-0">
                            <span class="fsize-28">
                                <strong id="summary" class="text-brown">$ {{item.quantity * item.product.product_price}}</strong>
                            </span>
                        </p class="mb-0"> 
                    </div> 
                </div> 
            </div> 
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
            app.isLoading = true;
            axios.post('/carts', {
                    secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
                },{
                    _token: app.$csrfToken,
                })
                .then(function (resp) {
                    app.cartItems = resp.data;
                    app.$root.$emit("updateTotal",app.cartItems);
                    app.isLoading = false;
                    //console.log(resp);
                })
                .catch(function () {
                    alert("Could not load your product")
                });
        },
        methods: {
            changeQty: function (product_id,quantity) {
                axios.post('/carts/change-quantity', {
                    product_id: product_id,
                    quantity: quantity,
                    secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
                },{
                    _token: app.$csrfToken,
                })
                .then(function (resp) {
                    app.cartItems = resp.data;
                    app.isLoading = false;
                    //console.log(resp);
                })
                .catch(function () {
                    alert("Could not load your product")
                });
            },
            deleteItem: function (index,product_id, product_name) {
                var app = this;
                this.$confirm({
                    title: 'Are you sure?',
                    message: 'Are you sure you want to remove '+ product_name + ' from the cart ?',
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
                            axios.post('/carts/remove-item', {
                                product_id: product_id,
                                secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
                            },{
                                _token: app.$csrfToken,
                            })
                            .then(function (resp) {
                                app.cartItems.splice(index, 1);
                                //console.log(resp);
                            })
                            .catch(function () {
                                alert("Could not load your product")
                            });
                        }
                    },
                });
            },
        },
        computed: {
            total: function(){
                let sum = 0;
                this.cartItem.forEach(function(item) {
                    sum+= item.quantity;
                });

                return sum;
            }
        },
    }
</script>

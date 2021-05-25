<template>
        <button class="btn btn-outline-brown col-sm-12 btnAdd" @click="addToCart">Add to cart</button>
</template>

<script>
    export default {
        props: ['product_id','quantity'],
        data() {
            return {
                data: {
                    product_id: this.product_id,
                    quantity: this.quantity,
                    secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
                }
            }
        },
        mounted() {
            this.$root.$on("updateQuantity", (qty) => {
                this.data.quantity = qty;
            });
        },
        methods: {
            addToCart() {
                var app = this;
                var data = app.data;
                if (app.data.secret === '') 
                    window.location.href = '/login'
                axios.post('/carts/add', data,{
                    _token: app.$csrfToken,
                })
                    .then(function (resp) {
                        app.$root.$emit("updateCount")
                        //console.log(resp);
                    })
                    .catch(function () {
                        alert("Could not load your product")
                    });
            }
        },
    }
</script>

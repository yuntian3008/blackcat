<template>
    <span class="fa-layers-counter fsize-48 fa-layers-bottom-left bg-primary text-white">{{ total }}</span>
</template>

<script>
    export default {
        data() {
            return {
                data: {
                    secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
                },
                cartItem: [],
            }
        },
        mounted() {
            var app = this;
            axios.post('/carts', app.data,{
                    _token: app.$csrfToken,
                })
                    .then(function (resp) {
                        app.cartItem = resp.data;
                        //console.log(resp);
                    })
                    .catch(function () {
                        alert("Could not load your product")
                    });
            this.$root.$on("updateCount", () => {
                axios.post('/carts', app.data,{
                    _token: app.$csrfToken,
                })
                    .then(function (resp) {
                        app.cartItem = resp.data;
                        //console.log(resp);
                    })
                    .catch(function () {
                        alert("Could not load your product")
                    });
            });
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

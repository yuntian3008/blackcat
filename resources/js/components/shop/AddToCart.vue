<template>
        <button @click.prevent="addToCart" class="disabled:opacity-50" :disabled="available == 0">{{ available ? "Add to cart" : "Sold out" }}</button>
</template>
<style>
.colored-toast.swal2-icon-success {
    background-color: rgba(55, 65, 81, 1) !important;
}
.text-white {
    color: white !important;
  /*background-color: #a5dc86 !important;*/
}



.colored-toast.swal2-icon-error {
  background-color: #f27474 !important;
}

.colored-toast.swal2-icon-warning {
  background-color: #f8bb86 !important;
}

.colored-toast.swal2-icon-info {
  background-color: #3fc3ee !important;
}

.colored-toast.swal2-icon-question {
  background-color: #87adbd !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}
</style>
<script>
    export default {
        props: ['product_id','quantity','available','login_url'],
        data() {
            return {
                data: {
                    product_id: this.product_id,
                    quantity: this.quantity,
                    available: this.available,
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
                var data = app.data;
                if (window.localStorage.getItem("cart") == null) {
                    let initCart = [];
                    window.localStorage.setItem("cart",JSON.stringify(initCart));
                }

                let cart = JSON.parse(window.localStorage.getItem("cart"));
                let obj = cart.find(o => o.product_id === data.product_id);
                let index = cart.indexOf(obj);

                if (index < 0)
                    cart.push(data);
                else
                    cart.fill(obj.quantity++,index,index++);

                window.localStorage.setItem('cart',JSON.stringify(cart));
                Toast.fire({
                          icon: 'success',
                          title: 'Item has been added to your cart'
                        })


                // if (app.$bearerAPITOKEN.Authorization === '')
                //     window.location.href = '/login'
                // axios.post('/api/customer/carts', data,{
                //         headers: app.$bearerAPITOKEN
                //     })
                //     .then(function (resp) {
                //         //app.$root.$emit("updateCount")
                    //         Toast.fire({
                    //           icon: 'success',
                    //           title: 'Item has been added to your cart'
                    //         })
                //         //console.log(resp);
                //     })
                //     .catch(function (resp) {
                //         if (resp.response.status == 401) {
                //             window.location = app.login_url;
                //         }
                //         Toast.fire({
                //           icon: 'warning',
                //           title: 'Error'
                //         })

                //     });
            }
        },
    }
</script>

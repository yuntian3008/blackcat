<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Get Orders list</div>
                <div class="form-group">
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Request Date</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order, index in orders" style=" cursor: pointer;">
                    <td @click="showDetail(order.id)">{{ order.id }}</td>
                    <td @click="showDetail(order.id)">{{ order.request_date }}</td>
                    <td @click="showDetail(order.id)">{{ order.phone }}</td>
                    <td @click="showDetail(order.id)">{{ order.address }}</td>
                    <td>
                        <a href="#"
                           class="btn btn-sm btn-success m-1"
                           v-on:click.prevent="actionOrder(order.id, index)">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </a>
                        <a href="#"
                           class="btn btn-sm btn-danger m-1"
                           v-on:click.prevent="cancelOrder(order.id, index)">
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>


                        </a>
                    </td>
                    <td @click="showDetail(order.id)">
                        <div class="btn" disabled>
                            <svg v-show="order.late_level !== 0"xmlns="http://www.w3.org/2000/svg" :class="(order.late_level == 1) ? 'text-warning' : ((order.late_level == 2) ? 'text-danger' : '')"  height="24" width="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import OrderDetails from './component/OrderDetails.vue'
    export default {
        data: function () {
            return {
                orders: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/orders/',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.orders = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load orders");
                });
        },
        methods: {
            showDetail(id) {
                var app = this;
                app.$modal.show(
                    OrderDetails,
                    { order_id: id },
                    {
                        width: "50%",
                        height: "auto",
                        classes: "bg-white",
                        scrollable: true,
                    }
                )
            },
            cancelOrder(id, index) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure about that?',
                    html: "Cancel this order ? (ORDER ID: <strong>"+ id +"</strong>)",
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonText: 'OK!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/v1/orders/' + id
                        ,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            app.orders.splice(index, 1);
                            app.$swal.fire({
                                title: 'Successfully!',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 1500,
                            });
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            var values =  Object.values(resp.response.data.errors);
                                var str = '';
                                for (const e of values) {
                                    str += e[0] + '<br/>';
                                }
                                app.$swal.fire({
                                    title: 'Error',
                                    html: str,
                                    icon: 'warning',
                                    showClass: {
                                        popup: 'animate__animated animate__headShake',
                                        icon: 'animate__animated animate__shakeX',
                                    },
                                }
                                )
                        });
                    }
                })
            },
            actionOrder(id, index) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "Mark the order as processed ? (ORDER ID: <strong>"+ id +"</strong>)",
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonText: 'OK!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.patch('/api/v1/orders/' + id,{

                        }
                        ,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            app.orders.splice(index, 1);
                            app.$swal.fire({
                                title: 'Successfully!',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 1500,
                            });
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            var values =  Object.values(resp.response.data.errors);
                                var str = '';
                                for (const e of values) {
                                    str += e[0] + '<br/>';
                                }
                                app.$swal.fire({
                                    title: 'Error',
                                    html: str,
                                    icon: 'warning',
                                    showClass: {
                                        popup: 'animate__animated animate__headShake',
                                        icon: 'animate__animated animate__shakeX',
                                    },
                                }
                                )
                        });
                    }
                })
            }
        }
    }
</script>

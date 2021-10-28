<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Ready Orders</div>
                <div class="form-group">
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Request Date</th>
                    <th>Processed Date</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th width="150">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order, index in orders">
                    <td>{{ order.id }}</td>
                    <td>{{ order.request_date }}</td>
                    <td>{{ order.get_date }}</td>
                    <td>{{ order.phone }}</td>
                    <td>{{ order.address }}</td>
                    <td>
                        <a href="#"
                           class="btn btn-sm btn-block btn-success m-1"
                           v-on:click="actionOrder(order.id, index)">
                              Start
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                orders: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/shipping/0',{
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
            actionOrder(id, index) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "Do you want to start shipping this order ? (ORDER ID: <strong>"+ id +"</strong>)",
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonText: 'OK!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.patch('/api/v1/shipping/' + id,{
                            type: 0,
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
                            app.handingError(resp,'Could not Mark the order as processed');
                        });
                    }
                })
            }
        }
    }
</script>
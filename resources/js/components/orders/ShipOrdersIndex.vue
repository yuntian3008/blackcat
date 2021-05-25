<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Ship Orders list</div>
                <div class="form-group">
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Request Date</th>
                    <th>Get Date</th>
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
                            Ship order
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
            axios.get('/api/v1/orders/'+ 2,{
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
                this.$confirm(
                    {
                        message: 'Are you sure you want to ship Order has id '+app.orders[index].id+' ?',
                        button: {
                            no: 'No',
                            yes: 'Yes'
                        },
                        /**
                        * Callback Function
                        * @param {Boolean} confirm 
                        */
                        callback: confirm => {
                            if (confirm) {
                                
                                axios.patch('/api/v1/orders/' + id,{
                                        action: 2,
                                    }
                                        
                                    ,{
                                        headers: app.$bearerAPITOKEN
                                    })
                                    .then(function (resp) {
                                        app.orders.splice(index, 1);
                                    })
                                    .catch(function (resp) {
                                        console.log(resp);
                                        alert("Could not get order");
                                    });
                            }
                        }
                    }
                )
            }
        }
    }
</script>
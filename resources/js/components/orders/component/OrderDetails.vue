<template>
    <div class="px-4">
        <h2 class="my-2">Order #{{ order.id }}</h2>
        <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="detail, index in order.order_details" :key="detail.id">
                    <td>
                        <div class="rounded">
                            <img width="100" :src="detail.product.product_image" class="rounded img-fluid" :alt="detail.product.product_name">
                        </div>
                        
                    </td>
                    <td class="font-weight-bold">{{ detail.product.product_name}}</td>
                    <td>{{ detail.quantity }}</td>
                    <td>{{ detail.product.product_price }}</td>
                    <td>{{ detail.product.product_desc }}</td>
                    <td>{{ detail.product.category.category_name }}</td>
                </tr>
                </tbody>
                
            </table>
    </div>
</template>
<script>
import responseHelper from '../../../mixins/responseHelper'

    export default {
        props: ['order_id'],
        mixins: [responseHelper],
        data: function () {
            return {
                order : [],
            }
        },
        mounted() {
            var app = this;
            var loader = app.$loading.show();
            axios.get('/api/v1/orders/'+app.order_id,{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.order = resp.data;
                    loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load order','back');
                });
        },
        methods: {
        }
    }
</script>
<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Products list</div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Category</span>
                        </div>
                        <select v-model="category_id" class="custom-select" @change="filter()">
                          <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                        </select>
                    </div>
                    
                </div>
                <div class="form-group">
                <router-link :to="{name: 'createProduct'}" class="btn btn-outline-dark">Create new product</router-link>
                </div>
                
                
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Visible</th>
                    <th width="100">&nbsp;</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="product, index in products">
                    <td><img :src="product.product_image" class="img-fluid" :alt="product.product_name"></td>
                    <td class="font-weight-bold">{{product.product_name}}</td>
                    <td>{{ product.product_price }}</td>
                    <td>{{ product.product_desc }}</td>
                    <td>{{ product.category.category_name }}</td>
                    <td><div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" :id="product.id" v-model="product.product_visible" v-on:click="deleteEntry(product.id, index)">
                            <label class="custom-control-label" :for="product.id">{{ product.product_visible ? "Yes" : "No" }}</label>
                        </div></td>
                    <td>
                        <router-link :to="{name: 'editProduct', params: {id: product.id}}" class="btn btn-sm btn-block btn-outline-dark m-1">
                            Edit
                        </router-link>
                        
                        <!-- <a href="#"
                           class="btn btn-sm btn-block btn-danger m-1"
                           >
                            Delete
                        </a> -->
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
                products: [],
                categories: [],
                category_id: '',
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/products',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.products = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load products");
                });
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load list categories");
                });
        },
        methods: {
            filter() {
                var app = this;
                axios.get('/api/v1/categories/' + app.category_id,{
                    headers: app.$bearerAPITOKEN
                })
                    .then(function (resp) {
                        app.products = resp.data.products;
                    })
                    .catch(function () {
                        alert("Could not load your product")
                    });
            },
            deleteEntry(id, index) {
                    var app = this;
                    this.$confirm(
                        {
                            message: app.products[index].product_visible ? 'Are you sure you want to HIDE '+app.products[index].product_name : 'Are you sure you want to SHOW '+app.products[index].product_name,
                            button: {
                                no: 'No',
                                yes: 'Yes'
                            },
                            /**
                            * Callback Function
                            * @param {Boolean} confirm 
                            */
                            callback: confirm => {
                                var visible = app.products[index].product_visible;
                                if (confirm) {
                                    
                                    axios.patch('/api/v1/products/' + id,{
                                            product_visible: visible,
                                            only_edit_visible: true,
                                        }
                                            
                                        ,{
                                            headers: app.$bearerAPITOKEN
                                        })
                                        .then(function (resp) {
                                            //app.products.splice(index, 1);
                                            // alert("ok");
                                        })
                                        .catch(function (resp) {
                                            console.log(resp);
                                            alert("Could not hide product");
                                        });
                                }
                                else {
                                    app.products[index].product_visible = !visible;
                                } 
                            }
                        }
                    )
                    
            }
        }
    }
</script>
<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">Edit product</div>
                <router-link :to="{ name: 'indexProduct' }" class="back-enti-btn"><i class="bi bi-arrow-return-left"></i>&ensp;Back</router-link>
            </div>
            <form>
                <div v-show="errors.length > 0" id="error" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div v-for="item in errors">
                        <strong>Warning: </strong>{{item}}.
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" v-on:click="errors = []"></button>
                </div>
                <div class="row g-2">
                    <div class="col-md-5">
                        <label class="control-label">Category</label>
                        <select v-model="product.category_id" class="form-select">
                            <option :value="null" selected>Choose product's category</option>
                            <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <label class="control-label">Product name</label>
                        <input type="text" v-model.trim="product.product_name" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Price</label>
                        <vue-numeric currency="$" separator="." v-model="product.product_price" class="form-control"></vue-numeric>
                        <!-- <input type="text" v-model.trim="" > -->
                        <label for="desc" class="mt-2">Additional information</label>
                        <div class="input-group input-group-sm mb-2" v-for="(spec, index) in product.product_specs" :key="index">
                            <!-- <div class="input-group-prepend">
                            <span class="input-group-text" id="">First and last name</span>
                            </div> -->
                            <input type="text" v-model="spec.key" class="form-control" placeholder="Attribute" required>
                            <input type="text" v-model="spec.value" class="form-control"
                            placeholder="Value" required>
                            <button class="btn btn-outline-danger" type="button" @click="deleteSpec(index)"><i class="fas fa-trash"></i></button>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="button" class="ml-3 btn btn-sm btn-outline-dark" @click="addSpec"><i class="bi bi-plus-lg"></i>&ensp;Add</button>
                        </div>
                    </div>  
                    
                    <div class="col-md-8">
                        <label for="desc">Description</label>
                        <textarea class="form-control" v-model.trim="product.product_desc" id="desc" rows="5"></textarea required>
                    </div>
                    
                </div>
                
                <div class="row g-1 mt-2">
                    <div class="col-sm-12 form-group">
                        
                        <button class="m-1 btn btn-outline-primary" @click="saveForm()">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

import VueNumeric from 'vue-numeric'

    export default {
        components: {
            VueNumeric,
        },
        data: function () {
            return {
                loader: this.$loading,
                productId: '',
                product: {
                    product_name: '',
                    product_price: 0,
                    category_id: null,
                    product_desc: '',
                    product_specs: [],
                },
                categories: [],
                errors: [],
            }
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.productId = id;
            app.loader = app.loader.show();
            axios.get('/api/v1/products/' + app.productId,{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    for (const [key, value] of Object.entries(app.product)) {
                        app.product[key] = resp.data[key];
                    }
                    app.loader.hide();
                })
                .catch(function () {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load list of categories','back');
                });
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data.original;
                    app.loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load list of categories','back');
                });
        },
        methods: {
            addSpec: function () {
                this.product.product_specs.push({ key: '', value: '' });
            },
            deleteSpec: function (index) {
                this.product.product_specs.splice(index, 1);
            },
            validate() {
                if (this.product.product_name === '')
                {
                    this.errors.push("Product name is empty");
                }
                if (!this.product.category_id)
                {
                    this.errors.push("Category is empty");
                }
                if (this.product.product_price === 0)
                {
                    this.errors.push("Price isn't valid");
                }
                if (this.product.product_desc === '')
                {
                    this.errors.push("Description is empty");
                }
                if (this.categories.length == 0)
                {
                    this.errors.push("Please create category before");
                }

            },
            saveForm() {
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0)
                {
                    var loader = app.$loading.show();
                    const form = new FormData();

                    form.append('data',JSON.stringify(app.product));
                    form.append('_method', 'PATCH');

                    axios.post('/api/v1/products/' + app.productId, form,{
                        headers: app.$bearerAPITOKEN
                    })
                    .then(function (resp) {
                        loader.hide();
                        app.$swal.fire({
                            title: 'Edited!',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 1500,
                        }).then((result) => {
                            app.$router.push({name: 'indexProduct'});
                        });
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not edit product');
                    });
                }
            }
        }
    }
</script>
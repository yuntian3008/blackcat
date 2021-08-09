<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">List of products</div>
                <router-link :to="{name: 'createProduct'}" class="add-enti-btn"><i class="bi bi-plus-lg"></i>&ensp;Create</router-link>
            </div>
            <div class="row gx-1 gy-2">
            <!-- <button @click="filter()" class="filter-enti-btn"><i class="bi bi-search"></i>&ensp;Search</button> -->
                <div class="col-lg-3 col-sm-12">
                    <input class="form-control" type="text" placeholder="Search by name" v-model="search.name" aria-label="default input example">
                </div>
                <div class="col-lg-3 col-sm-12">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><i class="bi bi-tag"></i>&ensp;Price</span>
                        <vue-numeric currency="$" separator="." v-model="search.price_from" class="form-control" placeholder="from" ></vue-numeric>
                        <vue-numeric currency="$" separator="." v-model="search.price_to" class="form-control" placeholder="to"></vue-numeric>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <select v-model="search.category_id" class="form-select">
                        <option :value="null" selected>Category (all)</option>
                        <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                    </select>
                </div>
                <div class="col-lg-3 col-sm-12">
                    <select v-model="search.visible" class="form-select">
                        <option :value="null" selected>Visible (all)</option>
                        <option :value="1">Showing</option>
                        <option :value="0">Hiding</option>
                    </select>
                </div>
                
            </div>
            <hr/>
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Visible</th>

                </tr>
                </thead>
                <tbody>
                <tr v-for="product, index in resultQuery">
                    <td v-on:click="showImg(index)"><div class="d-flex align-items-center"></div><img :src="product.product_image" class="rounded img-fluid" :alt="product.product_name" width="100"></td>
                    <td v-on:click="actionEntry(product.id,index)" class="font-weight-bold">{{product.product_name}}</td>
                    <td v-on:click="actionEntry(product.id,index)">{{ product.product_price }}</td>
                    <td v-on:click="actionEntry(product.id,index)">{{ product.product_desc }}</td>
                    <td v-on:click="actionEntry(product.id,index)">{{ product.category.category_name }}</td>
                    <td><div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" :id="'blockat_'+product.id" v-model="product.product_visible" v-on:click="deleteEntry(product.id, index)">
                            <label class="form-check-label" :for="'blockat_'+product.id">{{ product.product_visible ? "Yes" : "No" }}</label>
                        </div></td>
                </tr>
                </tbody>
                <caption class="text-center fsize-24" v-if="resultQuery.length == 0">No thing.</caption>
            </table>
        </div>
    </div>
</template>

<script>

import VueNumeric from 'vue-numeric'
import responseHelper from '../../mixins/responseHelper'
    export default {
        mixins: [responseHelper],
        components: {
            VueNumeric,
        },
        data: function () {
            return {
                loader: this.$loading,
                search: {
                    name: null,
                    price_from: 0,
                    price_to: 0,
                    category_id: null,
                    visible: null,
                },
                products: [],
                categories: [],
                category_id: '',
            }
        },
        mounted() {
            var app = this;
            app.loader = app.loader.show();
            axios.get('/api/v1/products',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.products = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load products','back');
                });
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load category','back');
                });
        },
        methods: {
            showImg(index) {
                var app = this;
                app.$swal.fire({
                    imageUrl: app.products[index].product_image.replace("sm","bg"),
                    imageAlt: app.products[index].product_name+' image'
                })
            }
            ,
            actionEntry(id, index) {
                var app = this;
                var e_id = id;
                app.$router.push({ name: 'editProduct', params: {id: e_id} });
            },
            deleteEntry(id, index) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "Do you want to change visibility of <strong>"+ app.products[index].product_name +"</strong>?",
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonColor: 'orange',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    var visible = app.products[index].product_visible;
                    if (result.isConfirmed) {
                        axios.patch('/api/v1/products/' + id,{
                                product_visible: visible,
                                only_edit_visible: true,
                            }
                                
                            ,{
                                headers: app.$bearerAPITOKEN
                            })
                            .then(function (resp) {
                                app.$swal.fire(
                                    'Changed!',
                                    'Product status has been changed.',
                                    'success'
                                )
                            })
                            .catch(function (resp) {
                                console.log(resp);
                                app.handingError(resp,'Could not change product status');
                            });
                        
                    }
                    else if (result.isDismissed) {
                        app.products[index].product_visible = !visible; 
                    }
                })
            }
        },
        computed: {
            resultQuery(){
                var app = this;
                var data = app.products;
                if(app.search.name)
                    data = data.filter((item)=>{
                            return app.search.name.toLowerCase().split(' ').every(v => item.product_name.toLowerCase().includes(v))
                        });
                if(!(app.search.price_from == 0 && app.search.price_to == 0))
                    data = data.filter((product) => (app.search.price_from <= product.product_price && app.search.price_to >= product.product_price));

                if(app.search.category_id)
                    data = data.filter((product) => (app.search.category_id == product.category_id));

                if(app.search.visible != null)
                    data = data.filter((product) => (app.search.visible == product.product_visible ));

                if(data.length) app.loader.hide();
                return data;
                // if(this.search_keyword){
                //     return this.products
                //         // .filter((item)=>{
                //         //     return this.search_keyword.toLowerCase().split(' ').every(v => item.product_name.toLowerCase().includes(v))
                //         // })
                //         .filter((item)=>{
                //             return this.search_keyword.toLowerCase().split(' ').every(v => item.product_price.toString().includes(v))
                //         })
                // }else{
                //     return this.products;
                // }
            }
        }
    }
</script>
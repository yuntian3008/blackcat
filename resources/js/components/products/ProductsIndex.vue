<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">List of products</div>
                <div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" @click="filter">
                        <label class="form-check-label" for="flexSwitchCheckDefault"><i class="bi bi-funnel" ></i>&ensp;Filter</label>
                    </div>
                    <router-link :to="{name: 'createProduct'}" class="add-enti-btn"><i class="bi bi-plus-lg"></i>&ensp;Create</router-link>
                </div>
                
            </div>
            <div class="row gx-1 gy-2" v-show="isFilter">
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
                <hr/>
            </div>
            
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Created at</th>
                    <th>Updated at</th>
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
                    <td v-on:click="actionEntry(product.id,index)">{{ product.created_at }}</td>
                    <td v-on:click="actionEntry(product.id,index)">{{ product.updated_at }}</td>
                    <td><div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" :id="'blockat_'+product.id" v-model="product.product_visible" v-on:click="deleteEntry(product.id, index)">
                            <label class="form-check-label" :for="'blockat_'+product.id">{{ product.product_visible ? "Yes" : "No" }}</label>
                        </div></td>
                </tr>
                </tbody>
                
                <caption class="text-center fsize-24" v-if="resultQuery.length == 0">No thing.</caption>
                
            </table>
            <pagination
                 v-show="!isFilter"
                :totalPages="total_page"
                :currentPage="current_page"
                :maxVisibleButtons="4"
                :firstButtonText="firstButtonText"
                :lastButtonText="lastButtonText"
                :prevButtonText="prevButtonText"
                :nextButtonText="nextButtonText"
                @pagechanged="onPageChange"
                 class="text-center"/>
        </div>
    </div>
</template>

<script>

import VueNumeric from 'vue-numeric'
import responseHelper from '../../mixins/responseHelper'
import Pagination from '../utils/Pagination'

    export default {
        mixins: [responseHelper],
        components: {
            VueNumeric,
            Pagination,
        },
        data: function () {
            return {
                firstButtonText : '<i class="bi bi-chevron-double-left"></i>',
                lastButtonText : '<i class="bi bi-chevron-double-right"></i>',
                nextButtonText : '<i class="bi bi-chevron-right"></i>',
                prevButtonText : '<i class="bi bi-chevron-left"></i>',
                search: {
                    name: null,
                    price_from: 0,
                    price_to: 0,
                    category_id: null,
                    visible: null,
                },
                isFilter: false,
                current_page: 1,
                total_page: 0,
                products: [],
                categories: [],
                category_id: '',
            }
        },
        mounted() {
            var app = this;
            this.onPageChange(this.current_page);
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
            filter() {
                this.isFilter = !this.isFilter;
                var app = this;
                if(this.isFilter) {
                    var loader = this.$loading.show();
                        axios.get('/api/v1/products',{
                        headers: app.$bearerAPITOKEN
                    })
                        .then(function (resp) {
                            app.products = resp.data;
                            loader.hide();
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            loader.hide();
                            app.handingError(resp,'Could not load products','back');
                        });
                }
                else this.onPageChange(this.current_page);
                
            },
            onPageChange(page) {
                console.log(page)
                var app = this;
                var loader = this.$loading.show();
                app.current_page = page;
                axios.get('/api/v1/products?page=' + page,{
                    headers: app.$bearerAPITOKEN
                })
                    .then(function (resp) {
                        var pagination = resp.data;
                        app.current_page = pagination.current_page;
                        app.total_page = pagination.last_page;
                        app.products = pagination.data;
                        loader.hide();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not load products','back');
                    });
            },
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

                return data;
            }
        }
    }
</script>
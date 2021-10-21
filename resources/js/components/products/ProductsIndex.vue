<style scoped>
    .form-check-input:checked {
        background-color: #212529;
        border-color: #212529;
    }
    .form-switch .form-check-input:focus {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23595c5f'/%3e%3c/svg%3e");
    }
    .form-check-input:focus {
        border-color: #595c5f;
        outline: 0;
        box-shadow: 0 0 0 0 rbg(33, 37, 41 / 0.25);
    }
    .form-switch .form-check-input:checked {
        background-position: right center;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='-4 -4 8 8'%3e%3ccircle r='3' fill='%23fff'/%3e%3c/svg%3e");
    }

    .container-image {
        width: 100px;
        height: 100px;
        position: relative;
    }

    .mask-image {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .container-image img {
        opacity: 1;
        display: block;
        width: 100%;
        height: auto;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .container-image:hover img {
        opacity: 0.3;
    }

    .container-image i {
        font-size: 50px;
    }

    .container-image:hover .mask-image {
        opacity: 1;
    }
</style>
<template>
    <div>
        <div v-if="productChangeImg != null" class="modal d-block animate__animated animate__zoomIn animate__faster" tabindex="-1" :aria-labelledby="'#changeImage_'+productChangeImg.id" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"  :id="'changeImage_'+changeImage.id"><i class="bi bi-hash"></i>&ensp;Change image of <strong>{{ productChangeImg.product_name}}</strong></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="productChangeImg = null"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <upload-image @save="saveImage"></upload-image>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body row g-3">
            <div class="d-flex justify-content-between mb-2 align-items-center">
                <div class="card-title display-6 m-0">Products</div>
                <div>
                    <div class="form-check form-switch form-check-inline">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" @click="filter">
                        <label class="form-check-label" for="flexSwitchCheckDefault"><i class="bi bi-funnel" ></i>&ensp;Filter</label>
                    </div>
                    <router-link :to="{name: 'createProduct'}" class="add-enti-btn"><i class="bi bi-plus-lg"></i>&ensp;Create</router-link>
                </div>
                
            </div>
            <hr>
            <div class="col-12 row gx-1 gy-2" v-show="isFilter">
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
                        <option v-for="category in categories" :value="category.id" :key="category.id">{{category.category_name}}</option>
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
                <tr v-for="product, index in (isFilter ? resultQuery : products)" :key="product.id">
                    <td @click="changeImage(product)">
                        <div class="container-image rounded">
                            <img :src="product.product_image" class="rounded img-fluid" :alt="product.product_name" style="width:100%">
                            <div class="mask-image">
                                <i class="bi bi-cloud-upload"></i>
                            </div>
                        </div>
                        
                    </td>
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
import UploadImage from '../utils/vue-advanced-cropper/UploadImage'

    export default {
        mixins: [responseHelper],
        components: {
            VueNumeric,
            Pagination,
            UploadImage,
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
                productChangeImg: null,
                imageUpload : null,
            }
        },
        mounted() {
            var app = this;
            this.onPageChange(this.current_page);
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data.original;
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
            changeImage(product) {
                var app = this;
                app.productChangeImg = product;
            },
            resetImage() {
                 this.imageUpload = null;
            },
            saveImage(image) {
                var app = this;
                var loader = app.$loading.show();
                image.canvas.toBlob(blob => {
                    const form = new FormData();

                    form.append('product_image',blob);
                    form.append('_method','PATCH');
                    axios.post('/api/v1/products/' + app.productChangeImg.id , form,{
                        headers: app.$bearerAPITOKEN
                    })
                    .then(function (resp) {
                        loader.hide();
                        app.$swal.fire({
                            title: 'Save!',
                            showConfirmButton: false,
                            icon: 'success',
                            timer: 1500,
                        }).then((result) => {
                            app.productChangeImg = null;
                            app.$router.go();
                        });
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not change image');
                    });
                },image.type);
            },
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
                    const form = new FormData;
                    form.append('visible',JSON.stringify(visible));
                    form.append('_method','PATCH');

                    if (result.isConfirmed) {
                        axios.post('/api/v1/products/' + id, form ,{
                                headers: app.$bearerAPITOKEN
                            })
                            .then(function (resp) {
                                app.$swal.fire({
                                    title: 'Changed!',
                                    showConfirmButton: false,
                                    icon: 'success',
                                    timer: 1500,
                                }).then((result) => {
                                    app.$router.go();
                                });
                                
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
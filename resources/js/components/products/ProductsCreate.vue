<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">Create new product</div>
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
                    <div class="col-md-4">
                        <label class="control-label">Category</label>
                        <select v-model="product.category_id" class="form-select">
                            <option :value="null" selected>Choose product's category</option>
                            <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Product name</label>
                        <input type="text" v-model.trim="product.product_name" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="control-label" for="customSwitch1">Visible</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="customSwitch1" v-model="product.product_visible">
                            <label class="form-check-label" for="customSwitch1">{{ product.product_visible ? "Yes" : "No" }}</label>
                        </div>
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
                        <label class="control-label">Product image</label>
                        <upload-image @save="saveImage"></upload-image>
                        <!-- <upload-image v-if="imageUpload == null" @save="saveImage"></upload-image> -->
                        <div class="flex flex-wrap gap-2 w-100 position-relative border rounded mt-2">
                            <!-- <div class=" position-absolute bottom-0 end-0 p-2">
                                <button class="btn btn-primary" @click="imageUpload = null"><i class="bi bi-arrow-clockwise"></i>&ensp;Reset</button>
                            </div> -->
                            <div class="relative"  v-for="img, index in product.product_image" :key="index">
                                <img :src="img" class="rounded mr-2" alt="product_image" width="200">
                                <span  @click.prevent="product.product_image.splice(index,1)" class="cursor-pointer absolute border-2 right-1 top-1 transform -translate-x-1/2 border-white text-white p-1 bg-red-500 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <label for="desc" class="mt-2">Description</label>
                        <textarea class="form-control" v-model.trim="product.product_desc" id="desc" rows="5"></textarea required>
                    </div>

                </div>

                <div class="row g-1 mt-2">
                    <div class="col-sm-12 form-group">

                        <button class="m-1 btn btn-outline-primary" @click="saveForm()">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

import VueNumeric from 'vue-numeric'
import UploadImage from '../utils/vue-advanced-cropper/UploadImage'

    export default {
        components: {
            VueNumeric,
            UploadImage,
        },
        data: function () {
            return {
                loader: this.$loading,
                product: {
                    product_name: '',
                    product_price: 0,
                    category_id: null,
                    product_visible: 1,
                    product_desc: '',
                    product_specs: [],
                    product_image: [],
                },
                categories: [],
                errors: [],
                imageUrls: [],
            }
        },
        mounted() {
            var app = this;
            app.loader = app.loader.show();
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
            saveImage(image) {
                this.product.product_image.push(image.canvas.toDataURL());
            },
            addSpec: function () {
                this.product.product_specs.push({ key: '', value: '' });
            },
            deleteSpec: function (index) {
                this.product.product_specs.splice(index, 1);
            },
            validate() {
                if (this.product.product_image.length == 0)
                {
                    this.errors.push("Please upload and save image least at 1 before continue");
                }
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
                //if(true)
                {
                    var loader = app.$loading.show();

                    const form = new FormData();

                        form.append('data',JSON.stringify(app.product));
                        form.append('product_image',app.imageUrls);
                        axios.post('/api/v1/products',
                            app.product
                        ,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            loader.hide();
                            app.$swal.fire({
                                title: 'Created!',
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
                            app.handingError(resp,'Could not create product');
                        });

                    // app.imageUpload.canvas.toBlob(blob => {

                    // },app.imageUpload.type);
                }
            }
        }
    }
</script>

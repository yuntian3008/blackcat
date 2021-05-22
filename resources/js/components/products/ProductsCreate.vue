<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <h4 class="card-title">Create new product</h4>
        <div class="card-body row">
            <div class="col"></div>
            <form v-on:submit="saveForm()" class="col-sm-8">
                <div v-show="errors.length > 0" id="error" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div v-for="item in errors">
                        <strong>Error: </strong>{{item}}.
                    </div>
                    <button type="button" class="close" v-on:click="errors = []" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="control-label">Category</label>
                        <select v-model="product.category_id" class="form-control">
                          <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group">
                        <label class="control-label">Product name</label>
                        <input type="text" v-model.trim="product.product_name" class="form-control">
                    </div>  
                    <div class="col-md-3 form-group">
                        <label class="control-label">Price</label>
                        <vue-numeric currency="$" separator="." v-model="product.product_price" class="form-control"></vue-numeric>
                        <!-- <input type="text" v-model.trim="" > -->
                    </div>  
                    <div class="col-md-2 form-group">
                        <label class="control-label">Visible</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="customSwitch1" v-model="product.product_visible">
                            <label class="custom-control-label" for="customSwitch1">{{ product.product_visible ? "Yes" : "No" }}</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group">
                        <label class="control-label">Product image</label>
                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="rounded"></vue-dropzone>
                    </div>
                    <div class="col-md-5 form-group">
                        <label for="desc">Description</label>
                        <textarea class="form-control" v-model.trim="product.product_desc" id="desc" rows="8"></textarea required>
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="desc">Additional information<button type="button" class="ml-3 btn btn-sm btn-outline-dark" @click="addSpec"><i class="fas fa-plus"></i></button></label>
                        <div class="input-group input-group-sm mb-2" v-for="(spec, index) in product.product_specs">
                            <!-- <div class="input-group-prepend">
                            <span class="input-group-text" id="">First and last name</span>
                            </div> -->
                            <input type="text" v-model="spec.key" class="form-control" placeholder="Attribute" required>
                            <input type="text" v-model="spec.value" class="form-control"
                            placeholder="Value" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-danger" type="button" @click="deleteSpec(index)"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <router-link to="/" class="m-1 btn btn-outline-secondary">Back</router-link>
                        <button class="m-1 btn btn-outline-primary">Create</button>
                    </div>
                </div>
            </form>
            <div class="col"></div>
        </div>
    </div>
</template>
<script>
 
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
import VueNumeric from 'vue-numeric'

    export default {
        components: {
            vueDropzone: vue2Dropzone,
            Loading,
            VueNumeric,
        },
        data: function () {
            return {
                dropzoneOptions: {
                    url: 'post',
                    autoProcessQueue: false,
                    parallelUploads: 1,
                    maxFiles:1,
                    addRemoveLinks: true,
                    dictDefaultMessage: "",
                    dictRemoveFile: "Xóa ?",
                    acceptedFiles: ".jpeg,.jpg,.png,",
                    init: function() {
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                    }   

                },
                product: {
                    product_name: '',
                    product_price: 0,
                    category_id: '',
                    product_image: '',
                    product_visible: true,
                    product_desc: '',
                    product_specs: [],
                },
                categories: [],
                errors: [],
                //Vue Loading Overlay
                isLoading: false,
                fullPage: true,
            }
        },
        mounted() {
            var app = this;
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
            addSpec: function () {
                this.product.product_specs.push({ key: '', value: '' });
            },
            deleteSpec: function (index) {
                this.product.product_specs.splice(index, 1);
            },
            validate() {
                if (this.$refs.myVueDropzone.getAcceptedFiles().length == 0)
                {
                    this.errors.push("Image is empty");
                }
                if (this.product.product_name === '')
                {
                    this.errors.push("Product name is empty");
                }
                if (this.product.category_id === '')
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
                event.preventDefault();
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0)
                {
                    app.isLoading = true;
                    var newProduct = app.product;
                    newProduct.product_image = this.$refs.myVueDropzone.getAcceptedFiles();
                    axios.post('/api/v1/products', newProduct,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.isLoading = false;
                            app.$router.push({path: '/'});
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.isLoading = false;
                            alert("Could not create your product");
                        });
                }
            }
        }
    }
</script>
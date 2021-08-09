<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">Create new product</div>
                <router-link :to="{ name: 'indexProduct' }" class="back-enti-btn"><i class="bi bi-arrow-return-left"></i>&ensp;Back</router-link>
            </div>
            <form v-on:submit="saveForm()">
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
                        <div class="form-check form-switch">
                            <input type="checkbox" class="form-check-input" id="customSwitch1" v-model="product.product_visible">
                            <label class="form-check-label" for="customSwitch1">{{ product.product_visible ? "Yes" : "No" }}</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="control-label">Price</label>
                        <vue-numeric currency="$" separator="." v-model="product.product_price" class="form-control"></vue-numeric>
                        <!-- <input type="text" v-model.trim="" > -->
                    </div>  
                    
                    <div class="col-md-12">
                        <label class="control-label">Product image</label>
                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="rounded"></vue-dropzone>
                    </div>
                    <div class="col-md-7">
                        <label for="desc">Description</label>
                        <textarea class="form-control" v-model.trim="product.product_desc" id="desc" rows="5"></textarea required>
                    </div>
                    <div class="col-md-5">
                        <label for="desc">Additional information</label>
                        <div class="input-group input-group-sm mb-2" v-for="(spec, index) in product.product_specs">
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
                    
                </div>
                
                <div class="row g-1 mt-2">
                    <div class="col-sm-12 form-group">
                        
                        <button class="m-1 btn btn-outline-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
 
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import VueNumeric from 'vue-numeric'

    export default {
        components: {
            vueDropzone: vue2Dropzone,
            VueNumeric,
        },
        data: function () {
            return {
                loader: this.$loading,
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
                    category_id: null,
                    product_image: '',
                    product_visible: true,
                    product_desc: '',
                    product_specs: [],
                },
                categories: [],
                errors: [],
            }
        },
        mounted() {
            var app = this;
            app.loader = app.loader.show();
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data;
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
                if (this.$refs.myVueDropzone.getAcceptedFiles().length == 0)
                {
                    this.errors.push("Image is empty");
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
                {
                    let loader = app.$loading.show();
                    var newProduct = app.product;
                    newProduct.product_image = this.$refs.myVueDropzone.getAcceptedFiles();
                    axios.post('/api/v1/products', newProduct,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            loader.hide();
                            app.$swal.fire({
                                title: 'Created!',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 5000,
                            });
                            app.$router.push({name: 'indexProduct'});
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            loader.hide();
                            app.handingError(resp,'Could not create product');
                        });
                }
            }
        }
    }
</script>
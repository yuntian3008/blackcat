<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
        :can-cancel="false"
        :is-full-page="fullPage"></loading>  
        <h4 class="card-title">Edit category</h4>
        <div class="card-body">
            <form v-on:submit="saveForm()">
                <div v-show="errors.length > 0" id="error" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div v-for="item in errors">
                        <strong>Error: </strong>{{item}}.
                    </div>
                    <button type="button" class="close" v-on:click="errors = []" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Category name</label>
                        <input type="text" v-model="category.category_name" class="form-control">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Visible</label>
                        <select v-model="category.category_visible" class="form-control">
                          <option value="1">Show</option>
                          <option value="0">Hide</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-9 form-group card border-0">
                        <label class="control-label">Category image</label>
                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="rounded"></vue-dropzone>
                    </div>
                    <div class="col-sm-3 form-group card border-0">
                        <label class="control-label font-weight-bold">Current category photos</label>
                        <img :src="category.category_image" class="img-fluid" :alt="category.category_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <router-link to="/" class="m-1 btn btn-outline-secondary">Back</router-link>
                        <button class="m-1 btn btn-outline-primary">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

    export default {
        components: {
            vueDropzone: vue2Dropzone,
            Loading
        },
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.categoryId = id;
            axios.get('/api/v1/categories/' + id,{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.category = resp.data;
                })
                .catch(function () {
                    alert("Could not load your category")
                });
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
                    dictRemoveFile: "Xóa hok?",
                    acceptedFiles: ".jpeg,.jpg,.png,",
                    init: function() {
                        this.on("maxfilesexceeded", function(file) {
                            this.removeAllFiles();
                            this.addFile(file);
                        });
                    }

                },
                categoryId: null,
                category: {
                    category_name: '',
                    category_image: '',
                    category_visible: '',
                },
                //Vue Loading Overlay
                isLoading: false,
                fullPage: true,
                errors: [],
            }
        },
        methods: {
            validate() {
                if (this.category.category_name === '')
                {
                    this.errors.push("Name is empty");
                }
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0) {
                    app.isLoading = true;
                    var newCategory = app.category;
                    if (this.$refs.myVueDropzone.getAcceptedFiles().length) {
                        newCategory.category_image = this.$refs.myVueDropzone.getAcceptedFiles();
                    }
                    else newCategory.category_image = 0;
                    axios.patch('/api/v1/categories/' + app.categoryId, newCategory,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.isLoading = false;
                            app.$router.replace('/');
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.isLoading = false;
                            alert("Could not create your category");
                        });
                }
            }
        }
    }
</script>
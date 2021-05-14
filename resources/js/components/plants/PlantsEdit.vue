<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <h4 class="card-title">Edit plant</h4>
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
                        <label class="control-label">Plant name</label>
                        <input type="text" v-model="plant.plant_name" class="form-control">
                    </div>  
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Category</label>
                        <select v-model="plant.category_id" class="form-control">
                          <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-9 form-group card border-0 bg-transparent">
                                <label class="control-label">Plant image</label>
                                <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="rounded"></vue-dropzone>
                            </div>
                            <div class="col-sm-3 form-group card border-0 bg-transparent">
                                <label class="control-label font-weight-bold text-center">Current plant photos</label>
                                <img :src="plant.plant_image" class="mx-auto" :alt="plant.plant_name">
                            </div>
                        </div>
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
            app.plantId = id;
            axios.get('/api/v1/plants/' + id,{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.plant = resp.data;
                })
                .catch(function () {
                    alert("Could not load your plant")
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
                plantId: '',
                plant: {
                    plant_name: '',
                    category_id: '',
                    plant_image: '',
                    plant_slug: '',
                },
                categories: [],
                //Vue Loading Overlay
                isLoading: false,
                fullPage: true,
                errors: [],
            }
        },
        methods: {
            validate() {
                if (this.plant.plant_name === '')
                {
                    this.errors.push("Name is empty");
                }
                if (this.plant.category_id === '')
                {
                    this.errors.push("Category is empty");
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
                    var newPlant = app.plant;
                    if (this.$refs.myVueDropzone.getAcceptedFiles().length) {
                        newPlant.plant_image = this.$refs.myVueDropzone.getAcceptedFiles();
                    }
                    else newPlant.plant_image = 0;
                    axios.patch('/api/v1/plants/' + app.plantId, newPlant,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.isLoading = false;
                            app.$router.replace('/');
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.isLoading = false;
                            alert("Could not update your plant");
                        });
                }
            }
        }
    }
</script>
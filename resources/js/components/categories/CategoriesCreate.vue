<template>
    <div class="vld-parent">
        <loading :active.sync="isLoading" 
        :can-cancel="false"
        :is-full-page="fullPage"></loading>
        <h4 class="card-title">Create new category</h4>
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
                    <div class="col-sm-3 form-group">
                        <label class="control-label">Category image (upload here)</label>
                        <vue-dropzone ref="myVueDropzone" id="dropzone" :options="dropzoneOptions" class="rounded"></vue-dropzone>
                    </div>
                    <div class="col-sm-5 form-group">
                        <label class="control-label">Category name</label>
                        <input type="text" v-model="category.category_name" class="form-control">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="control-label">Visible</label>
                        <select v-model="category.category_visible" class="form-control">
                          <option value="1">Show</option>
                          <option value="0">Hide</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <router-link to="/" class="m-1 btn btn-outline-secondary">Back</router-link>
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
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'

    export default {
        components: {
            vueDropzone: vue2Dropzone,
            Loading
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
                category: {
                    category_name: '',
                    category_image: '',
                    category_visible: 1,
                },
                isLoading: false,
                fullPage: true,
                errors: [],
            }
        },
        methods: {
            validate() {
                if (this.$refs.myVueDropzone.getAcceptedFiles().length == 0)
                {
                    this.errors.push("Image is empty");
                }
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
                    newCategory.category_image = this.$refs.myVueDropzone.getAcceptedFiles();
                    axios.post('/api/v1/categories', newCategory,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.isLoading = false;
                            app.$router.push({path: '/'});
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
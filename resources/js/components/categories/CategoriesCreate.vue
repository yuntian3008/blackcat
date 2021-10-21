<template>
    <div class="d-inline">
        <!-- <a :href="'#createmodal_'+(parent_category ? parent_category.id : 'null')" data-bs-toggle="modal" :data-bs-target="'#createmodal_'+(parent_category ? parent_category.id : 'null')" class="d-flex align-items-center btn btn-link text-decoration-none text-muted new-item">new {{ parent_category ? "sub-category" : "category"}} </a> -->
        <!-- Modal -->
        <div v-if="parent_category != null" class="modal d-block animate__animated animate__zoomIn animate__faster" :id="'createmodal_'+parent_category.id" tabindex="-1" :aria-labelledby="'#createmodalLabel_'+parent_category.id" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"  :id="'#createmodalLabel_'+parent_category.id"><i class="bi bi-hash"></i>&ensp;{{ parent_category.id != 0 ? "Create a subcategory of " : "Create new category"}}<strong>{{ parent_category.id != 0 ? parent_category.category_name : ""}}</strong></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="$emit('closeModal')"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <form class="col-sm-12">
                                <div v-if="errors.length > 0" id="error" class="alert alert-warning alert-dismissible animate__animated animate__headShake show" role="alert">
                                    <div v-for="item in errors">
                                        <strong>Error: </strong>{{item}}.
                                    </div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" v-on:click="errors = []" aria-label="Close">
                                    </button>
                                </div>
                                <div class="row g-2">
                                    <div class="col-sm-12 form-group">
                                        <label class="control-label">Category name</label>
                                        <input type="text" v-model="category.category_name" class="form-control">
                                    </div>
                                    <div class="col-sm-12 form-group">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button @click="saveForm()" class="m-1 btn btn-outline-primary">Save</button>
                </div>
                </div>
            </div>
        </div>
        <!-- <div class="card-body row g-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title display-6 m-0">Categories</div>
            </div>
            <hr>
            <form v-on:submit="saveForm()" class="col-md-6">
                <div class="h2"><i class="bi bi-hash"></i>&ensp;{{ parent_id ? "Create a subcategory of "+parent_category.category_name : "Create new category"}}</div>
                <div v-show="errors.length > 0" id="error" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div v-for="item in errors">
                        <strong>Error: </strong>{{item}}.
                    </div>
                    <button type="button" class="close" v-on:click="errors = []" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="row g-2">
                    <div class="col-sm-12 form-group">
                        <label class="control-label">Category name</label>
                        <input type="text" v-model="category.category_name" class="form-control">
                    </div>
                    <div class="col-sm-12 form-group">
                        <router-link :to="{ name: 'indexCategory'}" class="m-1 btn btn-outline-secondary">Back</router-link>
                        <button class="m-1 btn btn-outline-primary">Create</button>
                    </div>
                </div>
            </form>
            <div class="col"></div>
        </div> -->
    </div>
</template>

<script>

    export default {
        props: {
            parent_category: {
                type: Object,
                required: false,
                default: null,
            },
        },
        data: function () {
            return {
                category: {
                    category_name: '',
                    parent_id: null,
                },
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
                var app = this;
                app.errors = [];
                app.validate();
                if (app.parent_category.id != 0)
                    app.category.parent_id = app.parent_category.id;
                if (app.errors.length == 0) {
                    
                    var newCategory = app.category;
                    axios.post('/api/v1/categories', newCategory,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.$swal.fire({
                                title: 'Created!',
                                icon: 'success',
                            }).then((result) => {
                                app.$router.go();
                            });
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$swal.fire(
                                'Error!',
                                'Could not create category!',
                                'error',
                            );
                        });
                }
            }
        },
    }
</script>
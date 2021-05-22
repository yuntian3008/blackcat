<template>
    <div>
        
        <h4 class="card-title text-center">Create new category</h4>
        <div class="card-body row">
            <div class="col"></div>
            <form v-on:submit="saveForm()" class="col-sm-6">
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

    export default {
        data: function () {
            return {
                category: {
                    category_name: '',
                    category_visible: 1,
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
                event.preventDefault();
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0) {
                    var newCategory = app.category;
                    axios.post('/api/v1/categories', newCategory,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.$router.push({path: '/'});
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not create your category");
                        });
                }
            }
        }
    }
</script>
<template>
    <div>
        
        <h4 class="card-title">Create new permission</h4>
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
                    <div class="col"></div>
                    <div class="col-sm-4 form-group">
                        <label class="control-label">Display name</label>
                        <input type="text" v-model="permission.display_name" class="form-control">
                    </div>
                    <div class="col-sm-2 form-group">
                        <label class="control-label">code</label>
                        <input type="text" v-model="permission.name" class="form-control">
                    </div>
                    <div class="col"></div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Description</label>
                        <input type="text" v-model="permission.desc" class="form-control">
                    </div>
                    <div class="col"></div>
                </div>
                <div class="row">
                    <div class="col"></div>
                    <div class="col-sm- 4 form-group">
                        <router-link to="/" class="m-1 btn btn-outline-secondary">Back</router-link>
                        <button class="m-1 btn btn-outline-primary">Create</button>
                    </div>
                    <div class="col"></div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
 
    export default {
        data: function () {
            return {
                permission: {
                    display_name: '',
                    name: '',
                    desc: '',
                },
                errors: [],
            }
        },
        methods: {
            validate() {
                if (this.permission.display_name === '')
                {
                    this.errors.push("Display name is empty");
                }
                if (this.permission.name === '')
                {
                    this.errors.push("Name is empty");
                }
                if (this.permission.desc === '')
                {
                    this.errors.push("Description is empty");
                }
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0)
                {
                    var newPermission = app.permission;
                    axios.post('/api/v1/permissions', newPermission,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.$router.push({path: '/'});
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            alert("Could not create your permission");
                        });
                }
            }
        }
    }
</script>
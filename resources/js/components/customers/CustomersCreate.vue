<template>
    <div>
        <h4 class="card-title">Create new user</h4>
        <div class="card-body">
            <form v-on:submit="saveForm()">
                <div class="row">
                    <div class="col-sm-4 form-group">
                        <label class="control-label">First name</label>
                        <input type="text" v-model="user.fname" class="form-control">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="control-label">Last name</label>
                        <input type="text" v-model="user.lname" class="form-control">
                    </div>
                    <div class="col-sm-2 form-group">
                        <label class="control-label">Email</label>
                        <input type="text" v-model="user.email" class="form-control">
                    </div>
                    <div class="col-sm-2 form-group">
                        <label class="control-label">Gender</label>
                        <select v-model="user.gender" class="form-control">
                            <option value="female">Female</option>
                            <option value="male">Male</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="admin?" id="admin?" v-model="user.isAdmin">
                            <label class="form-check-label" for="admin?">General access ?</label>
                        </div>
                    </div>
                    <div class="col-sm-2 form-group">
                        <label class="control-label">Permission:</label>
                        <div class="form-check" v-for="permission in permissions">
                            <input class="form-check-input" v-model="user.permissions" type="checkbox" :value="permission.id" :id="permission.name" :disabled="!user.isAdmin">
                            <label class="form-check-label" :for="permission.name">
                            {{permission.display_name}}(Code: {{permission.name}})
                            </label>
                        </div>
                        <!-- 
                        <select v-model="user.permission" class="form-control">
                            <option value="">No Permission</option>
                            <option v-for="permission in permissions" v-if="permission.name != 'admin'" :value="permission.name">{{permission.name}}</option>
                        </select> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group text-left">
                        <small>Default password: "1"</small>
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
    export default {
        data: function () {
            return {
                user: {
                    fname: '',
                    lname: '',
                    gender: 'female',
                    email: '',
                    isAdmin: true,
                    permissions: [],
                },
                permissions: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/permissions',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.permissions = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load permissions");
                });
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newUser = app.user;
                axios.post('/api/v1/users', newUser,{
                headers: app.$bearerAPITOKEN
            })
                    .then(function (resp) {
                        app.$router.push({path: '/'});
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not create your user");
                    });
            },
        }
    }
</script>
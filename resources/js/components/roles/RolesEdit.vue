<template>
    <div>

        <h4 class="card-title">Edit role</h4>
        <div class="card-body">
            <form v-on:submit="saveForm()">
                <div class="row">
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Role name</label>
                        <input type="text" v-model="role.name" class="form-control">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Role description</label>
                        <input type="text" v-model="role.description" class="form-control">
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
    export default {
        mounted() {
            let app = this;
            let id = app.$route.params.id;
            app.roleId = id;
            axios.get('/api/v1/roles/' + id,{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.role = resp.data;
                })
                .catch(function () {
                    alert("Could not load your role")
                });
        },
        data: function () {
            return {
                roleId: null,
                role: {
                    name: '',
                    description: '',
                }
            }
        },
        methods: {
            saveForm() {
                event.preventDefault();
                var app = this;
                var newRole = app.role;
                axios.patch('/api/v1/roles/' + app.roleId, newRole,{
                headers: app.$bearerAPITOKEN
            })
                    .then(function (resp) {
                        app.$router.replace('/');
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        alert("Could not update your role");
                    });
            }
        }
    }
</script>
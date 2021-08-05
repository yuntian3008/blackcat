<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Role list</div>
                <div class="form-group">
                <router-link :to="{name: 'createRole'}" class="add-enti-btn">Create<i class="bi bi-plus"></i></router-link>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Role name</th>
                    <th>Role description</th>
                    <th width="100">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="role, index in roles">
                    <td>{{ role.name }}</td>
                    <td>{{ role.description }}</td>
                    <td>
                        <router-link :to="{name: 'editRole', params: {id: role.id}}" class="btn btn-sm btn-block btn-outline-dark m-1">
                            Edit
                        </router-link>
                        <a href="#"
                           class="btn btn-sm btn-block btn-danger m-1"
                           v-on:click="deleteEntry(role.id, index)">
                            Delete
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                roles: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/roles',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.roles = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load roles");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/roles/' + id,{
                headers: app.$bearerAPITOKEN
                })
                        .then(function (resp) {
                            app.roles.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete role");
                        });
                }
            }
        }
    }
</script>
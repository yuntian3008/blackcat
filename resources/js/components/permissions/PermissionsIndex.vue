<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Permissions list</div>
                <div class="form-group">
                <router-link :to="{name: 'createPermission'}" class="add-enti-btn">Create<i class="bi bi-plus"></i></router-link>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Display name</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th width="100">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="permission, index in permissions">
                    <td>{{permission.display_name}}</td>
                    <td>{{permission.name}}</td>
                    <td>{{ permission.desc}}</td>
                    <td>
                        <div v-if="permission.id != 1">
                            <button :disabled="permission.id == 2" 
                               class="btn btn-sm btn-block btn-danger m-1"
                               v-on:click="deleteEntry(permission.id, index)">
                                Delete
                            </button>
                        </div>
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
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/permissions/' + id,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.permissions.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete permission");
                        });
                }
            }
        }
    }
</script>
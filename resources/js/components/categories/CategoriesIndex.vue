<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Categories list</div>
                <div class="form-group">
                <router-link :to="{name: 'createCategory'}" class="btn btn-outline-dark">Create new category</router-link>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Slug (URL)</th>
                    <th>Visible</th>
                    <th width="100">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="category, index in categories">
                    <td>{{ category.category_name }}</td><td><img :src="category.category_image" class="img-fluid" :alt="category.category_name"></td>
                    <td>{{ category.category_slug }}</td>
                    <td>{{ category.category_visible }}</td>
                    <td>
                        <router-link :to="{name: 'editCategory', params: {id: category.id}}" class="btn btn-sm btn-block btn-outline-dark m-1">
                            Edit
                        </router-link>
                        <a href="#"
                           class="btn btn-sm btn-block btn-danger m-1"
                           v-on:click="deleteEntry(category.id, index)">
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
                categories: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load categories");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/categories/' + id,{
                headers: app.$bearerAPITOKEN
                })
                        .then(function (resp) {
                            app.categories.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete category");
                        });
                }
            }
        }
    }
</script>
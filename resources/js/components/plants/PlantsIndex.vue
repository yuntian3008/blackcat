<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Plants list</div>
                <div class="form-group">
                <router-link :to="{name: 'createPlant'}" class="btn btn-outline-dark">Create new plant</router-link>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Slug (URL)</th>
                    <th width="100">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="plant, index in plants">
                    <td>{{plant.plant_name}}</td>
                    <td><img :src="plant.plant_image" class="img-fluid" :alt="plant.plant_name"></td>
                    <td>{{ plant.category.category_name }}</td>
                    <td>{{ plant.plant_slug }}</td>
                    <td>
                        <router-link :to="{name: 'editPlant', params: {id: plant.id}}" class="btn btn-sm btn-block btn-outline-dark m-1">
                            Edit
                        </router-link>
                        <a href="#"
                           class="btn btn-sm btn-block btn-danger m-1"
                           v-on:click="deleteEntry(plant.id, index)">
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
                plants: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/plants',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.plants = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load plants");
                });
        },
        methods: {
            deleteEntry(id, index) {
                if (confirm("Do you really want to delete it?")) {
                    var app = this;
                    axios.delete('/api/v1/plants/' + id,{
                headers: app.$bearerAPITOKEN
            })
                        .then(function (resp) {
                            app.plants.splice(index, 1);
                        })
                        .catch(function (resp) {
                            alert("Could not delete plant");
                        });
                }
            }
        }
    }
</script>
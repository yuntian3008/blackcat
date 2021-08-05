<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Categories list</div>
                <div class="form-group">
                <router-link :to="{name: 'createCategory'}" class="add-enti-btn"><i class="bi bi-plus-lg"></i>&ensp;Create</router-link>
                </div>
            </div>
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Slug (URL)</th>
                    <th>Visible</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="category, index in categories" v-on:click="actionEntry(category.id, index)">
                    <td>{{ category.category_name }}</td>
                    <td>{{ category.category_slug }}</td>
                    <td>{{ category.category_visible }}</td>
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
            actionEntry(id, index) {
                var app = this;
                var e_id = id;
                app.$swal.fire({
                    icon: 'question',
                    html: 'What do you want to do with <strong>'+ app.categories[index].category_name +'</strong> category?',
                    showDenyButton: true,
                    showCloseButton: true,
                    confirmButtonText: '<i class="bi bi-pencil-square"></i>&ensp;Edit',
                    denyButtonText: '<i class="bi bi-trash-fill"></i>&ensp;Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        app.$router.push({ name: 'editCategory', params: {id: e_id} })
                    } else if (result.isDenied) {
                        app.deleteEntry(id,index);
                    }
                });
            },
            deleteEntry(id, index) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "You won't be able to revert <strong>"+ app.categories[index].category_name +"</strong> category!",
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/v1/categories/' + id,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            app.categories.splice(index, 1);
                            app.$swal.fire(
                                'Deleted!',
                                'Category has been deleted.',
                                'success'
                            )
                        })
                        .catch(function (resp) {
                            app.$swal.fire(
                                'Error!',
                                'Could not delete category!',
                                'error',
                            )
                        });
                        
                    }
                })
            }
        }
    }
</script>
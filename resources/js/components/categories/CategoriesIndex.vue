<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">List of categories</div>
                <router-link :to="{name: 'createCategory'}" class="add-enti-btn"><i class="bi bi-plus-lg"></i>&ensp;Create</router-link>
            </div>
            <div class="row gx-1 gy-2">
            <!-- <button @click="filter()" class="filter-enti-btn"><i class="bi bi-search"></i>&ensp;Search</button> -->
                <div class="col-lg-3 col-sm-12">
                    <input class="form-control" type="text" placeholder="Search by name" v-model="search.name" aria-label="default input example">
                </div>
                <div class="col-lg-3 col-sm-12">
                    <select v-model="search.visible" class="form-select">
                        <option :value="null" selected>Visible (all)</option>
                        <option :value="1">Showing</option>
                        <option :value="0">Hiding</option>
                    </select>
                </div>
            </div>
            <hr/>
            <table class="table table-hover">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>Slug (URL)</th>
                    <th>Visible</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="category, index in resultQuery" v-on:click="actionEntry(category.id, index)">
                    <td>{{ category.category_name }}</td>
                    <td>{{ category.category_slug }}</td>
                    <td>{{ category.category_visible }}</td>
                </tr>
                </tbody>
                <caption class="text-center fsize-24" v-if="resultQuery.length == 0">No thing.</caption>
            </table>
        </div>
    </div>
</template>

<script>
import responseHelper from '../../mixins/responseHelper'
    export default {
        mixins: [responseHelper],
        data: function () {
            return {
                categories: [],
                loader: this.$loading,
                search: {
                    name: null,
                    visible: null,
                },
            }
        },
        mounted() {
            var app = this;
            app.loader = app.loader.show();
            axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load categories','back');
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
                            app.handingError(resp,'Could not delete category');
                        });
                        
                    }
                })
            }
        },
        computed: {
            resultQuery(){
                var app = this;
                var data = app.categories;
                if(app.search.name)
                    data = data.filter((item)=>{
                            return app.search.name.toLowerCase().split(' ').every(v => item.category_name.toLowerCase().includes(v))
                        });

                if(app.search.visible != null)
                    data = data.filter((product) => (app.search.visible == product.category_visible ));

                if(data.length) app.loader.hide();
                return data;
                // if(this.search_keyword){
                //     return this.products
                //         // .filter((item)=>{
                //         //     return this.search_keyword.toLowerCase().split(' ').every(v => item.product_name.toLowerCase().includes(v))
                //         // })
                //         .filter((item)=>{
                //             return this.search_keyword.toLowerCase().split(' ').every(v => item.product_price.toString().includes(v))
                //         })
                // }else{
                //     return this.products;
                // }
            }
        }
    }
</script>
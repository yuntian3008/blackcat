<template :key="componentKey">
    <div>
        <div class="card-body row g-3">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title display-6 m-0">Categories</div>
            </div>
            
            <hr>
            <div class="col-md-6">
                <div class="h2"><i class="bi bi-hash">&ensp;</i>Relationship</div>
                <div class="tree-links">

                    <ul class="list-unstyled">
                        <recursive-list v-for="category in categories_rec" :node="category" :key="category.id"></recursive-list>
                        <li class="d-flex justify-content-center">
                            <caption v-if="categories_rec.length == 0">No thing.</caption>
                        </li>
                        
                        <li>
                                <!-- <router-link class="btn btn-link btn-sm border text-decoration-none text-muted ms-2"
                                    :to="{name: 'createCategory'}"><i class="bi bi-plus-lg"></i>&ensp;new category
                                    
                                </router-link> -->
                                <categories-create></categories-create>
                                <!-- <button 
                                    @click="$refs.open.show()" 
                                    class="btn btn-link btn-sm border text-decoration-none text-muted ms-2">
                                    <i class="bi bi-plus-lg"></i>
                                    &ensp;new category
                                </button> -->
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="h2"><i class="bi bi-hash">&ensp;</i>List</div>
                <div class="row gx-1 gy-2">
                <!-- <button @click="filter()" class="filter-enti-btn"><i class="bi bi-search"></i>&ensp;Search</button> -->
                    <div class="col-lg-3 col-sm-12">
                        <input class="form-control" type="text" placeholder="Search by name" v-model="search.name" aria-label="default input example">
                    </div>
                </div>
                <table class="table table-hover ">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug (URL)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="category, index in oriQuery" v-on:click="actionEntry(category)">
                        <td>{{ category.category_name }}</td>
                        <td>{{ category.category_slug }}</td>
                    </tr>
                    </tbody>
                    <caption class="text-center" v-if="oriQuery.length == 0">No thing.</caption>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import responseHelper from '../../mixins/responseHelper'
import RecursiveList from './RecursiveList'
import CategoriesCreate from './CategoriesCreate.vue';

    export default {
        components: {
            RecursiveList,
            CategoriesCreate
        },
        mixins: [responseHelper],
        data: function () {
            return {
                componentKey: 0,
                categories_rec: [],
                categories_ori: [],
                search: {
                    name: null,
                },
            }
        },
        mounted() {
            
            this.updateCategory();
        },
        methods: {
            updateCategory() {
                var app = this;
                var loader = this.$loading.show();
                axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories_ori = resp.data.original;
                    app.categories_rec = resp.data.recursive;
                    loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load categories','back');
                });
            },
            createCategory(parent_id) {
            },
            actionEntry(obj) {
                var app = this;
                app.$swal.fire({
                    icon: 'question',
                    html: 
                        'What do you want to do with <strong>'+ obj.category_name +'</strong> category?'+
                        '<div class="alert alert-danger mt-2" role="alert">'+
                            'All subcategories will also be deleted!'+
                        '</div>',
                    showDenyButton: true,
                    showCloseButton: true,
                    confirmButtonText: '<i class="bi bi-pencil-square"></i>&ensp;Edit',
                    denyButtonText: '<i class="bi bi-trash-fill"></i>&ensp;Delete',
                }).then((result) => {
                    if (result.isConfirmed) {
                        app.$router.push({ name: 'editCategory', params: {id: obj.id} })
                    } else if (result.isDenied) {
                        app.deleteEntry(obj);
                    }
                });
            },
            deleteEntry(obj) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "<strong>"+ obj.category_name +"</strong> will be moved to trash!" ,
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, Move it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/v1/categories/' + obj.id,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            // app.categories_ori.splice(index, 1);
                            // var parent = {
                            //     children_recursive: categories_rec,
                            // };
                            
                            app.$swal.fire({
                                title: 'Moved to trash!',
                                icon: 'success',
                            }).then((result) => {
                                app.$router.go();
                            })
                            
                        })
                        .catch(function (resp) {
                            app.handingError(resp,'Could not delete category');
                        });
                        
                    }
                })
            },
            // recursiveQuery(query,filter) {
            //     var app = this;
            //     var data = query;
            //     switch(filter) {
            //         case 'name':
            //             data = data.filter((item)=>{
            //                 var s = app.search.name.toLowerCase().split(' ').every(v => item.category_name.toLowerCase().includes(v));
            //                 if (item.children_recursive.length == 0)
            //                     return s;
            //                 return s.push(this.recursiveQuery(s));
            //             });
            //             break;
            //         case 'visible':
            //             data = data.filter((product) => {
            //                 var s = (app.search.visible == product.category_visible )
            //                 if (product.children_recursive.length == 0)
            //                     return s;
            //                 return this.recursiveQuery(s);
            //             });
            //             break;
            //         default:
            //             break;
            //     }

                
            //     return data;
            // }

            
        },
        computed: {
            oriQuery(){
                var app = this;
                var data = app.categories_ori;
                if(app.search.name)
                    data = data.filter((item)=>{
                            var s = app.search.name.toLowerCase().split(' ').every(v => item.category_name.toLowerCase().includes(v));
                            return s;
                        });

                
                return data;
            },
            // recQuery(){
            //     var app = this;
            //     var data = app.categories_rec;
            //     if(app.search.name)
            //         data = this.recursiveQuery(data,'name');

            //     if(app.search.visible != null)
            //         data = this.recursiveQuery(data,'visible')

                
            //     return data;
            // }
        }
    }
</script>
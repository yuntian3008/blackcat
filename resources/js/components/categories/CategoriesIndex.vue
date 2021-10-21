<template :key="componentKey">
    <div @contextmenu.prevent.stop="">
        <!-- vue- -->
        <categories-create :parent_category="category_action.add" @closeModal="closeModal"></categories-create>
        <categories-edit :category="category_action.edit" @closeModal="closeModal"></categories-edit>
        <div class="card-body row g-3">
            <div class="d-flex justify-content-between mb-2 align-items-center">
                <div class="card-title display-6 m-0">Categories</div>
                <div>
                    <button data-bs-toggle="modal" data-bs-target="#recycle-bin" class="btn btn-link btn-sm border text-decoration-none text-muted"><i class="bi bi-recycle">&ensp;</i>Recycle Bin</button>
                    <div class="modal animate__animated animate__zoomIn animate__faster" id="recycle-bin" tabindex="-1" aria-labelledby="#recycle-bin-label" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title "  id="recycle-bin-label"><i class="bi bi-recycle"></i>&ensp;Recycle bin</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="tree-links">
                                            <ul class="list-unstyled">
                                                <recursive-category-trash-list v-for="categoryTrash in categories_trash_rec" :node="categoryTrash" :key="categoryTrash.id"></recursive-category-trash-list>
                                                <li class="d-flex justify-content-center">
                                                    <caption v-if="categories_trash_rec.length == 0">No thing.</caption>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <small class="text-muted m-0">Right-click to perform operations with categories</small>
            <div class="col-md-6">
                <div class="h2"><i class="bi bi-hash">&ensp;</i>Relationship</div>
                <vue-simple-context-menu
                :elementId="'context-menu-item'"
                :options="optionContextMenu"
                :ref="'vueSimpleContextMenu'"
                @option-clicked="optionContextClicked"
                />
                <v-jstree v-if="data_view[0].children_recursive && data_view[0].children_recursive.length" whole-row :data="data_view" draggable :text-field-name="'category_name'" :children-field-name="'children_recursive'" @item-drop-before="itemDrop" allow-batch collapse>
                    <template slot-scope="_">
                        <div @contextmenu.prevent.stop="handleContextClicked( $event, _.model)" @click.prevent.stop="handleLeftClicked($event,  _.model)">
                            <i :class="_.vm.themeIconClasses" role="presentation" v-if="!_.model.loading && !!_.model.icon"></i>
                            {{_.model.category_name}}   
                        </div>
                        
                        <!-- <ul class="dropdown-menu animate__animated animate__zoomIn animate__very__fast">
                                <li><button class="dropdown-item" @click="openTab()"><i class="bi bi-box-arrow-up-right">&ensp;</i>Open category in new tab</button></li>
                                <li><button class="dropdown-item" @click="getLink()"><i class="bi bi-link-45deg">&ensp;</i>Copy link</button></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><button data-bs-toggle="modal" :data-bs-target="'#editmodal_'+_.model.id" class="dropdown-item"><i class="bi bi-pencil-square">&ensp;</i>Edit</button></li>
                                <li><button class="dropdown-item" @click="deleteEntry(_.model)"><i class="bi bi-trash">&ensp;</i>Move to trash</button></li>
                        </ul> -->
                    </template>
                    
                </v-jstree>
                <button v-if="!(data_view[0].children_recursive && data_view[0].children_recursive.length)" class="d-flex align-items-center btn btn-dark new-item" @click.prevent.stop="category_action.add = data_view[0];">Create a first category</button>
                
                <!-- <div class="tree-links">
                    <ul class="list-unstyled">
                        <recursive-category-list v-for="category in categories_rec" :node="category" :key="category.id"></recursive-category-list>
                        <li class="d-flex justify-content-center">
                            <caption v-if="categories_rec.length == 0">No thing.</caption>
                        </li>
                        <li> -->
                                <!-- <router-link class="btn btn-link btn-sm border text-decoration-none text-muted ms-2"
                                    :to="{name: 'createCategory'}"><i class="bi bi-plus-lg"></i>&ensp;new category
                                    
                                </router-link> -->
                                <!-- <categories-create></categories-create> -->
                                <!-- <button 
                                    @click="$refs.open.show()" 
                                    class="btn btn-link btn-sm border text-decoration-none text-muted ms-2">
                                    <i class="bi bi-plus-lg"></i>
                                    &ensp;new category
                                </button> -->
                        <!-- </li>
                    </ul>
                </div> -->
            </div>
            <div class="col-md-6">
                <div class="h2"><i class="bi bi-hash">&ensp;</i>List</div>
                <div class="row gx-1 gy-2">
                <!-- <button @click="filter()" class="filter-enti-btn"><i class="bi bi-search"></i>&ensp;Search</button> -->
                    <div class="col-lg-3 col-sm-12">
                        <input class="form-control" type="text" placeholder="Search by name" v-model="search.name" aria-label="default input example">
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug (URL)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="category, index in oriQuery" :key="index" @contextmenu.prevent.stop="handleContextClicked( $event,category)"  @click.prevent.stop="handleLeftClicked($event,category)">
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
<style lang="sass">
.vue-simple-context-menu {
    background: #fff;
    padding: .5rem 0;
    color: #212529;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: .25rem;
    font-family: "Quicksand", "Open Sans";
  &--active {
  }

  &__item {
    color: #212529;
    font-weight: 400;
    white-space: nowrap;
    padding: .25rem 1rem;
    clear: both;
    &:hover {
        color: #373b3e;
        background: #e9ecef;
    }
  }

  &__divider {
      height: 0; 
      margin: .5rem 0;
      padding: 0;
      border-top: 1px solid rgba(0,0,0,.15);
    overflow: hidden;
  }
}
</style>
<script>
import responseHelper from '../../mixins/responseHelper'
import CategoriesCreate from './CategoriesCreate.vue';
import CategoriesEdit from './CategoriesEdit.vue';
import RecursiveCategoryTrashList from './RecursiveCategoryTrashList.vue';
import VJstree from 'vue-jstree';
import 'vue-simple-context-menu/dist/vue-simple-context-menu.css'

import VueSimpleContextMenu from 'vue-simple-context-menu'

    export default {
        components: {
            CategoriesCreate,
            CategoriesEdit,
            RecursiveCategoryTrashList,
            VJstree,
            VueSimpleContextMenu,
        },
        mixins: [responseHelper],
        data: function () {
            return {
                categories_rec: [],
                categories_ori: [],
                categories_trash_rec: [],
                category_action : {
                    add: null,
                    edit: null,
                },

                //vue-jstree
                data_view: [
                    {
                        id: 0,
                        category_name: "Home",
                        category_slug: "",
                        icon: 'bi bi-hash',
                        children_recursive: [],

                    },
                ],
                search: {
                    name: null,
                },

                //vue-simple-context-menu
                optionContextMenu:  [
                    {
                        name: '<i class="bi bi-box-arrow-up-right">&ensp;</i>Open this category in new tab',
                        slug: 'openurl'
                    },
                    {
                        name: '<i class="bi bi-link-45deg">&ensp;</i>Copy link',
                        slug: 'copylink'
                    },
                    {
                        type: 'divider'
                    },
                    {
                        name: '<i class="bi bi-plus-lg">&ensp;</i>Add subcategory',
                        slug: 'add'
                    },
                    {
                        name: '<i class="bi bi-pencil-square">&ensp;</i>Edit',
                        slug: 'edit'
                    },
                    {
                        name: '<i class="bi bi-trash">&ensp;</i>Delete',
                        slug: 'delete'
                    }
                ],
            }
        },
        mounted() {
            this.updateData();
            
        },
        methods: {
            handleContextClicked (event, item) {
                this.$refs.vueSimpleContextMenu.showMenu(event, item)
            },
            handleLeftClicked (event, item) {
                if (window.innerWidth <= 799)
                this.$refs.vueSimpleContextMenu.showMenu(event, item)
            },
            optionContextClicked (event) {
                var app = this;
                
                switch (event.option.slug) {
                    case 'openurl':
                        app.openTab(event.item);
                        break;
                    case 'copylink':
                        app.getLink(event.item);
                        break;
                    case 'add':
                        app.category_action.add = event.item;
                        break;
                    case 'edit':
                        if(event.item.id == 0)
                            this.$swal.fire({
                                title: 'Error',
                                text: 'You can\'t edit home!',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 2000,
                            });
                        else
                        app.category_action.edit = event.item;
                        break;
                    case 'delete' :
                        if(event.item.id == 0)
                            this.$swal.fire({
                                title: 'Error',
                                text: 'You can\'t delete home!',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 2000,
                            });
                        else
                        app.deleteEntry(event.item);
                        break;
                
                    default:
                        break;
                }
            },
            closeModal() {
                this.category_action.add = null;
                this.category_action.edit = null;
            },
            updateData() {
            
            // Get Categories
                var app = this;
                var loader = this.$loading.show();
                axios.get('/api/v1/categories',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories_ori = resp.data.original;
                    app.categories_rec = resp.data.recursive;
                    app.data_view[0].children_recursive = app.categories_rec;
                    loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load categories','back');
                });

            // Get Categories Trash
                axios.get('/api/v1/categories-trash',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.categories_trash_rec = resp.data.recursive;
                    loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load categories trash','back');
                });

            },
            itemDrop(node, item, draggedItem, e) {
                if (item.id === draggedItem.id || draggedItem.id == 0) return;
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "Move <strong>"+ draggedItem.category_name +"</strong> into <strong>"+item.category_name+"</strong>?" ,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#0d6efd',
                    confirmButtonText: 'Yes, Move it!',
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        var newCategory = draggedItem;
                        newCategory.parent_id = (item.id == 0 ? null : item.id);
                        axios.patch('/api/v1/categories/' + draggedItem.id, newCategory,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            // app.categories_ori.splice(index, 1);
                            // var parent = {
                            //     children_recursive: categories_rec,
                            // };
                            
                            app.$swal.fire({
                                title: 'Successfully!',
                                icon: 'success',
                            }).then((result) => {
                                app.$router.go();
                            })
                            
                        })
                        .catch(function (resp) {
                            app.handingError(resp,'Could not move category');
                        });
                        
                    }
                    else{
                        app.$swal.fire({
                                title: 'Canceled!',
                                icon: 'info',
                            }).then((result) => {
                                app.$router.go();
                            })
                    }
                })
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
            getLink(node) {
                var a = window.location.origin + '/' + node.category_slug;
                function copyStringWithNewLineToClipBoard(stringWithNewLines){
                    // Step 1: create a textarea element.
                    // It is capable of holding linebreaks (newlines) unlike "input" element
                    const myFluffyTextarea = document.createElement('textarea');
                    
                    // Step 2: Store your string in innerHTML of myFluffyTextarea element        
                    myFluffyTextarea.innerHTML = stringWithNewLines;
                    
                    // Step3: find an id element within the body to append your myFluffyTextarea there temporarily
                    const parentElement = document.getElementById('app');
                    parentElement.appendChild(myFluffyTextarea);
                    
                    // Step 4: Simulate selection of your text from myFluffyTextarea programmatically 
                    myFluffyTextarea.select();
                    
                    // Step 5: simulate copy command (ctrl+c)
                    // now your string with newlines should be copied to your clipboard 
                    var copied = document.execCommand('copy');

                    // Step 6: Now you can get rid of your fluffy textarea element
                    parentElement.removeChild(myFluffyTextarea);

                    return copied;
                }
                var copied = copyStringWithNewLineToClipBoard(a);
                // COPY_TEXT.type = 'text';
                // COPY_TEXT.select();
                // COPY_TEXT.setSelectionRange(0,99999);/* For mobile devices */
                // var copied = document.execCommand("copy");
                // COPY_TEXT.type = 'hidden';
                if (copied) 
                    this.$swal.fire({
                        title: 'Copied!',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 1000,
                    });
            },
            openTab(node) {
                var a = window.location.origin + '/' + node.category_slug;
                window.open(a, '_blank');
            },

            
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
        }
    }
</script>



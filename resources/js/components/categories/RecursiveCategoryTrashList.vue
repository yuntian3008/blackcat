<template>  
    <li>
        <div class="d-flex justify-content-between">
            <a class="d-flex align-items-center btn btn-link text-decoration-none text-muted" 
                v-bind:class="{ 
                    'folder' : (node.children_only_trash_recursive && node.children_only_trash_recursive.length),
                    'item' :  !(node.children_only_trash_recursive && node.children_only_trash_recursive.length)}" 
                aria-current="page" 
                data-bs-toggle="collapse" 
                :href="'#collapse_trash_'+node.id" 
                role="button" 
                aria-expanded="false" 
                :aria-controls="'collapse_trash_'+node.id">
                {{ node.category_name }}
                
                
            </a>
            <div class="ms-auto dropstart">
                <button class="btn btn-link text-decoration-none text-muted" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10"><i class="bi bi-three-dots-vertical"></i></button>
                <ul class="dropdown-menu animate__animated animate__zoomIn animate__very__fast">
                    <li><h5 class="dropdown-header"><strong><i class="bi bi-arrow-counterclockwise">&ensp;</i>Restore</strong></h5></li>
                    <li><button class="dropdown-item" @click="restoreEntry(node)">Only this one</button></li>
                    <li v-if="node.children_only_trash_recursive && node.children_only_trash_recursive.length"><button class="dropdown-item" @click="restoreEntry(node,1)">With all subcategories</button></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button class="dropdown-item text-danger" @click="deleteEntry(node)"><i class="bi bi-trash">&ensp;</i>Permanently delete</button></li>
                </ul>
                <!-- <router-link :to="{name: 'createCategory', params: {id: node.id}}" class="btn btn-link btn-sm border text-decoration-none text-muted"><i class="bi bi-plus-lg"></i>&ensp;new sub-category</router-link> -->
            </div>
        </div>
        <ul v-if="node.children_only_trash_recursive && node.children_only_trash_recursive.length"  class="list-unstyled collapse ms-3"  :id="'collapse_trash_'+node.id">
            <node v-for="category in node.children_only_trash_recursive" :node="category" :key="category.id"></node>
        </ul>
    </li>

</template>

<script>

    export default {
  components: { },
        name: "node",
        props: {
            node: Object,
            // slug: {
            //     type: String,
            //     required: false,
            //     default: '',
            // }
        },
        methods: {
            restoreEntry(node,sub) {
                var app = this;
                var data = {
                    withChildren: sub,
                };
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "<strong>"+ node.category_name +"</strong> will be restored" + (sub ? " including subcategories" : "") + "." +
                        (sub ? "" : '<div class="alert alert-danger mt-2" role="alert">'+
                            'Once restored, this category will be set to the root category and their adjacent subcategories will be unlinked.'+
                        '</div>'),
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.patch('/api/v1/categories-trash/' + node.id, data, {
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            // app.categories_ori.splice(index, 1);
                            // var parent = {
                            //     children_recursive: categories_rec,
                            // };
                            
                            app.$swal.fire({
                                title: "<strong>"+ node.category_name +"</strong> has been restored",
                                icon: 'success',
                            }).then((result) => {
                                app.$router.go();
                            })
                            
                        })
                        .catch(function (resp) {
                            app.handingError(resp,'Could not restore category');
                        });
                        
                    }
                })
            },
            deleteEntry(node) {
                this.$parent.deleteEntry(node);
            },
        }
    };
</script>
<template>  
    <li>
        <div class="d-flex justify-content-between">
            <a class="d-flex align-items-center btn btn-link text-decoration-none text-muted" 
                v-bind:class="{ 'folder' : true /*(node.children_recursive && node.children_recursive.length)*/ }" 
                aria-current="page" 
                data-bs-toggle="collapse" 
                :href="'#collapse_'+node.id" 
                role="button" 
                aria-expanded="false" 
                :aria-controls="'collapse_'+node.id">
                {{ node.category_name }}
                
                
            </a>
            <div class="ms-auto dropstart">
                <categories-edit :category="node"></categories-edit>
                <button class="btn btn-link text-decoration-none text-muted" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,10"><i class="bi bi-three-dots-vertical"></i></button>
                <ul class="dropdown-menu animate__animated animate__zoomIn animate__very__fast">
                    <li><button class="dropdown-item" @click="openTab()"><i class="bi bi-box-arrow-up-right">&ensp;</i>Open category in new tab</button></li>
                    <li><button class="dropdown-item" @click="getLink()"><i class="bi bi-link-45deg">&ensp;</i>Copy link</button></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><button data-bs-toggle="modal" :data-bs-target="'#editmodal_'+node.id" class="dropdown-item"><i class="bi bi-pencil-square">&ensp;</i>Edit</button></li>
                    <li><button class="dropdown-item" @click="deleteEntry(node)"><i class="bi bi-trash">&ensp;</i>Move to trash</button></li>
                </ul>
                <!-- <router-link :to="{name: 'createCategory', params: {id: node.id}}" class="btn btn-link btn-sm border text-decoration-none text-muted"><i class="bi bi-plus-lg"></i>&ensp;new sub-category</router-link> -->
            </div>
        </div>
        <ul  class="list-unstyled collapse ms-3"  :id="'collapse_'+node.id">
            <node v-for="category in node.children_recursive" :node="category" :key="category.id"></node>
            <li><categories-create :parent_category="node"></categories-create></li>
        </ul>
    </li>

</template>

<script>
import CategoriesCreate from './CategoriesCreate';
import CategoriesEdit from './CategoriesEdit';

    export default {
  components: { CategoriesCreate, CategoriesEdit },
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
            getLink() {
                var a = window.location.origin + '/' + this.node.category_slug;
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
            openTab() {
                var a = window.location.origin + '/' + this.node.category_slug;
                window.open(a, '_blank');
            },
            actionEntry(node) {
                this.$parent.actionEntry(node);
            },
            deleteEntry(node) {
                this.$parent.deleteEntry(node);
            },
        }
    };
</script>
<template>
    <div class="flex flex-col p-5 gap-5">
        <h2 class="flex text-2xl font-black">
        Rating <span class="text-red-500">(*)</span>
        </h2>
        <div class="flex justify-center">
            <Rating :grade="star" :maxStars="5" :hasCounter="true" @rate="rate" />
        </div>
        <div class="flex">
            <div class="flex-1 w-1/2 px-3">
                <h2 class="text-2xl font-black mb-3">
                Comment (optional)
                </h2>
                <textarea v-model="comment" rows="11" type="text" id="rounded-email" class="resize-none rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-gray-600 focus:border-transparent"/>
            </div>
            <div class="flex-1 w-1/2 px-3">
                <h2 class="text-2xl font-black mb-3">
                Image (optional)
                </h2>
                <upload-image v-if="imageUpload == null" @save="saveImage" @processingImage="processingImage"></upload-image>
                <div v-if="imageUpload != null" class="flex w-full relative rounded-lg border-transparent border border-gray-300">
                    <img  :src="imageUpload.canvas.toDataURL()" class="rounded mx-auto flex" alt="product_image" width="200">
                    <div class="absolute bottom-0 right-0 p-2">
                        <button class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500" title="Reset Image" @click="imageUpload = null">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                              <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>Reset
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="flex justify-end">
            <button class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500" @click="saveForm()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                </svg>
                <span class="mx-1 uppercase">Send</span>
            </button>
        </div>
        
        
    </div>
        
</template>
<style>
.colored-toast.swal2-icon-success {
    background-color: rgba(55, 65, 81, 1) !important;
}
.text-white {
    color: white !important;
  /*background-color: #a5dc86 !important;*/
}
.square-button {
    background: rgba(black, 0.4);
    display: flex;
    align-items: center;
    justify-content: center;
    height: 42px;
    width: 42px;
    margin-bottom: 10px;
    cursor: pointer;
    transition: background 0.5s;
    &:hover {
        background: black;
    }
}
</style>


<script>
    import UploadImage from '../utils/vue-advanced-cropper/UploadImageTailwindCSS.vue'
    import Rating from '../utils/Rating.vue'
    export default {
        props: ['order_detail_id'],
        components: {
            Rating,
            UploadImage,
        },
        data() {
            return {
                imageUpload : null,
                star: 0,
                comment: null,
                processing: false,
                errors: [],
            }
        },
        mounted() {
           
        },
        methods: {
            rate(star) {
                this.star = star;
            },
            resetImage() {
                 this.imageUpload = null;
            },
            saveImage(image) {
                this.imageUpload = image;
            },
            processingImage(status) {
                this.processing = status;
            },
            saveForm() {
                var app = this;
                if (app.star <= 0 || app.star > 5) {
                    app.$swal.fire({
                        title: "Please rate 1 to 5 stars",
                        icon: 'warning',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500',
                        }
                    });
                    return;
                }
                if (app.processing == true) {
                    app.$swal.fire({
                        title: "You are editing your photo, please save the photo to continue. <br> Click:<div style=\"display: flex; justify-content: center;\"><span class=\"square-button\"><img src=\"data:image/svg+xml,%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='16px' height='16px' viewBox='0 0 16 16' enable-background='new 0 0 16 16' xml:space='preserve'%3E%3Cg%3E%3Cpath fill='%23FFFFFF' d='M0.8,5.6c0-0.5,0.3-1.2,0.6-1.6l2.7-2.7c0.3-0.3,1.1-0.6,1.6-0.6h8.7c0.5,0,0.9,0.5,0.9,0.9v12.6 c0,0.5-0.5,0.9-0.9,0.9H1.6c-0.5,0-0.9-0.5-0.9-0.9V5.6H0.8z M3.2,14.1v-3.9c0-0.5,0.5-0.9,0.9-0.9h7.8c0.5,0,0.9,0.5,0.9,0.9v3.9 h1.2V1.9h-1.2v3.9c0,0.5-0.5,0.9-0.9,0.9H6.4C6,6.7,5.7,6.4,5.7,5.8V1.9C5.3,1.9,5,2,4.9,2.2L2.2,4.9C2.1,5,1.9,5.3,1.9,5.6v8.4 H3.2z M11.6,14.1v-3.7H4.4v3.6h7.2V14.1z M6.8,5.3c0,0.2,0.2,0.3,0.3,0.3h1.9c0.2,0,0.3-0.2,0.3-0.3V2.2c0-0.2-0.2-0.3-0.3-0.3H7.1 C6.9,1.9,6.8,2,6.8,2.2C6.8,2.2,6.8,5.3,6.8,5.3z'/%3E%3C/g%3E%3C/svg%3E%0A\" /></span></div>",
                        icon: 'warning',
                        buttonsStyling: false,
                        customClass: {
                            confirmButton: 'flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500',
                        }
                    });
                    return;
                }
                    

                
                var form = new FormData();

                form.append('data',JSON.stringify({
                    level: app.star,
                    comment: app.comment,
                    order_detail_id: app.order_detail_id,
                }));
                if (app.imageUpload != null) {
                    app.imageUpload.canvas.toBlob(blob => {
                        
                        form.append('review_image',blob);
                        app.postAPI(form);
                    },app.imageUpload.type);
                    return;
                }

                app.postAPI(form);

                
                
            },

            postAPI(form) {
                var app = this;
                var loader = app.$loading.show();
                axios.post('/api/customer/reviews', form,{
                    headers: app.$bearerAPITOKEN
                })
                .then(function (resp) {
                    loader.hide();
                    app.$swal.fire({
                        title: 'Sent! Thanks for your review',
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 1500,
                    }).then((result) => {
                        location.reload();
                    });
                })
                .catch(function (resp) {
                    console.log(resp);
                    loader.hide();
                    //app.handingError(resp,'Could not create product');
                });
            }
        },
    }
</script>

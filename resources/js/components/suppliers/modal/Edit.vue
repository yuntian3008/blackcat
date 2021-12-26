<template>
    <div class="max-w-4xl p-10 mx-auto bg-white rounded-xl shadow-lg dark:bg-gray-800">
        <div class="flex w-full justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">Edit Supplier {{ '#'+supplier.id }}</h2>
            <button @click="$emit('close')" type="button" class="-mr-1 flex p-2 rounded-md hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white sm:-mr-2">
                  <span class="sr-only">
                      Dismiss
                  </span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="h-6 w-6 text-gray-900" viewBox="0 0 1792 1792">
                      <path d="M1490 1322q0 40-28 68l-136 136q-28 28-68 28t-68-28l-294-294-294 294q-28 28-68 28t-68-28l-136-136q-28-28-28-68t28-68l294-294-294-294q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 294 294-294q28-28 68-28t68 28l136 136q28 28 28 68t-28 68l-294 294 294 294q28 28 28 68z">
                      </path>
                  </svg>
              </button>
        </div>
        <div class="grid grid-cols-1 gap-10 mt-2 sm:grid-cols-2">
            <div class=" relative ">
                <label for="on-error-email" class="text-gray-700">
                    Company name
                    <span class="text-red-500 required-dot">
                        *
                    </span>
                </label>
                <input type="text" v-model.trim="supplier.company_name" :class="(errors.company_name && errors.company_name.length ? 'ring-red-500 ring-2' : '') +' rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent'" name="email" placeholder="Company name"/>
                    <svg v-if="errors.company_name && errors.company_name.length" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="absolute text-red-500 right-2 bottom-3" viewBox="0 0 1792 1792">
                        <path d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                        </path>
                    </svg>
                    <p class="absolute text-sm text-red-500 -bottom-6 whitespace-nowrap" v-if="errors.company_name && errors.company_name.length">
                        {{ errors.company_name[0] }}
                    </p>
            </div>
            <div class=" relative ">
                <label for="on-error-email" class="text-gray-700">
                    Email
                    <span class="text-red-500 required-dot">
                        *
                    </span>
                </label>
                <input type="text" v-model.trim="supplier.email" :class="(errors.email && errors.email.length ? 'ring-red-500 ring-2' : '') +' rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent'" name="email" placeholder="Email"/>
                    <svg v-if="errors.email && errors.email.length" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="absolute text-red-500 right-2 bottom-3" viewBox="0 0 1792 1792">
                        <path d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                        </path>
                    </svg>
                    <p class="absolute text-sm text-red-500 -bottom-6 whitespace-nowrap" v-if="errors.email && errors.email.length">
                        {{ errors.email[0] }}
                    </p>
            </div>
            <div class=" relative ">
                <label for="on-error-email" class="text-gray-700">
                    Phone
                    <span class="text-red-500 required-dot">
                        *
                    </span>
                </label>
                <input type="text" v-model.trim="supplier.phone" :class="(errors.phone && errors.phone.length ? 'ring-red-500 ring-2' : '') +' rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent'" name="email" placeholder="Phone"/>
                    <svg v-if="errors.phone && errors.phone.length" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="absolute text-red-500 right-2 bottom-3" viewBox="0 0 1792 1792">
                        <path d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                        </path>
                    </svg>
                    <p class="absolute text-sm text-red-500 -bottom-6 whitespace-nowrap" v-if="errors.phone && errors.phone.length">
                        {{ errors.phone[0] }}
                    </p>
            </div>
            <div class=" relative ">
                <label for="on-error-email" class="text-gray-700">
                    Address
                    <span class="text-red-500 required-dot">
                        *
                    </span>
                </label>
                <input type="text" v-model.trim="supplier.address" :class="(errors.address && errors.address.length ? 'ring-red-500 ring-2' : '') +' rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent'" name="email" placeholder="Address"/>
                    <svg v-if="errors.address && errors.address.length" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="absolute text-red-500 right-2 bottom-3" viewBox="0 0 1792 1792">
                        <path d="M1024 1375v-190q0-14-9.5-23.5t-22.5-9.5h-192q-13 0-22.5 9.5t-9.5 23.5v190q0 14 9.5 23.5t22.5 9.5h192q13 0 22.5-9.5t9.5-23.5zm-2-374l18-459q0-12-10-19-13-11-24-11h-220q-11 0-24 11-10 7-10 21l17 457q0 10 10 16.5t24 6.5h185q14 0 23.5-6.5t10.5-16.5zm-14-934l768 1408q35 63-2 126-17 29-46.5 46t-63.5 17h-1536q-34 0-63.5-17t-46.5-46q-37-63-2-126l768-1408q17-31 47-49t65-18 65 18 47 49z">
                        </path>
                    </svg>
                    <p class="absolute text-sm text-red-500 -bottom-6 whitespace-nowrap" v-if="errors.address && errors.address.length">
                        {{ errors.address[0] }}
                    </p>
            </div>
        </div>

        <div class="flex justify-between mt-8">
            <button class="py-1 px-3 flex justify-center items-center  bg-red-500 hover:bg-red-600 focus:ring-red-700 focus:ring-offset-red-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="remove()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
            <button class="py-1 px-3 flex justify-center items-center  bg-blue-500 hover:bg-blue-600 focus:ring-blue-700 focus:ring-offset-blue-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="saveForm()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V6h5a2 2 0 012 2v7a2 2 0 01-2 2H4a2 2 0 01-2-2V8a2 2 0 012-2h5v5.586l-1.293-1.293zM9 4a1 1 0 012 0v2H9V4z" />
                </svg>
                Save
            </button>
        </div>
    </div>
</template>
<script>

    export default {
        props: ['supplier'],
        components: {
            //
        },
        data: function () {
            return {
                errors: {
                    company_name: [],
                    email: [],
                    phone: [],
                    address: [],
                },
            }
        },
        mounted() {
            var app = this;
            //
        },
        methods: {
            remove() {
                var app = this;
                // app.validate();
                // if (app.errors.length == 0)
                // {
                //     var loader = app.$loading.show();
                //     app.imageUpload.canvas.toBlob(blob => {
                //         const form = new FormData();

                //         form.append('data',JSON.stringify(app.product));
                //         form.append('product_image',blob);
                //         axios.post('/api/v1/products', form,{
                //             headers: app.$bearerAPITOKEN
                //         })
                //         .then(function (resp) {
                //             loader.hide();
                //             app.$swal.fire({
                //                 title: 'Created!',
                //                 showConfirmButton: false,
                //                 icon: 'success',
                //                 timer: 1500,
                //             }).then((result) => {
                //                 app.$router.push({name: 'indexProduct'});
                //             });
                //         })
                //         .catch(function (resp) {
                //             console.log(resp);
                //             loader.hide();
                //             app.handingError(resp,'Could not create product');
                //         });
                //     },app.imageUpload.type);
                // }
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: "Do you want delete <strong>"+ app.supplier.company_name +"</strong> supplier?",
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonColor: 'red',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var loader = app.$loading.show();
                        axios.delete('/api/v1/suppliers/'+app.supplier.id,{
                                    headers: app.$bearerAPITOKEN
                                })
                                .then(function (resp) {
                                    loader.hide();
                                    app.$swal.fire({
                                        title: 'Deleted!',
                                        showConfirmButton: false,
                                        icon: 'success',
                                        timer: 1500,
                                    }).then((result) => {
                                        app.$emit('close');
                                    });
                                })
                                .catch(function (resp) {
                                    //console.log(resp);
                                    app.errors = resp.response.data.errors;
                                    loader.hide();
                                });
                    }
                });
            },
            saveForm() {
                var app = this;
                // app.validate();
                // if (app.errors.length == 0)
                // {
                //     var loader = app.$loading.show();
                //     app.imageUpload.canvas.toBlob(blob => {
                //         const form = new FormData();

                //         form.append('data',JSON.stringify(app.product));
                //         form.append('product_image',blob);
                //         axios.post('/api/v1/products', form,{
                //             headers: app.$bearerAPITOKEN
                //         })
                //         .then(function (resp) {
                //             loader.hide();
                //             app.$swal.fire({
                //                 title: 'Created!',
                //                 showConfirmButton: false,
                //                 icon: 'success',
                //                 timer: 1500,
                //             }).then((result) => {
                //                 app.$router.push({name: 'indexProduct'});
                //             });
                //         })
                //         .catch(function (resp) {
                //             console.log(resp);
                //             loader.hide();
                //             app.handingError(resp,'Could not create product');
                //         });
                //     },app.imageUpload.type);
                // }

                var loader = app.$loading.show();
                axios.put('/api/v1/suppliers/'+app.supplier.id, app.supplier,{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            loader.hide();
                            app.$swal.fire({
                                title: 'Updated!',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 1500,
                            }).then((result) => {
                                app.$emit('close');
                            });
                        })
                        .catch(function (resp) {
                            //console.log(resp);
                            app.errors = resp.response.data.errors;
                            loader.hide();
                        });
            }
        }
    }
</script>
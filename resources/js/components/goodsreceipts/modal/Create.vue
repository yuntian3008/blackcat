<template>
    <div class="p-10 w-full bg-white rounded-xl shadow-lg dark:bg-gray-800">
        <div class="flex w-full justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700 capitalize dark:text-white">New Goods Receipt</h2>
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
        <div class="bg-red-100 rounded-lg py-2 px-6 mb-4 text-base text-red-700 mb-2" role="alert"  v-for="e in errors">
          {{ e.message }}
        </div>
        <div class="grid grid-cols-1 gap-10 mt-2 sm:grid-cols-3">
            <div class=" relative ">
                <label for="supplier" class="text-gray-700">
                    Supplier
                    <span class="text-red-500 required-dot">
                        *
                    </span>
                </label>
                <select id="supplier" class="w-full text-gray-700 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" v-model="supplier_id">
                    <option v-for="supplier in suppliers" :value="supplier.id"  >
                        {{ supplier.company_name }}
                    </option>
                </select>

            </div>
            <div class=" relative col-span-2">
                    <label for="on-error-email" class="text-gray-700">
                        Details
                        <span class="text-red-500 required-dot">
                            *
                        </span>
                    </label>  
                    
                
                <div class="flex flex-row justify-between items-center gap-3 mb-3" v-for="(detail, index) in details" :key="index">
                    <input type="text" v-model.trim="detail.product_id" @click="openProductsList(index)" readonly class="rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-2 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" name="email" placeholder="Product id"/>
                   
                    <input type="number" min="1" v-model.trim="detail.quantity"  class="rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-2 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Quantity"/>
                    
                    <vue-numeric currency="$" separator="." v-model="detail.unit_price" class="rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-2 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" placeholder="Unit price"></vue-numeric>

                    <button class="py-1 px-1 flex justify-center items-center  bg-red-500 hover:bg-red-600 focus:ring-red-700 focus:ring-offset-red-200 text-white transition ease-in duration-200 text-center text-sm shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="delDetail(index)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>  
                </div>
                <div class="flex justify-end items-center mt-3">
                    <button class="py-1 px-3 flex justify-center items-center  bg-blue-500 hover:bg-blue-600 focus:ring-blue-700 focus:ring-offset-blue-200 text-white transition ease-in duration-200 text-center text-sm shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="addDetail()">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add
                    </button>  
                </div>
                
            </div>
        </div>

        <div class="flex justify-end mt-8">
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
    import ProductsList from "./ProductsList.vue"
    import VueNumeric from 'vue-numeric'

    export default {
        components: {
            VueNumeric,
        },
        data: function () {
            return {
                suppliers: [],
                supplier_id: '',
                details: [],
                errors: [],
            }
        },
        mounted() {
            var app = this;
            var loader = this.$loading.show();
            axios.get('/api/v1/suppliers',{
                    headers: app.$bearerAPITOKEN
                })
                    .then(function (resp) {
                        app.suppliers = resp.data;
                        loader.hide();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not load suppliers!','back');
                    });
        },
        methods: {
            addDetail: function () {
                this.details.push({ product_id: '', quantity: '', unit_price: '' });
            },
            delDetail: function (index) {
                this.details.splice(index, 1);
            },
            openProductsList(index) {
                var app = this;
                app.$modal.show(
                        ProductsList,
                        { },
                        { 
                            width: "70%",
                            adaptive : true,
                            height: "auto",
                            scrollable: true,
                            classes : 'bg-transparent',
                            clickToClose: false,
                        },
                        {
                            'before-close' : (e,id) => {
                                app.details[index].product_id = e.params;
                            },
                            'closed': (e) => {
                                
                            }
                        }
                    );
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
                app.errors = [];
                var loader = app.$loading.show();
                axios.post('/api/v1/goods-receipts',{
                    supplier_id: app.supplier_id,
                    details: app.details
                },{
                            headers: app.$bearerAPITOKEN
                        })
                        .then(function (resp) {
                            loader.hide();
                            app.$swal.fire({
                                title: 'Created!',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 1500,
                            }).then((result) => {
                                app.$emit('close');
                            });
                        })
                        .catch(function (resp) {
                            console.log(resp.response.data);
                            var err = resp.response.data.errors;
                            var keys = Object.keys(err);
                            for (const e of keys) {
                                if (e == "supplier_id") {
                                    app.errors.push({ message: "Supplier id is required"})
                                    continue;
                                }
                                if (e.includes('product_id')) {
                                    let i = e.match(/\d+/)[0];
                                    app.errors.push({ message: "Row "+ (parseInt(i) + 1) +": product id is required"})
                                    continue;
                                }
                                if (e.includes('quantity')) {
                                    let i = e.match(/\d+/)[0];
                                    app.errors.push({ message: "Row "+ (parseInt(i) + 1) +": quantity is required"})
                                    continue;
                                }
                                if (e.includes('unit_price')) {
                                    let i = e.match(/\d+/)[0];
                                    app.errors.push({ message: "Row "+ (parseInt(i) + 1) +": unit price is required"})
                                    continue;
                                }
                            }
                            loader.hide();
                        });
            }
        }
    }
</script>
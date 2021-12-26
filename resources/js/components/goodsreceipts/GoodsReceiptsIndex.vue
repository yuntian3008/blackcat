<template>
    <div class="container rounded-lg shadow-lg h-100 p-4 border mt-5">
        <header class="flex w-full justify-between items-center">
            <div class="flex flex-col gap-y-2">
                <h1 class="text-lg font-semibold">Goods receipts list</h1>
                <span class="inline-flex gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="text-gray-500 font-light">Have {{ total_items }} Goods Receipts</span>
                </span> 
            </div>
            <div>
                <!-- <router-link :to="{name: 'createSupplier'}" class="py-1 px-3 flex justify-center items-center  bg-blue-500 hover:bg-blue-600 focus:ring-blue-700 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2  rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    create
                </router-link> -->
                <button class="py-1 px-3 flex justify-center items-center  bg-blue-500 hover:bg-blue-600 focus:ring-blue-700 focus:ring-offset-blue-200 text-white w-full transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="openCreateForm()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M8.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l2-2a1 1 0 00-1.414-1.414L11 7.586V3a1 1 0 10-2 0v4.586l-.293-.293z" />
                      <path d="M3 5a2 2 0 012-2h1a1 1 0 010 2H5v7h2l1 2h4l1-2h2V5h-1a1 1 0 110-2h1a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V5z" />
                    </svg>
                    Import
                </button>
            </div>
            
        </header>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="flex flex-col">
          <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
              <div class="overflow-hidden">
                <table class="min-w-full">
                  <thead class="bg-gray-100 border-b">
                    <tr>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">ID</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Staff</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Supplier</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Total Amount</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">At</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">#</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 cursor-pointer" v-for="goods_receipt, index in goods_receipts" >
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ goods_receipt.id }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ goods_receipt.staff.firstname + ' ' + goods_receipt.staff.lastname  }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ goods_receipt.supplier.company_name }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ goods_receipt.total_amount }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ goods_receipt.created_at }}</td>
                        <td>
                            <div class="flex flex-row justify-end gap-x-2">
                                <button class="py-1 px-3 flex justify-center items-center  bg-blue-500 hover:bg-blue-600 focus:ring-blue-700 focus:ring-offset-blue-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="openEditForm(goods_receipt)"">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    Details
                                </button>
                                <button class="py-1 px-3 flex justify-center items-center  bg-red-500 hover:bg-red-600 focus:ring-red-700 focus:ring-offset-red-200 text-white transition ease-in duration-200 text-center text-base font-semibold shadow-md focus:outline-none focus:ring-2 focus:ring-offset-2 rounded-md" @click="del(goods_receipt)"">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                      <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
            </div>
          </div>
          <div class="w-full flex justify-center">
                <caption class="font-light text-md py-4" v-if="goods_receipts.length == 0">No thing.</caption>
              <pagination
                v-if="goods_receipts.length > 0"
                :totalPages="total_page"
                :currentPage="current_page"
                :maxVisibleButtons="4"
                :firstButtonText="firstButtonText"
                :lastButtonText="lastButtonText"
                :prevButtonText="prevButtonText"
                :nextButtonText="nextButtonText"
                @pagechanged="onPageChange"
                 class="text-center"/>
          </div>
        </div>
    </div>
</template>

<script>
import responseHelper from '../../mixins/responseHelper'
import Pagination from '../utils/Pagination'
import CreateForm from './modal/Create.vue'
import EditForm from './modal/Edit.vue'
    export default {
        mixins: [responseHelper],
        components: {
            Pagination,
        },
        data: function () {
            return {
                goods_receipts: [],
                total_items: 0,
                firstButtonText : '<i class="bi bi-chevron-double-left"></i>',
                lastButtonText : '<i class="bi bi-chevron-double-right"></i>',
                nextButtonText : '<i class="bi bi-chevron-right"></i>',
                prevButtonText : '<i class="bi bi-chevron-left"></i>',
                current_page: 1,
                total_page: 0,
            }
        },
        mounted() {
            
            var app = this;
            app.onPageChange(app.current_page);
        },
        methods: {
            onPageChange(page) {
                var app = this;
                var loader = this.$loading.show();
                app.current_page = page;
                axios.get('/api/v1/goods-receipts?page=' + page,{
                    headers: app.$bearerAPITOKEN
                })
                    .then(function (resp) {
                        var pagination = resp.data;
                        app.current_page = pagination.current_page;
                        app.total_page = pagination.last_page;
                        app.goods_receipts = pagination.data;
                        app.total_items = pagination.total;
                        loader.hide();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not load goods receipts!','back');
                    });
            },
            openCreateForm() {
                var app = this;
                app.$modal.show(
                        CreateForm,
                        { },
                        { 
                            width: "60%",
                            adaptive : true,
                            height: "auto",
                            scrollable: true,
                            classes : 'bg-transparent',
                        },
                        {
                            'closed': () => {
                                app.onPageChange(app.current_page);
                            }
                        }
                    );
            },
            openEditForm(goods_receipt) {
                var app = this;
                var loader = this.$loading.show();
                axios.get('/api/v1/goods-receipts/' + goods_receipt.id,{
                    headers: app.$bearerAPITOKEN
                })
                    .then(function (resp) {
                        var goods_receipt_details = resp.data;
                        app.$modal.show(
                            EditForm,
                            { 
                                goods_receipt_details: goods_receipt_details,
                                goods_receipt : goods_receipt,
                            },
                            { 
                                width: "50%",
                                adaptive : true,
                                height: "auto",
                                scrollable: true,
                                classes : 'bg-transparent',

                            },
                            {
                                'closed': () => {
                                }
                            }
                        );
                        loader.hide();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not load goods receipts details!');
                    });
                
            },
            del(entry) {
                var app = this;
                app.$swal.fire({
                    title: 'Are you sure?',
                    html: 'Are you sure you want to delete <strong>#'+entry.id+'</strong> goods receipt?',
                    icon: 'warning',
                    showCancelButton: true,
                    showClass: {
                        popup: 'animate__animated animate__headShake',
                        icon: 'animate__animated animate__shakeX',
                    },
                    confirmButtonColor: 'red',
                    confirmButtonText: 'Yes!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete('/api/v1/goods-receipts/' + entry.id
                            ,{
                                headers: app.$bearerAPITOKEN
                            })
                            .then(function (resp) {
                                app.$swal.fire(
                                    'Deleted!',
                                    'Goods receipt #'+entry.id+' has been deleted.',
                                    'success'
                                )
                                app.onPageChange(app.current_page);
                            })
                            .catch(function (resp) {
                                console.log(resp.response.data.errors);
                                var values =  Object.values(resp.response.data.errors);
                                var str = '';
                                for (const e of values) {
                                    str += e[0] + '<br/>';
                                }
                                app.$swal.fire({
                                    title: 'Error',
                                    html: str,
                                    icon: 'warning',
                                    showClass: {
                                        popup: 'animate__animated animate__headShake',
                                        icon: 'animate__animated animate__shakeX',
                                    },
                                }
                                )
                            });
                        
                    }
                })
            }
        }
    }
</script>
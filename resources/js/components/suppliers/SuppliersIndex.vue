<template>
    <div class="container rounded-lg shadow-lg h-100 p-4 border mt-5">
        <header class="flex w-full justify-between items-center">
            <div class="flex flex-col gap-y-2">
                <h1 class="text-lg font-semibold">Suppliers list</h1>
                <span class="inline-flex gap-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="text-gray-500 font-light">Have {{ total_items }} suppplier</span>
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
                      <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    create
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
                      <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Company</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Email</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Phone</th>
                        <th scope="col" class="text-sm font-medium text-gray-400 px-6 py-4 text-left uppercase">Address</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 cursor-pointer" v-for="supplier, index in suppliers" v-on:click="openEditForm(supplier)">
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ supplier.company_name }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ supplier.email }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ supplier.phone }}</td>
                        <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">{{ supplier.address }}</td>
                    </tr>
                  </tbody>
                </table>
                
              </div>
            </div>
          </div>
          <div class="w-full flex justify-center">
                <caption class="font-light text-md py-4" v-if="suppliers.length == 0">No thing.</caption>
              <pagination
                v-if="suppliers.length > 0"
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
                suppliers: [],
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
                axios.get('/api/v1/suppliers?page=' + page,{
                    headers: app.$bearerAPITOKEN
                })
                    .then(function (resp) {
                        var pagination = resp.data;
                        app.current_page = pagination.current_page;
                        app.total_page = pagination.last_page;
                        app.suppliers = pagination.data;
                        app.total_items = pagination.total;
                        loader.hide();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not load suppliers!','back');
                    });
            },
            openCreateForm() {
                var app = this;
                app.$modal.show(
                        CreateForm,
                        { },
                        { 
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
            openEditForm(supplier) {
                var app = this;
                app.$modal.show(
                        EditForm,
                        { supplier: supplier },
                        { 
                            adaptive : true,
                            height: "auto",
                            scrollable: true,
                        },
                        {
                            'closed': () => {
                                app.onPageChange(app.current_page);
                            }
                        }
                    );
            },
            actionEntry(id, index) {
                var app = this;
                var e_id = id;
                app.$router.push({ name: 'editSupplier', params: {id: e_id} });
            },
            deleteEntry(id, index) {
                // var app = this;
                // app.$swal.fire({
                //     title: 'Are you sure?',
                //     html: 'Are you sure you want to '+(app.staff[index].block ? 'un' : '' )+'block <strong>'+app.staff[index].firstname+'</strong> ?',
                //     icon: 'warning',
                //     showCancelButton: true,
                //     showClass: {
                //         popup: 'animate__animated animate__headShake',
                //         icon: 'animate__animated animate__shakeX',
                //     },
                //     confirmButtonColor: 'orange',
                //     confirmButtonText: 'Yes!'
                // }).then((result) => {
                //     var status = app.staff[index].block;
                //     if (result.isConfirmed) {
                //         axios.patch('/api/v1/staff/' + id,{
                //                 block: status,
                //                 only_edit_block: true,
                //             }
                //             ,{
                //                 headers: app.$bearerAPITOKEN
                //             })
                //             .then(function (resp) {
                //                 app.$swal.fire(
                //                     'Changed!',
                //                     'Staff status has been changed.',
                //                     'success'
                //                 )
                //             })
                //             .catch(function (resp) {
                //                 console.log(resp);
                //                 app.staff[index].block = !status;
                //                 app.handingError(resp,'Could not change staff status!');
                //             });
                        
                //     }
                //     else if (result.isDismissed) {
                //         app.staff[index].block = !status;
                //     }
                // })
            }
        }
    }
</script>
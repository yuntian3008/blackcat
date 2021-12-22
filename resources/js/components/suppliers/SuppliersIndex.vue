<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Suppliers list</div>
                <div class="form-group">
                <router-link :to="{name: 'createSupplier'}" class="add-enti-btn">Create<i class="bi bi-plus"></i></router-link>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="supplier, index in suppliers" v-on:click="actionEntry(supplier.id,index)">
                    <td>{{ supplier.company_name }}</td>
                    <td>{{ supplier.email }}</td>
                    <td>{{ supplier.phone }}</td>
                    <td>{{ supplier.address }}</td>
                </tr>
                </tbody>
                <caption class="text-center fsize-24" v-if="suppliers.length == 0">No thing.</caption>
            </table>
            <pagination
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
</template>

<script>
import responseHelper from '../../mixins/responseHelper'
import Pagination from '../utils/Pagination'

    export default {
        mixins: [responseHelper],
        components: {
            Pagination,
        },
        data: function () {
            return {
                suppliers: [],
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
                        loader.hide();
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        app.handingError(resp,'Could not load suppliers!','back');
                    });
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
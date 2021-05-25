<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="card-title h4 m-0">Staff list</div>
                <div class="form-group">
                <router-link :to="{name: 'createStaff'}" class="btn btn-outline-dark">Create new staff</router-link>
                </div>
            </div>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th width="100">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="stafff, index in staff">
                    <td>{{ stafff.first_name }}</td>
                    <td>{{ stafff.last_name }}</td>
                    <td>{{ stafff.username }}</td>
                    <td><span class="badge badge-success" v-for="role, i in stafff.roles">{{ role.name}}</span></td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox"  class="custom-control-input" id="customSwitch1" v-model="stafff.block" v-on:click="deleteEntry(stafff.id, index)">
                            <label class="custom-control-label custom-switch-danger" for="customSwitch1">{{ stafff.block ? "Blocked" : "Unblocked" }}</label>
                        </div>
                    </td>
                    <td>
                        <!-- <router-link :to="{name: 'editStaff', params: {id: stafff.id}}" class="btn btn-sm btn-block btn-outline-dark m-1">
                            Edit
                        </router-link> -->
                    </td>
                    
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                staff: []
            }
        },
        mounted() {
            var app = this;
            axios.get('/api/v1/staff',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.staff = resp.data;
                })
                .catch(function (resp) {
                    console.log(resp);
                    alert("Could not load staff");
                });
        },
        methods: {
            deleteEntry(id, index) {
                alert(id+'-'+index)
                var app = this;
                this.$confirm(
                    {
                        message: 'Are you sure you want to '+(app.staff[index].block ? 'un' : '' )+'block '+app.staff[index].first_name+' ?',
                        button: {
                            no: 'No',
                            yes: 'Yes'
                        },
                        /**
                        * Callback Function
                        * @param {Boolean} confirm 
                        */
                        callback: confirm => {
                            var status = app.staff[index].block;
                            if (confirm) {
                                
                                axios.patch('/api/v1/staff/' + id,{
                                        block: status,
                                        only_edit_block: true,
                                    }
                                        
                                    ,{
                                        headers: app.$bearerAPITOKEN
                                    })
                                    .then(function (resp) {
                                        //app.products.splice(index, 1);
                                    })
                                    .catch(function (resp) {
                                        console.log(resp);
                                        alert("Could not block staff");
                                    });
                            }
                            else {
                                app.staff[index].block = !status;
                            } 
                        }
                    }
                )
            }
        }
    }
</script>
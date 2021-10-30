<template>
    <div>

        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">Create Staff Account</div>
                <router-link :to="{ name: 'indexStaff' }" class="back-enti-btn"><i class="bi bi-arrow-return-left"></i>&ensp;Back</router-link>
            </div>
            <form v-on:submit.prevent="saveForm()">
                <div v-show="errors.length > 0" id="error" class="alert alert-warning alert-dismissible fade show" role="alert">
                    <div v-for="item in errors">
                        <strong>Warning: </strong>{{item}}.
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" v-on:click="errors = []"></button>
                </div>
                <div class="row g-2">
                    <div class="col-md-6">
                        <label class="control-label">First name</label>
                        <input type="text" v-model.trim="staff.firstname" placeholder="First name" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="control-label">Last name</label>
                        <input type="text" v-model.trim="staff.lastname" placeholder="Last name" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="control-label">Username</label>
                        <input type="text" v-model.trim="staff.username" placeholder="Username" class="form-control">
                    </div>
                    <div class="col-md-9"></div>
                    <div class="col-md-3">
                        <label class="control-label">Roles</label>
                        <input type="text" class="form-control" v-model="roleSearch" placeholder="Search...">
                        <div class="overflow-auto mt-1 border rounded bg-white px-1" style="max-height: 100px">
                            <div class="form-check" v-for="(role, index) in searchRole" :key="role.id">
                                <input class="form-check-input" v-model="roleSelected" type="checkbox" :value="role" :id="'role_'+index">
                                <label class="form-check-label" :for="'role_'+index">
                                    {{ role.name }}
                                </label>
                            </div>
                            <label class="text-center" v-if="searchRole.length == 0">No result.</label>
                        </div>
                        <div class="mt-1">Selected: <span class="badge bg-primary mx-1" v-for="role, index in roleSelected" :key="index"><i class="bi bi-check2"></i>&ensp;{{ role.name }}</span></div>
                        <!-- <select v-model="product.category_id" class="form-select">
                            <option :value="null" selected>Choose product's category</option>
                            <option v-for="category, index in categories" :value="category.id">{{category.category_name}}</option>
                        </select> -->
                    </div>
                    <!-- <div class="col-sm-3 form-group">
                        <label class="control-label">Category name</label>
                        <input type="text" v-model="category.category_name" class="form-control">
                    </div>
                    <div class="col-sm-6 form-group">
                        <label class="control-label">Visible</label>
                        <select v-model="category.category_visible" class="form-control">
                          <option value="1">Show</option>
                          <option value="0">Hide</option>
                        </select>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <button class="m-1 btn btn-outline-primary">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

    export default {
        data: function () {
            return {
                staff: {
                    firstname: '',
                    lastname: '',
                    username: '',
                    roles: [],
                },
                roleSelected: [],
                roleSearch: null,
                roles: [],
                errors: [],
            }
        },
        mounted() {
            var app = this;
            app.loader = app.$loading.show();
            axios.get('/api/v1/roles',{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.roles = resp.data;
                    app.loader.hide();
                })
                .catch(function (resp) {
                    console.log(resp);
                    app.loader.hide();
                    app.handingError(resp,'Could not load list of roles','back');
                });
            
        },
        methods: {
            validate() {
                if (this.staff.firstname.length == 0)
                {
                    this.errors.push("First name is empty");
                }
                if (this.staff.lastname.length == 0)
                {
                    this.errors.push("Last name is empty");
                }
                if (this.staff.username.length == 0)
                {
                    this.errors.push("Username is empty");
                }
                if (this.roleSelected.length == 0)
                {
                    this.errors.push("Please select at least one role");
                }
            },
            saveForm() {
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0) {
                    var loader = app.$loading.show();
                    var newStaff = app.staff;
                    app.roleSelected.forEach((item) => {
                        newStaff.roles.push(item.id);
                    });
                    axios.post('/api/v1/staff', newStaff,{
                        headers: app.$bearerAPITOKEN
                    })
                    .then(function (resp) {
                        loader.hide();
                        app.$swal.fire({
                            title: 'Created!',
                            icon: 'success',
                            allowOutsideClick: false,
                            confirmButtonText: 'Close',
                            html: 
                                '<ul class="list-group text-start">'+
                                    '<li class="list-group-item  text-nowrap overflow-auto">'+
                                        '<strong>Username: </strong>'+ resp.data.username +
                                    '</li>'+
                                    '<li class="list-group-item text-nowrap overflow-auto">'+
                                        '<strong>Initial password: </strong>'+ resp.data.default_password +
                                    '</li>'+
                                '</ul>'+
                                '<div class="alert alert-warning m-2" role="alert">'+
                                   'Please make sure you have saved this account before closing. It only shows up once here!'+
                                '</div>'+
                                '<button class="btn btn-secondary mt-2" type="button" id="btn-copy"><i class="bi bi-clipboard"></i>&ensp;Copy Account</button>' ,
                            type: "success",
                            didOpen: () => {
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
                                const COPY_BUTTON = document.getElementById('btn-copy')
                                COPY_BUTTON.addEventListener('click', () => {
                                    var copied = copyStringWithNewLineToClipBoard('Username: '+ resp.data.username + '\nPassword: ' + resp.data.default_password);
                                    // COPY_TEXT.type = 'text';
                                    // COPY_TEXT.select();
                                    // COPY_TEXT.setSelectionRange(0,99999);/* For mobile devices */
                                    // var copied = document.execCommand("copy");
                                    // COPY_TEXT.type = 'hidden';
                                    if (copied) COPY_BUTTON.innerHTML = '<i class="bi bi-clipboard-check"></i>&ensp;Copied Account';
                                })
                            }
                        }).then((result) => {
                        if (result.isConfirmed) {
                            app.$router.push({name: 'indexStaff'});
                        }
                        });
                        
                    })
                    .catch(function (resp) {
                        console.log(resp);
                        loader.hide();
                        alert("Could not create staff");
                    });
                }
            }
        },
        computed: {
            searchRole() {
                var app = this;
                var data = app.roles;
                if(app.roleSearch)
                    data = data.filter((item)=>{
                            return app.roleSearch.toLowerCase().split(' ').every(v => item.name.toLowerCase().includes(v))
                        });

                return data;
            }
        }
    }
</script>
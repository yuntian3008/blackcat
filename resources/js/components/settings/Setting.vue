<template>
    <div>
        <div class="card-body row g-3">
            <div class="d-flex justify-content-between mb-2 align-items-center">
                <div class="card-title display-6 m-0">Settings</div>
                
            </div>
            <hr>
            <div class="col-6 row gx-1 gy-2">
            <!-- <button @click="filter()" class="filter-enti-btn"><i class="bi bi-search"></i>&ensp;Search</button> -->
                <table class="table table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th>Option</th>
                        <th>Value</th>
                        <th>Unit</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="setting, index in settings" :key="setting.id">
                            <td>
                                {{ capitalizeFirstLetter(setting.option.replace(/_/g, " ")) }}
                            </td>
                            <td>
                                <input class="form-control form-control-sm" :type="setting.option.includes('_time') ? 'number' : 'text'" :placeholder="setting.option" v-model="settings[index].value" >
                            </td>
                            <td>
                                {{ setting.option.includes('_time') ? "day" : "" }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="mt-4 btn btn-primary" @click="saveForm()">Save</button>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        mounted() {
            let app = this;
            axios.get('api/v1/settings/' ,{
                headers: app.$bearerAPITOKEN
            })
                .then(function (resp) {
                    app.settings = resp.data;
                })
                .catch(function () {
                    alert("Could not load settings")
                });
        },
        data: function () {
            return {
                settings: [],
                errors: [],
            }
        },
        methods: {
            validate() {
                var app = this;
                for (let key in app.settings) {
                    if (app.settings[key].value === '')
                    {
                        app.errors.push(app.settings[key].option + " is empty");
                    }
                    if (app.settings[key].option.includes("_time")) 
                    {
                        if (app.settings[key].value < 1)
                        {
                            app.errors.push(app.settings[key].option + " has invalid time.");
                        }
                    }
                }
                
            },
            capitalizeFirstLetter(string) {
              return string.charAt(0).toUpperCase() + string.slice(1);
            },
            saveForm() {
                event.preventDefault();
                var app = this;
                app.errors = [];
                app.validate();
                if (app.errors.length == 0) {
                    var newSetting = app.settings;
                    axios.patch('api/v1/settings/'+ 0, newSetting,{
                        headers: app.$bearerAPITOKEN
                    })
                        .then(function (resp) {
                            app.$swal.fire({
                                title: 'Saved!',
                                showConfirmButton: false,
                                icon: 'success',
                                timer: 1500,
                            });
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.$swal.fire({
                                title: 'Could not save settings!',
                                showConfirmButton: false,
                                icon: 'error',
                                timer: 1500,
                            });
                        });
                }
            }
        }
    }
</script>
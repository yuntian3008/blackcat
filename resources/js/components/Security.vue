<template>
    <div>
        <h5 class="card-title">Change password</h5>
        <form v-on:submit="changePassword()">
            <div class="row">
                    <div class="col-sm-4 form-group">
                        <label class="control-label">Current password</label>
                        <input type="text" class="form-control" v-model="data.currentPassword">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="control-label">New password</label>
                        <input type="text" class="form-control" v-model="data.newPassword">
                    </div>
                    <div class="col-sm-4 form-group">
                        <label class="control-label">Confirm password</label>
                        <input type="text" class="form-control" v-model="data.confirmPassword">
                    </div>
            </div>
            <div class="row" v-show="success.changepassword">
                <div class="col-sm-12 form-group">
                    <div class="alert alert-success" role="alert">
                    {{message.changepassword}}
                    </div>
                </div>
            </div>
            <div class="row" v-show="error.changepassword">
                <div class="col-sm-12 form-group">
                    <div class="alert alert-danger" role="alert">
                    {{message.changepassword}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 form-group">
                    <button class="btn btn-outline-primary">Save</button>
                </div>
            </div>
        </form>
        <h5 class="card-title">Reset Token</h5>
        <div class="row" v-show="success.resettoken">
            <div class="col-sm-12 form-group">
                <div class="alert alert-success" role="alert">
                    {{message.resettoken}}
                    Redirect after {{countDown}} seconds!
                </div>
            </div>
        </div>
        <div class="row" v-show="error.resettoken">
            <div class="col-sm-12 form-group">
                <div class="alert alert-danger" role="alert">
                    {{message.resettoken}}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group">
                <button class="btn btn-outline-danger" v-on:click="resetToken">Reset</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                success: {
                    changepassword: false,
                    resettoken: false,
                },
                error: {
                    changepassword: false,
                    resettoken: false,
                },
                data: {
                    currentPassword: '',
                    newPassword: '',
                    confirmPassword: '',
                },
                message: {
                    changepassword: '',
                    resettoken: '',
                },
                countDown : 5,
            }
        },
        methods: {
            back() {
                if(this.countDown > 0) {
                    setTimeout(() => {
                        this.countDown -= 1
                        this.back()
                    }, 1000)
                }
                else
                    location.href = '/admin';
            },  
            changePassword() {
                event.preventDefault();
                var app = this;
                var send = app.data;
                axios.post('/user/changepassword',send)
                    .then(function (resp) {
                        if (resp.data.error)
                        {
                            app.success.changepassword = false;
                            app.error.changepassword = true;
                        }
                        else
                        {
                            app.error.changepassword = false;
                            app.success.changepassword = true;
                        }
                        app.message.changepassword = resp.data.message;
                        console.log(resp);
                    })
                    .catch(function (resp) {
                        console.log(resp);
                    });
            },
            resetToken() {
                event.preventDefault();
                var app = this;
                var send = app.data;
                axios.post('/user/resettoken')
                    .then(function (resp) {
                        if (!resp.data.error)
                        {
                            app.success.resettoken = true;
                        }
                        app.message.resettoken
                            = resp.data.message;
                        app.back();
                        console.log(resp);
                    })
                    .catch(function (resp) {
                        console.log(resp);
                    });

            },  
        }
    }
</script>
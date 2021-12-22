<template>
    <div>
        <div class="card-body">
            <div class="d-flex justify-content-between mb-2">
                <div class="card-title h3 m-0">Create a new supplier</div>
                <router-link :to="{ name: 'indexProduct' }" class="back-enti-btn"><i class="bi bi-arrow-return-left"></i>&ensp;Back</router-link>
            </div>
            <form>
                <div class="row g-2">
                    <div class="col-md-3">
                        <label class="form-label">Company name</label>
                        <input type="text" v-model.trim="supplier.company_name" :class="errors.company_name.length ? 'form-control is-invalid' : 'form-control'" aria-describedby="validationCompanyName">
                        <div id="validationCompanyName" class="invalid-feedback">
                            {{ errors.company_name[0] }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Email</label>
                        <input type="email" v-model.trim="supplier.email" :class="errors.email.length ? 'form-control is-invalid' : 'form-control'" aria-describedby="validationEmail">
                        <div id="validationCompanyName" class="invalid-feedback">
                            {{ errors.email[0] }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone</label>
                        <input type="text" v-model.trim="supplier.phone" :class="errors.phone.length ? 'form-control is-invalid' : 'form-control'" aria-describedby="validationPhone">
                        <div id="validationCompanyName" class="invalid-feedback">
                            {{ errors.phone[0] }}
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Address</label>
                        <input type="text" v-model.trim="supplier.address" :class="errors.address.length ? 'form-control is-invalid' : 'form-control'" aria-describedby="validationAddress">
                        <div id="validationCompanyName" class="invalid-feedback">
                            {{ errors.address[0] }}
                        </div>
                    </div>
                </div>
                
                <div class="row g-1 mt-2">
                    <div class="col-sm-12 form-group">
                        
                        <button class="m-1 btn btn-outline-primary" @click="saveForm()">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>

    export default {
        components: {
            //
        },
        data: function () {
            return {
                supplier: {
                    company_name: '',
                    email: '',
                    phone: '',
                    address: '',
                },
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
            validate() {
                if (this.imageUpload == null)
                {
                    this.errors.push("Please upload and save image before continue");
                }
                if (this.product.product_name === '')
                {
                    this.errors.push("Product name is empty");
                }
                if (!this.product.category_id)
                {
                    this.errors.push("Category is empty");
                }
                if (this.product.product_price === 0)
                {
                    this.errors.push("Price isn't valid");
                }
                if (this.product.product_desc === '')
                {
                    this.errors.push("Description is empty");
                }
                if (this.categories.length == 0)
                {
                    this.errors.push("Please create category before");
                }

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
                axios.post('/api/v1/suppliers', app.supplier,{
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
                                app.$router.push({name: 'indexSupplier'});
                            });
                        })
                        .catch(function (resp) {
                            console.log(resp);
                            app.errors = resp.response.data.errors;
                            loader.hide();
                        });
            }
        }
    }
</script>
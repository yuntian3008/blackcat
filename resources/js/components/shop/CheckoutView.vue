<template>
    <div class="flex flex-col md:w-full">
        <h2 class="mb-4 font-bold md:text-xl text-heading ">Delivery information
        </h2>
        <div class="justify-center w-full mx-auto">
                <div class="space-x-0 lg:flex lg:space-x-4">
                    <div class="w-full lg:w-1/2">
                        <label for="firstName" class="block mb-3 text-sm font-semibold text-gray-500">First
                            Name</label>
                        <input type="text" v-model="user.firstname" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" disabled />
                    </div>
                    <div class="w-full lg:w-1/2 ">
                        <label for="firstName" class="block mb-3 text-sm font-semibold text-gray-500">Last
                            Name</label>
                        <input type="text" v-model="user.lastname" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" disabled />
                    </div>
                </div>
                <div class="mt-4 space-x-0 lg:flex lg:space-x-4">
                    <div class="w-full lg:w-1/2">
                        <label for="Email"
                            class="block mb-3 text-sm font-semibold text-gray-500">Email</label>
                        <input type="text" v-model="user.email" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" disabled />
                    </div>
                    <div class="w-full lg:w-1/2">
                        <label for="Phone"
                            class="block mb-3 text-sm font-semibold text-gray-500">Phone</label>
                        <input type="text" v-model="user.phone" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" disabled />
                    </div>
                </div>
        </div>
        <h2 class="my-4 font-bold md:text-xl text-heading ">Delivery address
        </h2>
        <div class="justify-center w-full mx-auto">
                <div class="mt-4" v-show="addresses.length > 0">
                    <div class="w-full">
                        <label for="caddress"
                            class="block mb-3 text-sm font-semibold text-gray-500">Choose address</label>
                        <select id="caddress" class="rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" @change="choose" v-model="address_index">
                            <option v-for="item, index in addresses" :value="index">{{item.address}}, {{item.ward}}, {{item.district}}, {{item.province}}, {{item.country}}</option>
                            <option :value="-1">Other address</option>
                        </select>
                    </div>
                </div>
                <div id="other-address" v-show="address_index == -1 || addresses.length == 0">
                    <div class="mt-4 space-x-0 lg:flex lg:space-x-4">
                        <div class="w-full lg:w-1/2">
                            <label for="country"
                                class="block mb-3 text-sm font-semibold text-gray-500">Country</label>
                            <input type="text" class="disabled:opacity-50 rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" v-model="address.country" id="country" :disabled="address_index >= 0 && addresses.length > 0">
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label for="province"
                                class="block mb-3 text-sm font-semibold text-gray-500">Province</label>
                            <input type="text" class="disabled:opacity-50 rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" v-model="address.province" id="province" :disabled="address_index >= 0 && addresses.length > 0">
                        </div>
                    </div>
                    <div class="mt-4 space-x-0 lg:flex lg:space-x-4">
                        <div class="w-full lg:w-1/2">
                            <label for="district"
                                class="block mb-3 text-sm font-semibold text-gray-500">District</label>
                            <input type="text" class="disabled:opacity-50 rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" v-model="address.district" id="district" :disabled="address_index >= 0 && addresses.length > 0">
                        </div>
                        <div class="w-full lg:w-1/2">
                            <label for="ward"
                                class="block mb-3 text-sm font-semibold text-gray-500">Ward</label>
                            <input type="text" class="disabled:opacity-50 rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" v-model="address.ward" id="ward" :disabled="address_index >= 0 && addresses.length > 0">
                        </div>
                    </div>
                    <div class="mt-4">
                        <div class="w-full">
                            <label for="address"
                                class="block mb-3 text-sm font-semibold text-gray-500">Address</label>
                            <textarea
                                class="disabled:opacity-50 w-full px-4 py-3 text-xs rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base"
                                id="address" cols="20" rows="4" v-model="address.address":disabled="address_index >= 0 && addresses.length > 0"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <div class="w-full">
                        <label for="Phone"
                            class="block mb-3 text-sm font-semibold text-gray-500">Other Number Phone (Optional)</label>
                        <input type="text" 
                            class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base" v-model="phone">
                    </div>
                </div>

                <!-- <div class="flex items-center mt-4">
                    <label class="flex items-center text-sm group text-heading">
                        <input type="checkbox"
                            class="w-5 h-5 border border-gray-300 rounded focus:outline-none focus:ring-1">
                        <span class="ml-2">Save this information for next time</span></label>
                </div>
                <div class="relative pt-3 xl:pt-6"><label for="note"
                        class="block mb-3 text-sm font-semibold text-gray-500"> Notes
                        (Optional)</label><textarea name="note"
                        class="flex items-center w-full px-4 py-3 text-sm border border-gray-300 rounded focus:outline-none focus:ring-1 focus:ring-blue-600"
                        rows="4" placeholder="Notes for delivery"></textarea>
                </div> -->
        </div>
        <h2 class="my-4 font-bold md:text-xl text-heading ">Payment
        </h2>
        <div class="flex flex-col gap-8">
            <label class="inline-flex items-center">
                <input type="radio" name="vehicle" class="h-5 w-5 text-gray-700" v-model="payment" value="cash"/>
                <span class="ml-2 gap-x-2 inline-flex items-center" >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Cash payment upon delivery
                </span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="vehicle" class="h-5 w-5 text-gray-700" v-model="payment" value="card"/>
                <span class="ml-2 gap-x-2 inline-flex items-center">
                    <div class="inline-flex gap-x-2">
                      <img class="h-5 w-5" src="assets/images/payment/visa.svg" alt="visa">
                      <img class="h-5 w-5" src="assets/images/payment/mastercard.svg" alt="mastercard">
                      <img class="h-5 w-5" src="assets/images/payment/jcb.svg" alt="jcb">
                    </div>
                    International card payment Visa, Master, JCB
                </span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="vehicle" class="h-5 w-5 text-gray-700" v-model="payment" value="momo"/>
                <span class="ml-2 gap-x-2 inline-flex items-center">
                    <img class="h-5 w-5" src="assets/images/payment/momo.svg" alt="momo">
                    MoMo wallet payment
                </span>
            </label>
            <label class="inline-flex items-center">
                <input type="radio" name="vehicle" class="h-5 w-5 text-gray-700" v-model="payment" value="zalo"/>
                <span class="ml-2 gap-x-2 inline-flex items-center">
                    <img class="h-5 w-5" src="assets/images/payment/zalopay.svg" alt="momo">
                    Zalopay wallet payment
                </span>
            </label>
        </div>
        <div class="flex items-center gap-8">
            <button type="button" @click="order()" class="flex items-center justify-center w-full px-10 py-3 mt-6 font-medium text-white uppercase bg-gray-700 rounded-full shadow hover:bg-gray-700 focus:shadow-outline focus:outline-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
              <span class="ml-2 mt-5px">Order</span>
            </button>
        </div>
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
    export default {
        components: {
            Loading,
        },
        props: ['temporaryAmount','addresses','user',],
        data() {
            return {
                isLoading: false,
                fullPage: true,
                address: {
                    address:'',
                    country: '',
                    created_at: '',
                    district: '',
                    province: '',
                    ward: '',
                },
                phone: '',
                address_index: 0,
                payment: 'cash',
            }
        },
        mounted() {
            var app = this;
            if (app.addresses.length > 0) {
                app.address = app.addresses[0];
            }
            
            
        },
        methods: {
            choose: function () {
                var app = this;
                if (app.address_index >= 0)
                    app.address = app.addresses[app.address_index];
                else app.address = {
                    address:'',
                    country: '',
                    created_at: '',
                    district: '',
                    province: '',
                    ward: '',
                }
            },
            order: function () {
                var app = this;
                axios.post('api/customer/orders', {
                    country : app.address.country,
                    province : app.address.province,
                    district : app.address.district,
                    ward : app.address.ward,
                    address : app.address.address,
                    phone : app.phone,
                    payment : app.payment,
                    newAddress : (app.address_index < 0 || app.addresses.length == 0) ? true : false,
                },{
                        headers: app.$bearerAPITOKEN
                    })
                .then(function (resp) {
                    app.$swal.fire({
                        title: resp.data.message,
                        showConfirmButton: false,
                        icon: 'success',
                        timer: 1500,
                    }).then((result) => {
                        location.href = resp.data.next;
                    });
                })
                .catch(function (resp) {
                    var errors = resp.response.data.errors;
                    for(var k in errors) {
                        app.$swal.fire({
                          icon: 'error',
                          title: k,
                          text: errors[k],
                        });
                    }
                    
                });
            }
        },
        computed: {
            total: function(){
                let sum = 0;
                this.cartItem.forEach(function(item) {
                    sum+= item.quantity;
                });

                return sum;
            }
        },
    }
</script>

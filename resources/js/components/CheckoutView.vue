<template>
    <div>
        <!-- Card -->
        <div class="card mb-3">
          <div class="card-body pt-4">
            <div class="d-flex justify-content-between">
                <a href="/cart" class="text-brown text-decoration-none"><i class="mr-1 fas fa-chevron-left"></i>Back to cart</a>
            </div>
            <div class="d-flex justify-content-between">
              <h2 class="mb-4">Order</h2>
            </div>
            

            <form>
                <h5>Delivery information</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">First name: <strong>{{ user.firstname }}</strong></li>
                    <li class="list-group-item">Last name: <strong>{{ user.lastname }}</strong></li>
                    <li class="list-group-item">Phone number: <strong>{{ user.phone }}</strong></li>
                    <li class="list-group-item">Email: <strong>{{ user.email }}</strong></li>
                </ul>
                <hr>
                <div class="d-flex justify-content-between">
                    <h5>Delivery address</h5>
                    <select class="form-control form-control-sm" style="width: 30%" @change="choose" v-model="address_index">
                        <option v-for="item, index in addresses" :value="index">{{item.address}}</option>
                        <option :value="-1">Other address</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputFname">Country</label>
                      <input type="text" class="form-control form-control-sm" v-model="address.country" id="inputFname" :disabled="address_index >= 0">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputLname">Province</label>
                      <input type="text" class="form-control form-control-sm" v-model="address.province" id="inputLname" :disabled="address_index >= 0">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPhone">District</label>
                        <input type="text" class="form-control form-control-sm" v-model="address.district" id="inputPhone" :disabled="address_index >= 0">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="inputAddress">Ward</label>
                        <input type="text" class="form-control form-control-sm" v-model="address.ward" id="inputAddress" :disabled="address_index >= 0">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control form-control-sm" v-model="address.address" id="inputAddress" :disabled="address_index >= 0">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAddress">Other Phone</label>
                        <input type="text" placeholder="(Optional)" class="form-control form-control-sm" v-model="phone" id="inputAddress">
                    </div>
                </div>
              <!-- <div class="form-group">
                <label class="d-block">Address type</label>
                <div class="form-check form-check-inline fsize-16">
                  <input class="form-check-input" type="radio" name="addressType" id="inlineRadio1" value="option1">
                  <label class="form-check-label" for="inlineRadio1">Private Houses / Condominiums</label>
                </div>
                <div class="form-check form-check-inline fsize-16">
                  <input class="form-check-input" type="radio" name="addressType" id="inlineRadio2" value="option2">
                  <label class="form-check-label" for="inlineRadio2">Agency/Company</label>
                </div>
              </div> -->
            </form>
            <hr class="mb-4">

            <p class="text-primary mb-0 text-brown" id="endCart"><i class="fas fa-info-circle mr-1"></i> Do not delay the purchase, adding
              items to your cart does not mean booking them.</p>

          </div>
        </div>
        <!-- Card -->

        <!-- Card -->
        <div class="card">
          <div class="card-body pt-4">

            <h5 class="mb-4">Expected shipping delivery</h5>

            <p class="mb-0" id="timeShip"></p>
          </div>
        </div>
        <!-- Card -->

        <!-- Card -->
        <div class="card">
          <div class="card-body pt-4">

            <h5 class="mb-4">Payment</h5>

            <div class="form-group">
                <div class="form-check fsize-20">
                  <input class="form-check-input" type="radio" v-model="payment" id="cashPayment" value="cash">
                  <label class="form-check-label" for="cashPayment"><i class="far fa-money-bill-alt mr-2"></i>Cash payment upon delivery</label>
                </div>
                <div class="form-check fsize-20">
                  <input class="form-check-input" type="radio" v-model="payment" id="cardPayment" value="card">
                  <label class="form-check-label" for="cardPayment"><i class="far fa-credit-card mr-2"></i>International card payment Visa, Master, JC / Paypal
                    <div class="d-block">
                      <img width="24" src="assets/images/payment/visa.svg" alt="visa">
                      <img width="24" src="assets/images/payment/mastercard.svg" alt="mastercard">
                      <img width="24" src="assets/images/payment/jcb.svg" alt="jcb">
                      /
                      <i class="fab fa-cc-paypal"></i>
                    </div>
                  </label>
                  
                </div>
                <div class="form-check fsize-20">
                  <input class="form-check-input" type="radio" v-model="payment" id="momoPayment" value="momo">
                  <label class="form-check-label" for="momoPayment"><img class="mr-2" width="24" src="assets/images/payment/momo.svg" alt="momo">MoMo wallet payment</label>
                </div>
                <div class="form-check fsize-20">
                  <input class="form-check-input" type="radio" v-model="payment" id="zaloPayment" value="zalo">
                  <label class="form-check-label" for="zaloPayment"><img class="mr-2" width="24" src="assets/images/payment/zalopay.svg" alt="zalo">Zalopay wallet payment</label>
                </div>
              </div>
                <form method="POST" action="/order/create">
                    <input type="hidden" name="_token" :value="$csrfToken">
                    <input type="hidden" name="country" :value="address.country">
                    <input type="hidden" name="province" :value="address.province">
                    <input type="hidden" name="district" :value="address.district">
                    <input type="hidden" name="ward" :value="address.ward">
                    <input type="hidden" name="address" :value="address.address">
                    <input type="hidden" name="phone" :value="phone">
                    <input type="hidden" name="payment" :value="payment">
                    <input type="hidden" name="newAddress" :value="address_index < 0 ? true : false">
                    <input type="hidden" name="phone" :value="user.phone">
                    <button type="submit" class="btn btn-danger btn-block">ORDER</button>
                </form>
          </div>
        </div>
        <!-- Card -->
    </div>
</template>

<script>
import Loading from 'vue-loading-overlay'
import 'vue-loading-overlay/dist/vue-loading.css'
    export default {
        components: {
            Loading,
        },
        props: ['shipping','temporaryAmount','totalAmount','addresses','user',],
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
            app.address = app.addresses[0];
            // var app = this;
            // app.isLoading = true;
            // axios.post('/carts', {
            //         secret: document.querySelector("meta[name='api-token']").getAttribute('content'),
            //     },{
            //         _token: app.$csrfToken,
            //     })
            //     .then(function (resp) {
            //         app.cartItems = resp.data;
            //         app.$root.$emit("updateTotal",app.cartItems);
            //         app.isLoading = false;
            //         //console.log(resp);
            //     })
            //     .catch(function () {
            //         alert("Could not load your product")
            //     });
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

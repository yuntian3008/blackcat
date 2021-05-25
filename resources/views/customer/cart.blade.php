@extends('layouts.web')

@section('title')
@endsection

@section('style')

@endsection

@section('main-class')
mt-5
@endsection

@section('nav-cart-class')
style="display: none;"
@endsection

@section('content')
<div class="container bg-white py-3 mt-4">
        <!--Section: Block Content-->
      <section>

        <!--Grid row-->
        <div class="row card-border-0">

          <!--Grid column-->
          <div class="col-lg-8">

            <!-- Card -->
            <div class="card mb-3">
              <div class="card-body pt-4">
                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="text-brown text-decoration-none"><i class="mr-1 fas fa-chevron-left"></i>Back</a>
                </div>
                <cart-view></cart-view>
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
            <!-- <div class="card mb-3">
              <div class="card-body pt-4">

                <h5 class="mb-4">We accept</h5>

                <img class="mr-2" width="45px"
                  src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/visa.svg"
                  alt="Visa">
                <img class="mr-2" width="45px"
                  src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/amex.svg"
                  alt="American Express">
                <img class="mr-2" width="45px"
                  src="https://mdbootstrap.com/wp-content/plugins/woocommerce-gateway-stripe/assets/images/mastercard.svg"
                  alt="Mastercard">
                <img class="mr-2" width="45px"
                  src="https://mdbootstrap.com/wp-content/plugins/woocommerce/includes/gateways/paypal/assets/images/paypal.png"
                  alt="PayPal acceptance mark">
              </div>
            </div> -->
            <!-- Card -->

          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-lg-4">

            <!-- Card -->
            <div class="card mb-3">
                <cart-view-total-amount></cart-view-total-amount>
            </div>
            <!-- Card -->

            <!-- Card -->
            {{-- <div class="card mb-3">
              <div class="card-body pt-4">

                <a class="dark-grey-text d-flex justify-content-between text-brown" data-toggle="collapse" href="#collapseExample"
                  aria-expanded="false" aria-controls="collapseExample">
                  Add a discount code (optional)
                  <span><i class="fas fa-chevron-down pt-1"></i></span>
                </a>

                <div class="collapse" id="collapseExample">
                  <div class="mt-3">
                    <div class="md-form md-outline mb-0">
                      <input type="text" id="discount-code" class="form-control font-weight-light"
                        placeholder="Enter discount code">
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
            <!-- Card -->

          </div>
          <!--Grid column-->

        </div>
        <!-- Grid row -->

      </section>
        <!--Section: Block Content-->
    </div>

@endsection
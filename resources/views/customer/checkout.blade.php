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

            <checkout-view :shipping="{{ $shipping }}" :temporaryAmount="{{ $temporaryAmount }}" :totalAmount="{{ $totalAmount }}" :addresses="{{ $addresses }}" :user="{{ $user }}"></checkout-view>

          </div>
          <!--Grid column-->

          <!--Grid column-->
          <div class="col-lg-4">

            <!-- Card -->
            <div class="card mb-3">
              <div class="card-body pt-4">
                  <h5 class="mb-3">The total amount of</h5>

                  <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                      Temporary amount
                      <span id="total" class="font-weight-bold">$ {{ $temporaryAmount}}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                      Shipping
                      <span>{{ $shipping == 0 ? "Gratis" : "$ ".$shipping  }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                      <div>
                        <strong>The total amount of</strong>
                        <strong>
                          <p class="mb-0">(including VAT)</p>
                        </strong>
                      </div>
                      <span><strong id="total-final">$ {{ $totalAmount }}</strong></span>
                    </li>
                  </ul>
              </div>
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
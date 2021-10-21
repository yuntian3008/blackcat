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
<section class="bg-white dark:bg-gray-900" id="shop">
  <div class="container px-6 py-8 mx-auto">
      <div class="lg:flex lg:-mx-2">
        <div class="flex-1">
          <cart-view></cart-view>
          <hr class="pb-6 mt-6">
          <div class="my-4 mt-4 -mx-2 lg:flex">
            <div class="lg:px-2 lg:w-1/2">
              {{-- <div class="p-4 bg-gray-100 rounded-full">
                <h1 class="ml-2 font-bold uppercase">Coupon Code</h1>
              </div>
              <div class="p-4">
                <p class="mb-4 italic">If you have a coupon code, please enter it in the box below</p>
                <div class="justify-center md:flex">
                  <form action="" method="POST">
                      <div class="flex items-center w-full h-13 pl-3 bg-white bg-gray-100 border rounded-full">
                        <input type="coupon" name="code" id="coupon" placeholder="Apply coupon" value="90off"
                                class="w-full bg-gray-100 outline-none appearance-none focus:outline-none active:outline-none"/>
                          <button type="submit" class="text-sm flex items-center px-3 py-1 text-white bg-gray-800 rounded-full outline-none md:px-4 hover:bg-gray-700 focus:outline-none active:outline-none">
                            <svg aria-hidden="true" data-prefix="fas" data-icon="gift" class="w-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M32 448c0 17.7 14.3 32 32 32h160V320H32v128zm256 32h160c17.7 0 32-14.3 32-32V320H288v160zm192-320h-42.1c6.2-12.1 10.1-25.5 10.1-40 0-48.5-39.5-88-88-88-41.6 0-68.5 21.3-103 68.3-34.5-47-61.4-68.3-103-68.3-48.5 0-88 39.5-88 88 0 14.5 3.8 27.9 10.1 40H32c-17.7 0-32 14.3-32 32v80c0 8.8 7.2 16 16 16h480c8.8 0 16-7.2 16-16v-80c0-17.7-14.3-32-32-32zm-326.1 0c-22.1 0-40-17.9-40-40s17.9-40 40-40c19.9 0 34.6 3.3 86.1 80h-86.1zm206.1 0h-86.1c51.4-76.5 65.7-80 86.1-80 22.1 0 40 17.9 40 40s-17.9 40-40 40z"/></svg>
                            <span class="font-medium">Apply coupon</span>
                          </button>
                      </div>
                  </form>
                </div>
              </div> --}}
              {{-- <div class="p-4 bg-gray-100 rounded-full">
                <h1 class="ml-2 font-bold uppercase">Note for seller</h1>
              </div>
              <div class="p-4">
                <p class="mb-4 italic">If you have some information for the seller you can leave them in the box below</p>
                <textarea class="w-full h-24 p-2 bg-gray-100 rounded"></textarea>
              </div> --}}
            </div>
              <cart-view-total-amount></cart-view-total-amount>
          </div>
        </div>
      </div>
  </div>
</section>
{{-- <div class="container bg-white py-3 mt-4" id="shop">
  <section>
    <div class="row card-border-0">
      <div class="col-lg-8">
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
        <div class="card">
          <div class="card-body pt-4">

            <h5 class="mb-4">Expected shipping delivery</h5>

            <p class="mb-0" id="timeShip"></p>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card mb-3">
            <cart-view-total-amount></cart-view-total-amount>
        </div>
      </div>
    </div>
  </section>
</div> --}}

@endsection

@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection
@extends('layouts.web')
@inject('imageProcessing', 'App\Components\Helper\ImageProcessing')
@inject('product','App\Product')

@section('title')
{{ __('Check out') }}
@endsection

@section('style')
<style>
  .h-96{
    height: 24rem;  
  }
</style>
@endsection

@section('main-class')
mt-5
@endsection

@section('nav-cart-class')
style="display: none;"
@endsection

@section('content')
<div class="container px-6 py-8 mx-auto" id="shop">
    <div class="flex flex-col w-full px-0 mx-auto md:flex-row">
        <checkout-view :temporaryAmount="{{ $temporaryAmount }}" :addresses="{{ $addresses }}" :user="{{ $user }}"></checkout-view>
        <div class="flex flex-col w-full ml-0 lg:ml-12 lg:w-2/5">
            <div class="pt-12 md:pt-0 2xl:ps-4">
                <h2 class="text-xl font-bold">Order Summary
                </h2>
                <div class="my-8">
                  <div class="overflow-auto h-96">
                    <div class="flex flex-col space-y-4">
                        @foreach ($cartItem as $item)
                          <div class="flex space-x-4">
                            <div>
                                <img src="{{ $imageProcessing->getURL($product->find($item->product_id)->product_image,'sm') }}" alt="image"
                                    class="w-60">
                            </div>
                            <div>
                                <h2 class="text-xl font-bold">{{ strlen($product->find($item->product_id)->product_name) > 30 ? substr($product->find($item->product_id)->product_name,0,30)."..." : $product->find($item->product_id)->product_name }}</h2>
                                {{-- <p class="text-sm">{{ $product->find($item->product_id)->product_desc }}</p> --}}
                                <strong class="text-gray-700 mr-3">Price:</strong>$ {{ number_format($product->find($item->product_id)->product_price,2) }} x {{ $item->quantity }}
                            </div>
                          </div>
                        @endforeach
                    </div>
                  </div>
                  
                </div>
                <div
                    class="flex items-center w-full py-4 text-xl font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:pb-0">
                    Subtotal:<span class="ml-2">$ {{ number_format($temporaryAmount,2) }}</span></div>
                <div
                    class="flex items-center w-full py-4 text-xl font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:pb-0">
                    Shipping:  <span class="ml-2">Gratis</span>{{-- <span class="ml-2">{{ $shipping == 0 ? "Gratis" : "$ " .number_format($shipping,2) }}</span> --}}</div>
                <div
                    class="flex items-center w-full py-4 text-xl font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:pb-0">
                    Total:<span class="ml-2">$ {{ number_format($temporaryAmount+0,2) }}</span></div>
            </div>
        </div>
    </div>
</div>

@endsection


@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection
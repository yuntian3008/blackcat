@extends('layouts.web')
@inject('imageProcessing', 'App\Components\Helper\ImageProcessing')
@inject('product','App\Product')
@inject('review','App\Review')

@section('title')
{{ __('Order #'.$order->id) }}
@endsection

@section('vue-id')
id="shop"
@endsection
@section('search-input')
<search-input></search-input>
@endsection
@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection

@section('style')
<style type="text/css">
	.icon::before {
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
  }
	body {
    color: #000;
    overflow-x: hidden;
    height: 100%;
    background-repeat: no-repeat
}

.card {
    z-index: 0;
    background-color: #ffffff;
    padding-bottom: 20px;
    margin-top: 90px;
    margin-bottom: 90px;
    border-radius: 10px
}

.top {
    padding-top: 40px;
    padding-left: 13% !important;
    padding-right: 13% !important
}

#progressbar {
    margin-bottom: 30px;
    overflow: hidden;
    color: #455A64;
    padding-left: 0px;
    margin-top: 30px
}

#progressbar li {
    list-style-type: none;
    font-size: 13px;
    width: 25%;
    float: left;
    position: relative;
    font-weight: 400
}

#progressbar .step0:before {
    font-family: "Font Awesome 5 Free";
    content: "\f111";
    color: #fff;
    font-weight: 900;
}

#progressbar li:before {
    width: 40px;
    height: 40px;
    line-height: 45px;
    display: block;
    font-size: 20px;
    background: #fbf1e9;
    border-radius: 50%;
    margin: auto;
    padding: 0px
}

#progressbar li:after {
    content: '';
    width: 100%;
    height: 12px;
    background: #fbf1e9;
    position: absolute;
    left: 0;
    top: 16px;
    z-index: -1
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px;
    position: absolute;
    left: -50%
}

#progressbar li:nth-child(2):after,
#progressbar li:nth-child(3):after {
    left: -50%
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
    position: absolute;
    left: 50%
}

#progressbar li:last-child:after {
    border-top-right-radius: 10px;
    border-bottom-right-radius: 10px
}

#progressbar li:first-child:after {
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px
}

#progressbar li.active:before,
#progressbar li.active:after {
    background: #bb6b24
}

#progressbar li.active:before {
    font-family: "Font Awesome 5 Free";
    content: "\f00c";
    font-weight: 900;
}


@media screen and (max-width: 992px) {
    .icon-content {
        width: 50%
    }
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
<div class="container mx-auto">
    <div class="flex flex-col gap-y-10">
        <div class="flex justify-between px-10 mt-5">
            <h1 class="text-2xl font-extrabold uppercase">
                Order #{{ $order->id }}
            </h1>
            @if($order->getStatus()['status'] == 1)
            <form id="cancelForm" action="{{ route('customer.order.cancel')}}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $order->id }}">
                <button
                class="flex items-center gap-x-3 text-red-500 background-transparent font-bold uppercase px-3 py-1 text-xs outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg><span> Cancel Order</span>
                </button>
            </form>
            @endif
            
        </div>
        <div class="shadow-xl rounded-lg py-10">
            <div class="flex px-10">
                <h1 class="text-xl font-bold">
                    #Order Status
                </h1>
            </div>
            @if ($order->getStatus()['status'] > 0)
            <div class="flex px-5">
                <div class="py-10 px-10 w-full">
                    <div class="mx-4 p-4">
                        <div class="flex items-center">
                            <div class="flex items-center {{ !empty($order->request_date) ? "text-white" : "text-gray-500" }} relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2{{ !empty($order->request_date) ? " bg-gray-700 border-gray-700" : " border-gray-300" }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-700">
                                    Order has been initiated
                                </div>
                                <div class="absolute bottom-0 -ml-10 text-center mb-16 w-32 text-xs font-medium uppercase text-gray-700">
                                    {{ !empty($order->request_date) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->request_date)->format('H:i - d/m/Y') : "" }}
                                </div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-{{ empty($order->get_date) ? "300" : "700" }}"></div>
                            <div class="flex items-center {{ !empty($order->get_date) ? "text-white" : "text-gray-500" }} relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2{{ !empty($order->get_date) ? " bg-gray-700 border-gray-700" : " border-gray-300" }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                    </svg>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-700">
                                We are preparing your order
                                </div>
                                <div class="absolute bottom-0 -ml-10 text-center mb-16 w-32 text-xs font-medium uppercase text-gray-700">
                                    {{ !empty($order->get_date) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->get_date)->format('H:i - d/m/Y') : "" }}
                                </div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-{{ empty($order->ship_date) ? "300" : "700" }}"></div>
                            <div class="flex items-center {{ !empty($order->ship_date) ? "text-white" : "text-gray-500" }} relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2{{ !empty($order->ship_date) ? " bg-gray-700 border-gray-700" : " border-gray-300" }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">
                                Order is being shipped
                                </div>
                                <div class="absolute bottom-0 -ml-10 text-center mb-16 w-32 text-xs font-medium uppercase text-gray-700">
                                    {{ !empty($order->ship_date) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->ship_date)->format('H:i - d/m/Y') : "" }}
                                </div>
                            </div>
                            <div class="flex-auto border-t-2 transition duration-500 ease-in-out border-gray-{{ empty($order->completion_date) ? "300" : "700" }}"></div>
                            <div class="flex items-center {{ !empty($order->completion_date) ? "text-white" : "text-gray-500" }} relative">
                                <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 py-3 border-2{{ !empty($order->completion_date) ? " bg-gray-700 border-gray-700" : " border-gray-300" }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-full w-full" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                    </svg>
                                </div>
                                <div class="absolute top-0 -ml-10 text-center mt-16 w-32 text-xs font-medium uppercase text-gray-500">
                                Order is completed
                                </div>
                                <div class="absolute bottom-0 -ml-10 text-center mb-16 w-32 text-xs font-medium uppercase text-gray-700">
                                    {{ !empty($order->completion_date) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->completion_date)->format('H:i - d/m/Y') : "" }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div
                class="block text-sm text-left text-white bg-gray-500 h-12 flex items-center p-4 rounded-md my-5 mx-10"
                role="alert"
                >
                <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                class="w-6 h-6 mx-2 stroke-current"
                >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"
                ></path>
                </svg>
                {{ $order->getStatus()['message'] }}
            </div>
            @endif
            
        </div>
        <div class="shadow-xl rounded-lg py-10">
            <div class="flex px-10">
                <h1 class="text-xl font-bold">
                    #Order Information

                </h1>
            </div>
            <div class="flex items-center justify-center h-auto p-5">
                <div class="container">
                    <div class="w-full flex justify-between px-5">
                        <div class="">
                            <p class="mt-1 text-gray-700 mb-0"><span class="font-black">Phone</span>: {{$order->phone}}</p>
                            <p class="text-gray-700"><span class="font-black">Address</span>: {{$order->address}}</p>
                        </div>
                        <div class="">
                            <p class="mb-0">Expected Arrival: <span>{{ $expected_arrival }}</span></p>
                            <p>Total: <span class="font-bold text-lg">$ {{ number_format($order_details->reduce(function($total,$item) { return $total + $item->product->product_price * $item->quantity;
                                }),2) }}</span>
                            </p>
                            <p class="inline-flex items-center">Payment: <span class="ml-1 gap-x-2 font-bold text-lg inline-flex items-center">
                                        @if ($order->payment == "card")
                                            Visa, Master, JCB
                                              <img class="h-5 w-5" src="{{ asset('assets/images/payment/visa.svg') }}" alt="visa">
                                              <img class="h-5 w-5" src="{{ asset('assets/images/payment/mastercard.svg') }}" alt="mastercard">
                                              <img class="h-5 w-5" src="{{ asset('assets/images/payment/jcb.svg') }}" alt="jcb">
                                            
                                        @elseif($order->payment == "card")
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Cash payment upon delivery
                                        @elseif($order->payment == "momo")
                                            <img class="h-5 w-5" src="{{ asset('assets/images/payment/momo.svg') }} " alt="momo">
                                            MoMo wallet payment
                                        @elseif($order->payment == "zalo")
                                            <img class="h-5 w-5" src="{{ asset('assets/images/payment/zalopay.svg') }}" alt="momo">
                                            Zalopay wallet payment
                                        @endif
                                  </span>
                            </p>
                        </div>
                    </div> 
                </div>
            </div>
        </div>
        <div class="shadow-xl rounded-lg py-10" id="order-summary">
            <div class="flex px-10 mt-5">
                <h1 class="text-xl font-bold">
                    #Order Summary
                </h1>
            </div>
            <div class="flex items-center justify-center h-auto p-5">
                <div class="container">
                    <div class="flex justify-center">
                        <div class="bg-white w-full">
                            <ul class="divide-y divide-gray-300">
                                @foreach ($order_details as $item)
                                <li class="p-4 hover:bg-gray-50 cursor-pointer flex">
                                    <a href="{{ route('product.details',[$item->product->category->category_slug,$item->product->product_slug]) }}" class="flex-1 space-x-4">
                                        <div>
                                            <img src="{{ $item->product->product_image }}" alt="image"
                                                class="w-40">
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-bold">{{ strlen($item->product->product_name) > 50 ? substr($item->product->product_name,0,30)."..." : $item->product->product_name }}</h2>
                                            {{-- <p class="text-sm">{{ $product->find($item->product_id)->product_desc }}</p> --}}
                                            <strong class="text-gray-700 mr-3">Price:</strong>$ {{ number_format($item->product->product_price,2) }} x <strong>{{ $item->quantity }}</strong>

                                        </div>
                                    </a>
                                    @if ($order->getStatus()['status'] == 4 )
                                        <div>
                                            @if ($review->where('order_detail_id',$item->id)->exists())
                                                    <span class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md text-yellow-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                                                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <span class="mx-1 uppercase">reviewed</span>
                                                    </span>
                                            @else
                                            <div class="flex justify-end font-semibold text-yellow-500">
                                                <p>Share your opinion about our products</p>
                                            </div>
                                            <div class="flex justify-end mt-2">
                                                <review-button :order_detail_id="{{ $item->id }}"></review-button>
                                            </div>
                                            @endif
                                        </div>
                                        
                                    @endif
                                </li>
                                  
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
               
    </div>
</div>
{{-- <div class="container px-1 px-md-4 mx-auto">
    <div class="card">
        <div class="row d-flex justify-content-between px-3 top">
            <div class="">
                <h3>ORDER <span class="text-primary font-weight-bold">#{{ $order->id }}</span></h3>
                <p class="mt-1 text-muted mb-0">Phone: {{$order->phone}}</p>
                <p class="text-muted">Address: {{$order->address}}</p>
            </div>
            <div class="">
                <p class="mb-0">Expected Arrival: <span>{{ $expected_arrival }}</span></p>
                <p>Total amount: <span class="font-weight-bold fsize-32">$ {{ $order_details->reduce(function($total,$item) { return $total +
                	$item->product->product_price * $item->quantity;
                }) }}</span></p>
            </div>
        </div> <!-- Add class 'active' to progress -->
        <hr>
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <ul id="progressbar" class="text-center">
                    <li class="icon @empty($order->request_date)@else active @endempty step0"></li>
                    <li class="icon @empty($order->get_date)@else active @endempty step0"></li>
                    <li class="icon @empty($order->ship_date)@else active @endempty step0"></li>
                    <li class="icon @empty($order->completion_date)@else active @endempty step0"></li>
                </ul>
            </div>
        </div>
        <div class="row justify-content-between top">
            <div class="row d-flex"> 
                <div class="d-flex flex-column">
                	@empty($order->request_date)
                	@else
                	<p class="mb-3 text-muted small">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->request_date)->format('H:i - d/m/Y') }}</p>
                    <p class="font-weight-bold">  Order is initialized</p>
                     @endempty

                </div>
            </div>
            <div class="row d-flex">
                <div class="d-flex flex-column">
                	@empty($order->get_date)
                	@else
                    <p class="mb-3 text-muted small">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->get_date)->format('H:i - d/m/Y') }}</p>
                    <p class="font-weight-bold">Order Processing</p>
                    @endempty
                </div>
            </div>
            <div class="row d-flex">
                <div class="d-flex flex-column">
                	@empty($order->ship_date)
                	@else
                    <p class="mb-3 text-muted small">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->ship_date)->format('H:i - d/m/Y') }}</p>
                    <p class="font-weight-bold">Order En Route</p>
                    @endempty
                </div>
            </div>
            <div class="row d-flex">
                <div class="d-flex flex-column">
                	@empty($order->completion_date)
                	@else
                    <p class="mb-3 text-muted small">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->completion_date)->format('H:i - d/m/Y') }}</p>
                    <p class="font-weight-bold">Order Arrived</p>
                    @endempty
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex justify-content-between px-3 top">
            <h3 class="mb-4">DETAILS ({{ $order_details->count() }} items)</h3>
        </div>
        @foreach($order_details as $index => $item)
        <div class="row top pt-0">
        	<a href="{{ route('product.details',[$item->product->category->category_slug,$item->product->product_slug]) }}" class="row col-sm-12 product-card p-5 text-decoration-none text-dark">
	            <div class="col-md-5 col-lg-3 col-xl-3 d-flex align-items-center">
	                <div class="rounded mb-3 mb-md-0">
	                    <img class="img-fluid d-block" src="{{ $item->product->product_image }}" alt="Sample"/>
	                </div>
	            </div>
	            <div class="col-md-7 col-lg-9 col-xl-9">
	                <div>
	                    <div class="d-flex justify-content-between">
	                        <div>
	                            <h5>{{ $item->product->product_name }}</h5>
	                            <p class="mb-3 text-muted small">
	                                <strong>Unit price:</strong> $ {{ $item->product->product_price }}
	                            </p>
	                            <p class="mb-2 text-muted text-uppercase small">
	                            </p>
	                        </div>
	                        <div>
	                                <div class="input-group input-group-sm mb-3">
	                                    <div class="input-group-prepend">
	                                    <span class="input-group-text" id="inputGroup-sizing-sm">Qty.</span>
	                                    </div>
	                                    <input class="form-control form-control-sm"  type="number" value="{{ $item->quantity }}" disabled min="1" max="100" step="1"/>
	                                </div>
	                                <p class="mb-0">
			                            <span class="fsize-32">
			                                <strong id="summary" class="text-brown">$ {{$item->quantity * $item->product->product_price}}</strong>
			                            </span>
			                        </p class="mb-0"> 
	                        </div>
	                    </div>
	                </div> 
	            </div>
            </a>
        </div>
        @endforeach
    </div>
</div> --}}
{{-- <div class="container bg-white py-3 mt-4">
	<!--Section: Block Content-->
	<section>

	<!--Grid row-->
	<div class="row card-border-0">

		<!--Grid column-->
		<div class="col-lg-8">
		</div>
	</div>
	</section>
</div> --}}
@endsection

@section('script')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


    document.getElementById('cancelForm').addEventListener('submit', 
        function(e){
            e.preventDefault(); 
            Swal.fire({
              title: 'Are you sure you want to cancel this order?',
              showDenyButton: true,
              confirmButtonText: 'Yes',
              denyButtonText: 'No',
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {
                this.submit();
              } else if (result.isDenied) {
                Swal.fire('Your order is being continued', '', 'info')
              }
            })
        }
    );
</script>
@endsection

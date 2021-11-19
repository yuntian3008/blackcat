@extends('layouts.web')
@inject('imageProcessing', 'App\Components\Helper\ImageProcessing')
@inject('product','App\Product')
@inject('review','App\Review')

@section('title')
{{ __('Orders') }}
@endsection

@section('style')
<style type="text/css">
	
</style>
@endsection

@section('vue-id')
id="shop"
@endsection

@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
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
        <div class="flex px-10 mt-5 items-center justify-between">
            <h1 class="text-2xl text-gray-700 font-extrabold uppercase">
                Your Orders
            </h1>
            <div class="flex items-center">
                <p class="text-gray-500 dark:text-gray-300 mr-3">Status</p>
                <select class="form-select rounded-lg focus:border-0 focus:border-none font-medium text-gray-700 bg-transparent dark:text-gray-500 focus:outline-none" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                    <option value="{{ url()->current() }}">All</option>
                    <option value="{{ url()->current() }}?status=completed" {{ url()->full() == url()->current().'?status=completed' ? "selected" : "" }}>Completed</option>
                    <option value="{{ url()->current() }}?status=processing" {{ url()->full() == url()->current().'?status=processing' ? "selected" : "" }}>Proceesing</option>
                    <option value="{{ url()->current() }}?status=cancelled" {{ url()->full() == url()->current().'?status=cancelled' ? "selected" : "" }}>Cancelled</option>
                </select>
            </div>
        </div>
        <div class="shadow-xl rounded-lg py-10">
            {{-- <div class="flex px-10 mt-5">
                <h1 class="text-xl font-bold">
                    #Order Summary
                </h1>
            </div> --}}
            <div class="flex items-center justify-center h-auto py">
                <div class="container">
                    <div class="flex justify-center">
                        <div class="bg-white w-full">
                            <ul class="divide-y divide-gray-300">
                                @if ($orders->count() == 0)
                                    <li class="p-10 hover:bg-gray-50 flex justify-center">
                                        <p class="text-xl">You don't have any orders yet</p>
                                    </li>
                                @endif
                                @foreach ($orders as $item)
                                <li class="p-10 hover:bg-gray-50">
                                    <a href="{{ route('customer.order.details', ['id' => $item->id]) }}" class="flex flex-col">
                                        <div class="w-full flex justify-between mb-2 ">
                                            <div class="">
                                                <p class="text-yellow-500 text-lg font-semibold">Order #{{ $item->id }} - {{ $item->getStatus()['message'] }}</p>
                                            </div>
                                            <div class="">
                                            </div>
                                        </div>
                                        
                                        <div class="flex gap-x-10">
                                            <div>
                                                <img src="{{ $item->represent->product->product_image }}" alt="image"
                                                    class="w-40">
                                            </div>
                                            <div class="flex flex-wrap content-between w-full">
                                                <div class="w-full flex justify-between">
                                                    <div class="">
                                                        <h2 class="text-xl text-gray-700">{{ $item->represent->product->product_name }}</h2>
                                                        {{-- <p class="text-sm">{{ $product->find($item->product_id)->product_desc }}</p> --}}
                                                        <p class="text-xl text-gray-700 mr-3">x {{ $item->represent->quantity }}</p>
                                                    </div>
                                                    <div class="flex flex-col text-gray-700">
                                                        <div class="flex justify-end">
                                                            <div class="">Price: <strong class="text-xl text-bold text-gray-700 mr-3">$ {{ $item->represent->product->product_price }}</strong></div>
                                                        </div>
                                                        
                                                        
                                                    </div>

                                                </div>
                                                <div class="flex w-full">
                                                    @if ($item->count > 1)
                                                    <div class="text-md text-gray-600 font-light uppercase">+ {{ ($item->count - 1) }} other item{{ ($item->count - 1) > 1 ? "s" : ""}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                     </a>
                                        <hr class="border-gray-200 dark:border-gray-700 my-2">
                                        <div class="w-full flex justify-between">
                                            <div class="">
                                                @if ($item->getStatus()['status'] == 4 )
                                                @if ($item->reviews->count() == $item->orderDetails->count())
                                                        <span class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform rounded-md text-yellow-500">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                                                              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                            <span class="mx-1 uppercase">reviewed</span>
                                                        </span>
                                                @else
                                                <div class="flex justify-start font-semibold text-yellow-500">
                                                    <p>Share your opinion about our products</p>
                                                </div>
                                                <div class="flex justify-start mt-2">
                                                    <a href="{{ route('customer.order.details', ['id' => $item->id])."#order-summary" }}" class="flex items-center px-2 py-2 font-medium tracking-wide capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-80 text-yellow-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" viewBox="0 0 20 20" fill="currentColor">
                                                          <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                        <span class="mx-1 uppercase">write review</span>
                                                    </a>

                                                </div>
                                                @endif
                                                @endif
                                            </div>
                                            <div class="">
                                                <div class="flex justify-end">
                                                    <p class="text-gray-700 text-lg uppercase">Total amount: <span class="font-bold text-black text-2xl">$ {{ number_format($item->orderDetails->reduce(function($total,$item) { return $total + $item->product->product_price * $item->quantity;
                                                    }),2) }}</span></p>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        
                                   
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


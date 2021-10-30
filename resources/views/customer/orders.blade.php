@extends('layouts.web')
@inject('imageProcessing', 'App\Components\Helper\ImageProcessing')
@inject('product','App\Product')

@section('title')
{{ __('Orders') }}
@endsection

@section('style')
<style type="text/css">
	
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
        <div class="flex px-10 mt-5">
            <h1 class="text-2xl text-gray-700 font-extrabold uppercase">
                Your Orders
            </h1>
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
                                    <li class="p-10 hover:bg-gray-50 cursor-pointer flex justify-center">
                                        <p class="text-xl">You don't have any orders yet</p>
                                    </li>
                                @endif
                                @foreach ($orders as $item)
                                <li class="p-10 hover:bg-gray-50 cursor-pointer">
                                    <a href="{{ route('customer.order.details', ['id' => $item->id]) }}" class="flex flex-col">
                                        <div class="flex gap-x-10">
                                            <div>
                                                <img src="{{ $item->represent->product->product_image }}" alt="image"
                                                    class="w-40">
                                            </div>
                                            <div class="flex flex-wrap content-between w-full">
                                                <div class="w-full flex justify-between">
                                                    <div class="">
                                                        <h2 class="text-xl font-bold text-gray-700">{{ $item->represent->product->product_name }}</h2>
                                                        {{-- <p class="text-sm">{{ $product->find($item->product_id)->product_desc }}</p> --}}
                                                        <strong class="text-xl text-gray-700 mr-3">x {{ $item->represent->quantity }}</strong>
                                                    </div>
                                                    <div class="text-gray-700">
                                                        Price: <strong class="text-xl text-bold text-gray-700 mr-3">$ {{ $item->represent->product->product_price }}</strong>
                                                    </div>

                                                </div>
                                                <div class="flex w-full">
                                                    @if ($item->count > 1)
                                                    <div class="text-xl text-gray-600 font-light uppercase">+ {{ ($item->count - 1) }} other item{{ ($item->count - 1) > 1 ? "s" : ""}}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <hr class="border-gray-200 dark:border-gray-700 my-2">
                                        <div class="w-full flex justify-between">
                                            <div class="">
                                                <p class="text-gray-700 text-lg">Order status: <span class=" font-bold text-black">{{ $item->getStatus()['message'] }}</span></p>
                                            </div>
                                            <div class="">
                                                <p class="text-gray-700 text-lg uppercase">Total amount: <span class="font-bold text-black text-2xl">$ {{ number_format($item->orderDetails->reduce(function($total,$item) { return $total + $item->product->product_price * $item->quantity;
                                                }),2) }}</span></p>
                                            </div>
                                        </div>
                                        
                                    </a>
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


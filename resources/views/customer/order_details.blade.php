@extends('layouts.web')

@section('title')
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
<div class="container px-1 px-md-4 mx-auto">
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
</div>
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

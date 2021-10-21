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
<div class="container bg-white mt-4">
	<section>

		<!--Grid row-->
		<div class="row card-border-0">

			<!--Grid column-->
			<div class="col-lg-3 p-0">
				<div class="list-group list-group-flush m-0 ">
					<a class="list-group-item list-group-item-action active" id="list-home-list" data-toggle="list" href="#list-home" role="tab" aria-controls="home">Your infomation</a>
					<a class="list-group-item list-group-item-action" id="list-profile-list" data-toggle="list" href="#list-profile" role="tab" aria-controls="profile">Your orders</a>
					{{-- <a class="list-group-item list-group-item-action" id="list-messages-list" data-toggle="list" href="#list-messages" role="tab" aria-controls="messages">Messages</a>
					<a class="list-group-item list-group-item-action" id="list-settings-list" data-toggle="list" href="#list-settings" role="tab" aria-controls="settings">Settings</a>
 --}}				</div>
			</div>

			<div class="col-lg-9 p-0">
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
						<div class="row m-3">
			                <div class="col-md-12">
			                    <h3>Your Profile</h3>
			                    <hr>
			                </div>
			            </div>
			            <div class="row m-3">
			                <div class="col-md-12">
			                    <form>
	                              <div class="form-group row">
	                                <label for="username" class="col-4 col-form-label">User Name*</label> 
	                                <div class="col-8">
	                                  <input id="username" name="username" value="{{ Auth::user()->username }}" class="form-control here" required="required" disabled type="text">
	                                </div>
	                              </div>
	                              <div class="form-group row">
	                                <label for="name" class="col-4 col-form-label">First Name</label> 
	                                <div class="col-8">
	                                  <input id="username" name="username" value="{{ Auth::user()->firstname }}" class="form-control here" required="required" disabled type="text">
	                                </div>
	                              </div>
	                              <div class="form-group row">
	                                <label for="lastname" class="col-4 col-form-label">Last Name</label> 
	                                <div class="col-8">
	                                  <input id="username" name="username" value="{{ Auth::user()->lastname }}" class="form-control here" required="required" disabled type="text">
	                                </div>
	                              </div>
	                              <div class="form-group row">
	                                <label for="text" class="col-4 col-form-label">Your phone</label> 
	                                <div class="col-8">
	                                  <input id="username" name="username" value="{{ Auth::user()->phone }}" class="form-control here" required="required" disabled type="text">
	                                </div>
	                              </div>
	                              <div class="form-group row">
	                                <label for="select" class="col-4 col-form-label">Your mail</label> 
	                                <div class="col-8">
		                               <input id="username" name="username" value="{{ Auth::user()->email }}" class="form-control here" required="required" disabled type="text">
		                           </div>
	                              </div>
	                              <div class="form-group row">
	                                <label for="email" class="col-4 col-form-label">Verify phone</label> 
	                                <div class="col-8">
	                                  <input id="username" name="username" value="{{ Auth::user()->firebase_uid ? "Verified" : "No" }}" class="form-control here" required="required" disabled type="text">
	                                </div>
	                              </div>
	                              {{-- <div class="form-group row">
	                                <div class="offset-4 col-8">
	                                  <button name="submit" type="submit" class="btn btn-brown">Change password</button>
	                                </div>
	                              </div> --}}
	                            </form>
			                </div>
			            </div>
					</div>
					<div class="tab-pane fade" id="list-profile" role="tabpanel" aria-labelledby="list-profile-list">
						<h3 class="m-3">Your orders</h3>
						@foreach($orders as $item)
						<a href="{{ route('order.details',[$item->id]) }}" class="text-decoration-none text-dark">
							<div class="product-card p-3">
								<div class="d-flex justify-content-between">
									<h5>Order # {{ $item->id }}</h5>
									<p class="mb-0">Order date: <span>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->request_date)->format('d/m/Y') }}</span></p>
									
								</div>
								<div class="d-flex justify-content-between mt-2">
									<h5>Status: 
										@if(!is_null($item->request_date) && is_null($item->get_date) && is_null($item->ship_date) && is_null($item->completion_date))
										<strong class="text-danger">Wait for confirmation</strong>
										@elseif(!is_null($item->request_date) && !is_null($item->get_date) && is_null($item->ship_date) && is_null($item->completion_date))
										<strong class="text-warning">Order is pending</strong>
										@elseif(!is_null($item->request_date) && !is_null($item->get_date) && !is_null($item->ship_date) && is_null($item->completion_date))
										<strong class="text-warning">Order is being delivered</strong>
										@else
										<strong class="text-success">Order delivered successfully</strong>
										@endif
									</h5>
									<p class="mb-0 text-info">Expected Arrival: <span>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->request_date)->addDays(7)->format('d/m/Y') }}</span></p>
								</div>
								<div class="d-flex justify-content-between mt-2">
									<p class="mb-0 text-muted">The number of products: <span>{{ $item->orderDetails()->count() }}</span></p>
									<h5 class="fsize-32">
										Total amount: <strong>{{ $item->orderDetails->reduce(function($total,$item) { return $total +
                	$item->product->product_price * $item->quantity;
                }) }}</strong>
									</h5>
								</div>
							</div>

						</a>
						@endforeach
						
					</div>
				</div>
			</div>

		</div>
	</section>
</div>

@endsection
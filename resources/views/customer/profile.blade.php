@extends('layouts.web')

@section('title')
@endsection

@section('style')

@endsection

@section('main-class')
@endsection

@section('nav-cart-class')
style="display: none;"
@endsection


@section('content')
<div class="mt-10 lg:mt-20 max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl p-5">
        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
          <div class="text-gray-600">
            <p class="font-medium text-lg my-3">Avatar</p>
          	<label for="avatar" class="w-36 block mx-auto cursor-pointer relative hover:opacity-50">
          		<svg xmlns="http://www.w3.org/2000/svg" class="opacity-0 hover:opacity-100 text-white p-2 rounded-md bg-black-600 absolute absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor">
							  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
							</svg>
          		<img alt="profile" src="{{ Auth::user()->getAvatar() ? Auth::user()->getAvatar() : \Avatar::create('Joko Widodo')->toBase64() }}" class="mx-auto my-3 object-cover rounded-full h-36 w-36 "/>
          		<form id="avatarForm" action="{{ route('customer.profile.update.avatar') }}" enctype="multipart/form-data" method="POST">
          			@csrf
          			<input id="avatar" type='file' class="hidden" name="avatar" onchange="form.submit()" />
          		</form>
          	</label>
          </div>

          <div class="lg:col-span-2">
          		<div class="bg-white max-w-2xl overflow-hidden">
          			<dl>
          					<p class="font-medium text-lg my-3">Personal information</p>
          					<form action="{{ route('customer.profile.update') }}" method="POST">
								@csrf
								@if ($errors->any())
				                <div class="bg-red-200 border-red-600 text-red-600 border-l-4 p-4 mt-4 rounded-lg" role="alert">
									<p class="font-bold">
										Error!
									</p>
									@foreach ($errors->all() as $error)
									<p>
										{{ $error }}
									</p>
									@endforeach
									</div>
								@endif
								@if (Session::has('success'))
								<div class="bg-green-200 border-green-600 text-green-600 border-l-4 p-4 rounded-lg" role="alert">
									<p class="font-bold">
										Success!
									</p>
									<p>
										{{ Session::get('success') }}
									</p>
								</div>
								@elseif (Session::has('warning'))
								<div class="bg-yellow-200 border-yellow-600 text-yellow-600 border-l-4 p-4 rounded-lg" role="alert">
									<p class="font-bold">
										Attention!
									</p>
									<p>
										{{ Session::get('warning') }}
									</p>
								</div>
								@endif
					            <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
					                <dt class="text-sm font-medium text-gray-500">
					                    First name
					                </dt>
					                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
														    <input value="{{ Auth::user()->firstname }}" type="text" id="name-with-label" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" name="firstname" placeholder="First name"/>
					                </dd>
					            </div>
					            <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
					                <dt class="text-sm font-medium text-gray-500">
					                    Last name
					                </dt>
					                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
					                     <input value="{{ Auth::user()->lastname }}" type="text" id="name-with-label" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" name="lastname" placeholder="Last name"/>
					                </dd>
					            </div>
					            <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
					                <dt class="text-sm font-medium text-gray-500">
					                    Date of birth
					                </dt>
					                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
										<input value="{{ Auth::user()->dob }}" type="date" max="{{ now()->toDateString('Y-m-d') }}" id="name-with-label" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" name="dob" placeholder="Date of birth"/>
					                </dd>
					            </div>
					            <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
					                <dt class="text-sm font-medium text-gray-500">
					                    Gender
					                </dt>
					                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
										<select class="block w-full text-gray-700 py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary-500 focus:border-primary-500" name="gender">
											<option value="1" {{  Auth::user()->gender == 1 ? 'selected' : '' }}>
												Male
											</option>
											<option value="0" {{  Auth::user()->gender == 0 ? 'selected' : '' }}>
												Female
											</option>
											<option value="-1" {{  Auth::user()->gender == -1 ? 'selected' : '' }}>
												Unknown
											</option>
										</select>
					                </dd>
					            </div>
					            <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
					                <dt class="text-sm font-medium text-gray-500">
					                    Address
					                </dt>
					                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
					                     <input value="{{ Auth::user()->addresses()->first() ? Auth::user()->addresses()->first()->getFull() : "" }}" type="text" id="name-with-label" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" disabled placeholder="Address"/>
					                </dd>
					            </div>
					            <div class="flex justify-end sm:px-6 py-3">
					            	<button type="submit" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-700 focus:ring-opacity-80" id="send-link">
		                        Save
		                    </button>
					            </div>
				            </form>
				            <p class="font-medium text-lg my-3">Account information</p>
				            <div class="bg-gray-50 px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
				                <dt class="text-sm font-medium text-gray-500">
				                    Email address
				                </dt>
				                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
				                	<div class=" relative ">
													    <input value="{{ Auth::user()->email }}" type="text" id="name-with-label" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring- 2 focus:ring-purple-600 focus:border-transparent" name="email" placeholder="First name" disabled />
													    @if (Auth::user()->email_verified_at)
					                     	<svg xmlns="http://www.w3.org/2000/svg" class=" w-6 h-6 absolute text-green-500 right-2 bottom-2" viewBox="0 0 20 20" fill="currentColor">
																  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
																</svg>
															@else
															<svg xmlns="http://www.w3.org/2000/svg" class=" w-6 h-6 absolute text-yellow-500 right-2 bottom-2" viewBox="0 0 20 20" fill="currentColor">
															  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
															</svg>
					                     @endif
											      </div>
				                </dd>
				            </div>
				            <div class="bg-white px-4 py-3 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6 items-center">
				                <dt class="text-sm font-medium text-gray-500">
				                    Phone number
				                </dt>
				                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
				                	<div class=" relative ">
				                     <input value="{{ Auth::user()->phone }}" type="text" id="name-with-label" class=" rounded-lg border-transparent flex-1 appearance-none border border-gray-300 w-full py-2 px-4 bg-white text-gray-700 placeholder-gray-400 shadow-sm text-base focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-transparent" name="email" placeholder="Last name" disabled />
				                     @if (Auth::user()->firebase_uid)
				                     	<svg xmlns="http://www.w3.org/2000/svg" class=" w-6 h-6 absolute text-green-500 right-2 bottom-2" viewBox="0 0 20 20" fill="currentColor">
															  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
															</svg>
															@else
															<svg xmlns="http://www.w3.org/2000/svg" class=" w-6 h-6 absolute text-yellow-500 right-2 bottom-2" viewBox="0 0 20 20" fill="currentColor">
															  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
															</svg>
				                     @endif
													</div>
				                </dd>
				            </div>
				        </dl>
						</div>
          </div>
        </div>
</div>


@endsection

@extends('layouts.web')

@section('title')
{{$product->product_name}}
@endsection

@section('style')
</style>

@section('vue-id')
id="shop"
@endsection

@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection
    
@endsection

@section('content')
<section class="text-gray-600 body-font overflow-hidden" id="shop">
  <div class="container px-5 py-12 mx-auto">
    <div class="lg:w-4/5 mx-auto flex flex-wrap">
      <img alt="ecommerce" class="lg:w-1/3 w-full lg:h-auto h-64 object-cover object-center rounded" src="{{ $product->product_image_bg }}">
      <div class="lg:w-2/3 flex flex-wrap content-between w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0 p-5">
            <div class="w-full flex flex-col gap-y-5">
                <div class=""> 
                    <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $product->category->category_name }}</h2>
                    <h1 class="text-gray-900 text-4xl title-font font-medium mb-1 uppercase">{{ $product->product_name }}</h1>
                </div>
                <span class="flex items-center text-yellow-500">
                    <span class="mr-1 font-semibold">{{ round($stars, 1) }}</span>
                    @for ($i = 1; $i < 6; $i++)
                        <svg stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-6 h-6" viewBox="0 0 24 24">
                            <defs>
                                <linearGradient id="half">
                                    <stop offset="50%" stop-color="currentColor"/>
                                    <stop offset="50%" stop-color="white" stop-opacity="1" />
                                </linearGradient>
                            </defs>
                          <path fill="{{ ($stars - $i >= 0 ? "currentColor" : ($stars - $i >= -0.5 ? "url(#half)" : "none" ))   }}" d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                        </svg>
                    @endfor
                    
                    <span class="text-gray-600 ml-3 text-xl">{{ $product->reviews->count() }} Reviews</span>
                </span>
            </div>
            
            <div class="flex w-full">
                  <span class="title-font font-medium text-3xl text-gray-900">$ {{ number_format($product->product_price,2) }}</span>
                  <add-to-cart class="flex ml-auto text-white font-bold bg-gray-700 border-0 py-2 px-6 focus:outline-none hover:bg-gray-500 rounded uppercase" :product_id="{{ $product->id }}" :quantity="1" :available="{{ $product->available ? 1 : 0 }}"  :login_url="'{{ route('login') }}'"></add-to-cart>
                  {{-- <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                      <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                    </svg>
                  </button> --}}
            </div>
        
        {{-- <div class="flex mb-4">
             REVIEWWWWWWWWWWWWW 
          <span class="flex items-center">
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <span class="text-gray-600 ml-3">4 Reviews</span>
          </span>
          <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
            <a class="text-gray-500">
              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
              </svg>
            </a>
            <a class="text-gray-500">
              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
              </svg>
            </a>
            <a class="text-gray-500">
              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
              </svg>
            </a>
          </span>
        </div>     --}}    {{-- <div class="flex mt-6 items-center pb-5 border-b border-gray-100 mb-5">
          <div class="flex">
            <span class="mr-3">Color</span>
            <button class="border-2 border-gray-300 rounded-full w-6 h-6 focus:outline-none"></button>
            <button class="border-2 border-gray-300 ml-1 bg-gray-700 rounded-full w-6 h-6 focus:outline-none"></button>
            <button class="border-2 border-gray-300 ml-1 bg-indigo-500 rounded-full w-6 h-6 focus:outline-none"></button>
          </div>
          <div class="flex ml-6 items-center">
            <span class="mr-3">Size</span>
            <div class="relative">
              <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                <option>SM</option>
                <option>M</option>
                <option>L</option>
                <option>XL</option>
              </select>
              <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                  <path d="M6 9l6 6 6-6"></path>
                </svg>
              </span>
            </div>
          </div>
        </div> --}}
        
      </div>
    </div>
    <div class="lg:w-4/5 mx-auto grid gap-x-8 gap-y-4 grid-cols-3 mt-5 grid-flow-row auto-rows-max">
        <div class="{{ $product->specs->count() == 0 ? "col-span-3" : "col-span-2"}} w-full lg:py-10 mt-6 lg:mt-0 shadow-xl px-5 rounded-xl mr-5">
            <h2 class="text-xl font-extrabold lg:mb-5 mb-3">Description</h2>
            <p class="leading-relaxed overflow-y-auto max-h-screen">{{ $product->product_desc }}</p>
        </div>
        @if ($product->specs->count() != 0)
            <div class="w-full lg:py-10 mt-6 lg:mt-0 shadow-xl px-5 rounded-xl">
                <h2 class="text-xl font-extrabold lg:mb-5 mb-3">More information</h2>
                <table class="table w-full">
                    <tbody>
                        @foreach($product->specs()->get() as $spec)
                        <tr class="text-gray-700">
                            <th scope="row" class="border-b p-4 dark:border-dark-5 text-left">
                                {{ $spec->key }}
                            </th>
                            <td class="border-b p-4 dark:border-dark-5">
                                {{ $spec->value }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
       
    </div>
    <div class="lg:w-4/5 mx-auto grid gap-x-8 gap-y-4 grid-cols-1 mt-5 grid-flow-row auto-rows-max">
        <div class="w-full lg:py-10 mt-6 lg:mt-0 shadow-xl px-5 rounded-xl">
            <h2 class="text-xl font-extrabold lg:mb-5 mb-3">Reviews</h2>
            <ul class="flex flex-col divide divide-y">
                {{ $product->reviews->count() == 0 ? "There are no reviews yet" :"" }}
                @foreach ($product->reviews as $review)
                    <li class="flex flex-row">
                        <div class="select-none flex flex-1 items-center p-4">
                            <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
                                <a href="#" class="block relative">
                                    <img alt="profil" src="{{ $review->orderDetail->order->customer->getAvatar() }}" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                </a>
                            </div>
                            <div class="flex-1 pl-1 mr-16">
                                <div class="flex font-medium dark:text-white items-center">
                                    {{ $review->orderDetail->order->customer->getFullName() }}
                                    <span class="flex text-green-500 items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mx-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>Purchased
                                    </span>
                                    
                                </div>
                                <div class="flex items-center gap-x-2 text-gray-600 dark:text-gray-200 text-sm">
                                    {{ !empty($review->comment) ? $review->comment : "" }}
                                    
                                </div>
                                @if (!empty($review->getImage()))
                                    <review-image class="mt-2" :items="['{{ $review->getImage("bg") }}']"></review-image>
                                    {{-- <img width="100" src="{{ $review->getImage() }}" alt="review image"> --}}
                                @endif
                            </div>

                            <span class="flex text-yellow-500 items-center font-medium mx-1">
                                {{ $review->level }}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            </span>
                            <div class="text-gray-600 dark:text-gray-200 text-xs">
                                {{ $review->created_at }}
                            </div>
                        </div>
                    </li>
                @endforeach
                
            </ul>

        </div>
    </div>
  </div>
</section>{{-- 
<div class="container bg-white py-3 mt-4" id="product">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-brown">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('products', $category->category_slug) }}" class="text-brown">{{ $category->category_name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $product->product_name }}</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-md-4 text-center" id="image">
                <img src="{{ $product->product_image_bg }}" width="100%">
            </div>
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="product-name text-brown mb-0 opensans" id="name">
                            @if($product->product_brand != null)<strong>{{ $product->product_brand }}</strong> |
                            @endif {{ $product->product_name }}</h5>
                        <hr class="my-2">
                    </div>

                    <div class="col-md-12">
                        <div class="d-block bg-light p-3">
                            <span class="h3" id="price">$ {{ $product->product_price }}</span>
                        </div>
                        <change-qty></change-qty>
                        
                        <add-to-cart :product_id="{{ $product->id }}" :quantity="1"></add-to-cart>
                    </div>
                    
                </div>         
            </div>

            <div class="col-md-12">
                <hr class="my-2">
            </div>
            <div class="col-md-8 pl-4">
                <h5>Description</h5>
                <p class="opensans" id="description">
                    {{ $product->product_desc }}
                </p>
                {{-- <hr class="my-2">
                <h5>Customer reviews</h5>
                <div class="card-body border w-auto">
                    <span class="fsize-32 text-dark px-2">4.5 / 5</span>
                    <div class="star-rating">
                        <span class="fas fa-star"></span>
                        <span class="fas fa-star"></span>
                        <span class="fas fa-star"></span>
                        <span class="fas fa-star-half-alt"></span>
                        <span class="far fa-star"></span>
                    </div>
                </div>
 --}}                
           {{--  </div>
            <div class="col-md-4">
                <h5>Details</h5>
                <div class="table-responsive fsize-16 opensans">
                    <table class="table">
                        <tbody id="detail">
                            @foreach($product->specs()->get() as $spec)
                            <tr><th scope="row">{{ $spec->key }}</th><td>{{ $spec->value }}</td></tr>
                            @endforeach
                        </tbody>      
                    </table>
                </div>
            </div>
        </div>
    </div>  --}}
{{-- <div class="container-fluid pt-4">
    <div class="row justify-content-center">
        <div class="card col-md-11 p-0 border-0">
            <div class="card-header p-0">
                <ol class="breadcrumb m-0 p-0">
                    <li class="breadcrumb-item"><a class="bread p-2" href="{{route('home')}}">Home</a></li>
                    <li class="breadcrumb-item"><a class="bread p-2" href="{{route('categories')}}">Categories</a></li>
                    <li class="breadcrumb-item"><a class="bread p-2" href="{{route('home').'/'.$current_category_slug}}">{{$current_category_name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">
                        {{$current_plant}}
                    </li>
                </ol>
            </div>
            <div class="card-body row">
                <div class="col-md-8 row position-relative overflow-hidden p-3 text-center">
                    <div class="col-md-6 p-lg-5 my-5">
                        <h1 class="display-4 font-weight-normal">{{$data->plant_name}}</h1>
                        <p class="lead font-weight-normal">Description of plant</p>
                    <a class="btn btn-outline-secondary" href="#">Coming soon</a>
                    </div>
                    <div class="col-md-6 p-lg-5 my-5">
                        <img class="rounded img-fluid img-thumbnail"src="{{$data->plant_image}}" alt="Plant Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  --}}
@endsection

@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection
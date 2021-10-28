@extends('layouts.web')

@section('title')
Home
@endsection

@section('style')
@endsection

@section('main-class')
mt-5  
@endsection

@section('vue-id')
id="shop"
@endsection

@section('search-input')
<search-input></search-input>
@endsection

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-8 mx-auto">
        <div class="lg:flex lg:-mx-2">
            <div class="space-y-3 lg:w-1/5 lg:px-2 lg:space-y-4">
                @foreach ($root_categories as $category)
                    @if (Request::is('shop/'.$category->category_slug))
                        <a href="{{ route('products', ['category_slug' => $category->category_slug ]) }}" class="block font-medium text-black dark:text-gray-500 hover:underline">{{ $category->category_name }}</a>
                    @else
                        <a href="{{ route('products', ['category_slug' => $category->category_slug ]) }}" class="block font-medium text-gray-500 dark:text-gray-300 hover:underline">{{ $category->category_name }}</a>
                    @endif
                @endforeach
            </div>

            <div class="mt-6 lg:mt-0 lg:px-2 lg:w-4/5 ">

                @yield('products')
            </div>
        </div>
    </div>
</section>
{{-- <div class="container-fluid p-0">
    <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
            <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active" data-interval="3000">
                <img src="{{ asset('assets/images/carousel/1.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fsize-48">Excited and intoxicated.</h1>
                    <p>Experience love at first sip.</p>
                </div>
            </div>
            <div class="carousel-item" data-interval="3000">
                <img src="{{ asset('assets/images/carousel/2.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fsize-48">Life begins after coffee.</h1>
                    <p>No one can stop me from drinking this whole pot of coffee. Don’t even try getting in my way!</p>
                </div>
            </div>
            <div class="carousel-item" data-interval="3000">
                <img src="{{ asset('assets/images/carousel/3.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fsize-48">Shout-out to wifi, coffee and ambition</h1>
                    <p>Way too much coffee? But if it weren't for coffee, I wouldn’t be able to manifest my real self.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>
<div class="container">
    <div class="d-flex justify-content-center mt-4">
        
            <input id="search-filter-input" class="search-filter-input" type="text" placeholder="Search"/>
        
        
    </div>
            @foreach ($categories as $index => $category)
            <h3 class="font-weight-bold col-12 text-brown fsize-36 half-underline ml-5">{{ $category->category_name }}</h3>
            <div class="row row-cols-1 row-cols-md-4 g-0">
                @foreach ($category->visibleProducts as $index => $product) 
                @if($index > 4)
                    @break
                @endif
                <a class="col product-card text-decoration-none" href="{{route('product.details',[$category->category_slug,$product->product_slug])}}" >
                    <div class="card border-0">
                        <img src="{{$product->getImage('sm')}}" class="card-img-top" alt="test">
                        <div class="card-body">
                            <h5 class="card-title text-brown opensans mt-3 fsize-16 text-wrap"><strong>{{$product->product_brand}}</strong> - {{$product->product_name}}</h5>
                            <div class="card-text fsize-20">$ {{$product->product_price}}</div>
                            <add-to-cart class="btn-sm" :product_id="{{ $product->id }}" :quantity="1"></add-to-cart>
                        </div>
                    </div>
                </a>
                @endforeach



                <div class="col-md-12 ">
                    <a href="{{ route('products', $category->category_slug) }}" class="text-decoration-none text-dark float-right fsize-24">See All >></a>
                </div>
            </div>  
            <hr>
            @endforeach
        
    </div> --}}
@endsection

@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection
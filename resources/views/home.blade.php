@extends('layouts.web')

@section('title')
Home
@endsection

@section('style')
<style type="text/css">
.search-filter-input {
    border: 1px solid #bb6b24;
    width: 40%;
    height: 80px;
    line-height: 80px;
    border-radius: 80px;
    padding-left: 90px;
    font-weight: 300;
    color: #000;
    background: url(assets/images/default/search.svg) no-repeat scroll 35px 25px;
    background-size: 30px 30px;
}
</style>
@endsection

@section('main-class')
mt-0  
@endsection

@section('content')
<div class="container-fluid p-0">
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
{{-- </div>
<div class="container"> --}}
    <div class="d-flex justify-content-center mt-4">
        
            <input id="search-filter-input" class="search-filter-input" type="text" placeholder="Search"/>
        
        
    </div>
            
            @foreach ($data as $index => $category)
            <div class="row mt-4 mx-5 px-5">
                <h3 class="font-weight-bold col-12 text-brown fsize-36 half-underline ml-5">{{ $category->category_name }}</h3>
                <div class="col-md-12 ">
                    <div class="row">
                        @foreach ($category->products as $index => $product) 
                        @if($index > 3)
                            @break
                        @endif
                        <a href="{{route('product.details',[$category->category_slug,$product->product_slug])}}" class="text-decoration-none text-dark">
                            <div class="col-md-3 card-deck product-card m-0 p-0 float-left">
                                <div class="card-body p-4">
                                    <img src="{{$product->product_image}}" class="card-img-top" alt="test">
                                    <div class=" align-self-end">
                                        <h5 class="card-title text-brown opensans mt-3 fsize-16 text-wrap"><strong>{{$product->product_brand}}</strong> - {{$product->product_name}}</h5>
                                        <div class="card-text fsize-20">$ {{$product->product_price}}</div>
                                        <div class="row no-gutters mt-3">
                                            <a href="#"></a>
                                            {{-- <a href="#" class="btn btn-outline-brown col btnAdd" product="category[i].id" color="category[i].color[0]">Add to cart</a>
 --}}                                        
                                            <add-to-cart :product_id="{{ $product->id }}" :quantity="1"></add-to-cart>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <a href="{{ route('products', $category->category_slug) }}" class="text-decoration-none text-dark float-right fsize-24">See All >></a>
                </div>
            </div>  
            <hr>
            @endforeach
        
    </div>
@endsection

@section('script')
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script type="text/javascript">

</script>
@endsection
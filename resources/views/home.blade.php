@extends('layouts.web')

@section('title')
Home
@endsection

@section('style')
<style type="text/css">

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
            <div class="carousel-item active">
                <img src="{{ asset('assets/images/carousel/1.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fsize-48">First slide label</h1>
                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/carousel/2.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fsize-48">Second slide label</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('assets/images/carousel/3.jpg') }}" class="d-block w-100" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="fsize-48">Third slide label</h1>
                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
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
        
            @foreach ($data as $index => $category)
            <div class="row mt-3 mx-5 px-5">
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
                                            <a href="#" class="btn btn-outline-dark mr-1 col btnBuy" product="category[i].id" color="category[i].color[0]">Buy now</a>
                                            <a href="#" class="btn btn-outline-brown col btnAdd" product="category[i].id" color="category[i].color[0]">Add to cart</a>
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
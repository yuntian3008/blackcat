@extends('layouts.web')

@section('title')
{{$product->product_name}}
@endsection

@section('style')
<style>
    .star-rating{
  color: orange;
}

.product-name strong{
  font-weight: bolder;
}

/* Compatibility styles for frameworks like bootstrap, foundation e.t.c */
.xzoom-source img, .xzoom-preview img, .xzoom-lens img {
  display: block;
  max-width: none;
  max-height: none;
  -webkit-transition: none;
  -moz-transition: none;
  -o-transition: none;
  transition: none;
}
/* --------------- */

/* xZoom Styles below */
.xzoom-container { 
  display: inline-block;
}

.xzoom-thumbs {
  text-align: center;
  margin-bottom: 10px;
}


.xzoom2, .xzoom3, .xzoom4, .xzoom5 {
  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);
  -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);
  box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.5);
}

/* Thumbs */
.xzoom-gallery, .xzoom-gallery2, .xzoom-gallery3, .xzoom-gallery4, .xzoom-gallery5 {
  border: 1px solid #cecece;
  margin-left: 5px;
  margin-bottom: 10px;
}

.xzoom-source, .xzoom-hidden {
  display: block;
  position: static;
  float: none;
  clear: both;
}

/* Everything out of border is hidden */
.xzoom-hidden {
  overflow: hidden;
}

/* Preview */
.xzoom-preview {
  border: 1px solid #888;
  background: #ffffff;
  box-shadow: -0px -0px 10px rgba(0,0,0,0.50);
}

/* Lens */
.xzoom-lens {
  border: 1px solid #555;
  box-shadow: -0px -0px 10px rgba(0,0,0,0.50);
  cursor: pointer;
}

/* Loading */
.xzoom-loading {
  background-position: center center;
  background-repeat: no-repeat;
  border-radius: 100%;
  opacity: .7;
  background: url(/SGU_UDW1/_public/images/xzoom/xloading.gif);
  width: 48px;
  height: 48px;
}

/* Additional class that applied to thumb when it is active */
.xactive {
  -webkit-box-shadow: 0px 0px 3px 0px rgba(74,169,210,1);
  -moz-box-shadow: 0px 0px 3px 0px rgba(74,169,210,1);
  box-shadow: 0px 0px 3px 0px rgba(74,169,210,1); 
  border: 1px solid #4aaad2;
}

/* Caption */
.xzoom-caption {
  position: absolute;
  bottom: -43px;
  left: 0;
  background: #000;
  width: 100%;
  text-align: left;
}

.xzoom-caption span {
  color: #fff;
  font-family: Arial, sans-serif;
  display: block;
  font-size: 0.75em;
  font-weight: bold;
  padding: 10px;
}


</style>
    
@endsection

@section('content')
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
            </div>
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
    </div>
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
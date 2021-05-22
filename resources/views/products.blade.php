@extends('layouts.web')

@section('title')
{{$current_category}}
@endsection

@section('style')
<style>
    div.container .row, .card-body a{
  font-size: 16px;
}
</style>
    
@endsection

@section('content')
<div class="container bg-white py-3 mt-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-brown">Home</a></li>
                    <li class="breadcrumb-item"><a href="#" class="text-brown">Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$current_category}}</li>
                </ol>
            </nav>
        </div>
        <div class="row" id="category">
            @foreach ($data as $index => $item)
            <a href="{{ route('product.details',[$item->category->category_slug,$item->product_slug])}}" class="text-decoration-none text-dark">
                <div class="col-md-3 card-deck product-card m-0 p-0 float-left">
                    <div class="card-body p-4">
                        <img src="{{$item->product_image}}" class="card-img-top" alt="test">
                        <div class=" align-self-end">
                            <h5 class="card-title text-brown opensans mt-3 fsize-16 text-wrap"><strong>{{$item->product_brand}}</strong> - {{$item->product_name}}</h5>
                            <div class="card-text fsize-20">$ {{$item->product_price}}</div>
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
</div>
{{-- <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="card col-md-11 p-0 border-0">
                <div class="card-header p-0">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a class="bread p-2" href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a class="bread p-2" href="{{route('categories')}}">Categories</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{$current_category}}
                            </li>
                        </ol>

                </div>
                <div class="card-body row">
                    @if ($data->isNotEmpty())
                    <div class="col-md-8 row">
                        @foreach ($data as $index => $item)
                            <a href="{{url()->current().'/'.$item->plant_slug}}" class="card col-md-4 text-center">
                                <div class="card-body">
                                    <img class="mb-2" src="{{$item->plant_image}}" alt="{{$item->plant_name}}" width="128px" height="128px">
                                    <h4>
                                    {{$item->plant_name}}
                                    </h4>
                                </div>  
                            </a>
                        @endforeach
                    </div>
                    <div class="col-md-4"></div>
                    @else
                        <div class="col-sm-12 alert alert-light text-center" role="alert">
                          Empty categories, <a href="{{route('categories')}}" class="alert-link">back home</a>.
                        </div>
                    @endif
                </div>



 --}}
                
                {{-- <div class="card-body row p-0">
                    @if ($data->isNotEmpty())
                    @foreach ($data as $index=>$item)
                    <a href="{{url()->current()."/".$item->plant_slug}}" class="card col-md-6 text-center 
                        @if($index % 2 == 0)
                            border-right
                        @endif
                        @if(sizeof($data) % 2 == 0)
                            @if(!((sizeof($data) == $index1) ||  (sizeof($data)-1 == $index1) ))
                            border-bottom
                            @endif
                        @elseif(!(sizeof($data) == $index1))
                            border-bottom
                        @endif
                        ">
                        <div class="card-body">
                            <img class="align-self-center plant_img" height="128" width="128" src="{{asset('storage/sm_'.$item->plant_image)}}" alt="{{$item->plant_slug}}">
                            <h5 class="card-title my-2">{{$item->plant_name}}</h5>
                            
                        </div>
                    </a> 
                    @endforeach
                    @else
                    <div class="col-12 text-center" role="Nodata">
                        <h4 class="alert-heading my-2">No data</h4>
                        <a href="{{route('home')}}" class="btn btn-outline-primary btn-md my-2" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Go homepage</a>
                    </div>
                    @endif
                </div> --}}
{{--             </div>
        </div>
</div> --}}
@endsection
@extends('layouts.web')

@section('title')
@endsection

@section('style')
<style>
    div.container .row, .card-body a{
  font-size: 16px;
}
</style>
    
@endsection

@section('main-class')
mt-5
@endsection

@section('content')
<div class="container bg-white py-3 mt-4">
        <h2 class="text-center">@empty($keyword)Search results
        @else Search results for "{{$keyword}}"@endempty</h2>
        {{-- @if($data->count() == 0)
            <p class="my-5 text-muted small text-center">
                Nothing to show
            </p>
        @endif --}}
        <div class="row" id="category">
            @foreach ($data as $index => $item)
            <a href="{{ route('product.details',[$item->category->category_slug,$item->product_slug])}}" class="text-decoration-none text-dark">
                <div class="col-md-3 card-deck product-card m-0 p-0 float-left">
                    <div class="card-body p-4">
                        <img src="{{$item->product_image}}" class="card-img-top" alt="test">
                        <div class=" align-self-end">
                            <h5 class="card-title text-brown opensans mt-3 fsize-16 text-wrap">@empty(!$item->product_brand)<strong>{{$item->product_brand}}</strong> - @endisset{{$item->product_name}}</h5>
                            <div class="card-text fsize-20">$ {{$item->product_price}}</div>
                            <div class="row no-gutters mt-3">
                                <a href="#"></a>
                                <add-to-cart :product_id="{{ $item->id }}" :quantity="1"></add-to-cart>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="justify-content-center row mt-4">
            <div class="d-block">
                {{ $data->appends($param)->links() }}
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
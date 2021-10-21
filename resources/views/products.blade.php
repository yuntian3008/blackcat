@extends('layouts.web')

@section('title')
{{-- {{$current_category}} --}}
@endsection

@section('style')
<style>
    div.container .row, .card-body a{
  font-size: 16px;
}
</style>
    
@endsection

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="container px-6 py-8 mx-auto">
        <div class="lg:flex lg:-mx-2">
            <div class="mt-6 lg:mt-0 lg:px-2 lg:w-full ">
                <div class="flex items-center justify-between text-sm tracking-widest uppercase ">
                    <p class="text-gray-500 dark:text-gray-300">{{ count($data) }} Items</p>
                    <div class="flex items-center">
                        <p class="text-gray-500 dark:text-gray-300">Sort</p>
                        <select class="font-medium text-gray-700 bg-transparent dark:text-gray-500 focus:outline-none">
                            <option value="#">Recommended</option>
                            <option value="#">Size</option>
                            <option value="#">Price</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-8 mt-8 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                    @foreach ($data as $index => $item)
                    <a href="{{ route('product.details',[$item->category->category_slug,$item->product_slug])}}" class="max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800">
                        <div class="px-4 py-2">
                            <h1 class="text-2xl font-bold text-gray-800 uppercase dark:text-white">@empty(!$item->product_brand)<strong>{{$item->product_brand}}</strong> - @endisset{{ strlen($item->product_name) > 25 ? substr($item->product_name, 0, 25)."..." : $item->product_name }}</h1>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ strlen($item->product_desc) > 100 ? substr($item->product_desc, 0, 100)."..." : $item->product_desc }}</p>
                        </div>

                        <img class="object-cover w-full h-48 mt-2" src="{{$item->product_image}}" alt="{{$item->product_name}}">

                        <div class="flex items-center justify-between px-4 py-2 bg-gray-900">
                            <h1 class="text-lg font-bold text-white">$ {{$item->product_price}}</h1>
                            <button class="px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-200 transform bg-white rounded hover:bg-gray-200 focus:bg-gray-400 focus:outline-none">Add to cart</button>
                            {{-- <add-to-cart :product_id="{{ $item->id }}" :quantity="1"></add-to-cart> --}}
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
{{-- <div class="container bg-white py-3 mt-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-white">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-brown">Home</a></li>
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
                {{ $data->links() }}
            </div>
        </div>
        
</div> --}}
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
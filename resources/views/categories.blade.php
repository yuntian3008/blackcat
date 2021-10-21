@extends('layouts.web')

@section('title')
Categories
@endsection

@section('style')
<style>
    #content{
        font-size: 0.7rem;
    }
    h1{
      font-size: 4rem;  
    }
    .card{
        /*  */
        background-color: transparent;
    }
    a.card , a#discover
    {
        border: 0;
        border-radius: 20px;
        color: #000000;
        text-decoration: none;
        font-weight: bold;
    }
    a.card:hover
    {
        color: #b3ffb3;
        background: #5D8A4B;
        transition: 0.3s;
    }
    .card-header{
        color: #000000;
        background: transparent;
        border: none;
    }
    .breadcrumb{
        background-color: transparent;
    }
    a.bread{
        border: 0;
        border-radius: 20px;
        color: #000000;
        text-decoration: none;
        font-weight: bold;
        overflow: hidden;
    }
    a.bread:hover
    {
        color: #b3ffb3;
        background: #5D8A4B;
        transition: 0.3s;
    }

    .fa-shopping-basket, .fa-lightbulb, .fa-info-circle{
        font-size: 3.5rem;
    }
</style>
    
@endsection

@section('content')

{{-- <div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="card col-md-11 p-0 border-0">
                <div class="card-header p-0">
                        <ol class="breadcrumb m-0 p-0">
                            <li class="breadcrumb-item"><a class="bread p-2" href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Categories</li>
                        </ol>

                </div>
                <div class="card-body row">
                    <div class="col-md-8 row">
                        @foreach ($data as $index=>$item)
                        <a href="{{route('home').'/'.$item->category_slug}}" class="card col-md-4 text-center">
                            <div class="card-body">
                                <img class="mb-2" src="{{$item->category_image}}" alt="{{$item->category_name}}" width="128px" height="128px">
                                <h4>
                                {{$item->category_name}}
                                </h4>
                            </div>  
                        </a>
                        @endforeach
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>
            </div>
        </div>
</div> --}}
@endsection
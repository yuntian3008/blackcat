@extends('layouts.web')

@section('title')
Home
@endsection

@section('style')
<style>
    h1{
      font-size: 4rem;  
    }
    .card{
        border-radius: 20px;
    }
    a.card , a#discover
    {
        color: #000000;
        text-decoration: none;
        font-weight: bold;
        border-color: #000000;
    }
    a.card:hover
    {
        color: #b3ffb3;
        background: #5D8A4B;
        transition: 0.3s;
        border-color: #5D8A4B;
    }
    .fa-shopping-basket, .fa-lightbulb, .fa-info-circle{
        font-size: 3.5rem;
    }
</style>
    
@endsection

@section('content')
<div class="container-fluid pt-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div id="bg">
                    <div id="title-container">
                        {{-- {{dd(Auth::user()->rolePermission())}} --}}
                        {{-- <div id="title-bg"></div> --}}
                        <div id="title">
                        <h1 class="mt-5">Miaogo</h1>
                        <h2 class="mb-5 text-uppercase">LOVE PLANTS ? - You are in love with life !</h2>
                        <div class="row p-2 text-center">
                            <a href="{{route('categories')}}" class="card col-md-2 px-0 mx-2 my-2">
                                <div class="card-body">
                                <i class="fas fa-shopping-basket mb-1"></i>
                                PRODUCTS
                                </div>
                            </a>
                            <a href="#" class="card col-md-2 px-0 mx-2 my-2">
                                <div class="card-body">
                                <i class="fas fa-lightbulb mb-1"></i>
                                INSPIRATION
                                </div>
                            </a>
                            <a href="#" class="card col-md-2 px-0 mx-2 my-2">
                                <div class="card-body">
                                <i class="fas fa-info-circle mb-1"></i>
                                ABOUT ME
                                </div>
                            </a>

                            {{-- @foreach ([
                                [
                                'title' => 'Species diversity',
                                'content' => 'More than 500,000 species of plants, including seedlings, moss, ferns and nearby ferns are currently present',
                                ],
                                [
                                'title' => 'Importance',
                                'content' => 'Photosynthesis provides oxygen for life, the starting source of food for all living things'
                                ],
                                [
                                'title' => 'Range',
                                'content' => 'Plants are everywhere on earth, sometimes they can live in the harshest places'
                                ]
                            ] as $item)
                            <div class="card border-light bg-transparent m-4 col-md col-sm-12">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$item['title']}}</h5>
                                        <p class="card-text">{{$item['content']}}</p>
                                    </div>
                                </div>
                            @endforeach --}}
                        </div>
                        <h5 class="mt-4"><a href="#" id="discover">Discover »</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
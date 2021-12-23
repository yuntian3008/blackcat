@extends('layouts.web')

@section('title')
Welcome
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
<div class="container px-6 py-16 mx-auto">
    <div class="items-center lg:flex">
        <div class="w-full lg:w-1/2">
            <div class="lg:max-w-lg">
                <h1 class="text-2xl font-semibold text-gray-800 uppercase dark:text-white lg:text-3xl">Prepare for the perfect coffee shop</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Coffee machines and tools will gladly cater to the coffee enthusiast</p>
                <a href="{{ route('products') }}" type="button" class="mt-4 px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-700 focus:ring-opacity-80" id="send-link" onclick="sendOTP();">
                    Shop Now
                </a>
            </div>
        </div>

        <div class="flex items-center justify-center w-full mt-6 lg:mt-0 lg:w-1/2">
            <img class="w-full h-full lg:max-w-2xl" src="{{ asset('svg/coffee-shop-animate.svg') }}" alt="Catalogue-pana.svg">
        </div>
    </div>
</div>
@endsection

@extends('layouts.web.shop')
@inject('imageProcessing', 'App\Components\Helper\ImageProcessing')

@section('title')
{{ is_null($category) ? __('Shop') : $category->category_name }}
@endsection

@section('products')
@if(is_null($category))
@foreach ($data as $key => $element)

<h2 class="text-2xl font-extrabold text-gray-700 mt-6">{{ $element['category']->category_name }}</h2>
<div class="grid grid-cols-1 gap-8 mt-4 md:grid-cols-2 xl:grid-cols-4">
    @foreach ($element['products'] as $product)
        <a href="{{ route('product.details',[$product->category->category_slug,$product->product_slug]) }}" class="flex flex-col max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 {{-- transform hover:scale-105 motion-reduce:transform-none --}}">
            <div class="px-4 py-2 flex-grow">
                <h1 class="text-3xl font-bold text-gray-800 uppercase dark:text-white">{{ strlen($product->product_name) > 20 ? substr($product->product_name,0,20)."..." : $product->product_name }}</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ strlen($product->product_desc) > 100 ? substr($product->product_desc,0,100)."..." : $product->product_desc }}</p>
            </div>

            <img class="object-cover w-full h-48 mt-2" src="{{ $imageProcessing->getURL($product->product_image,'sm') }}" alt="NIKE AIR">

            <div class="flex items-center justify-between px-4 py-2 bg-gray-700">
                <h1 class="text-lg font-bold text-white">$ {{ number_format($product->product_price, 2)  }}</h1>
                <add-to-cart class="px-2 py-1 text-xs font-semibold text-gray-700 uppercase transition-colors duration-200 transform bg-white rounded hover:bg-gray-200 focus:outline-none" :product_id="{{ $product->id }}" :quantity="1" :available="{{ $product->available ? 1 : 0 }}"  :login_url="'{{ route('login') }}'"></add-to-cart>
            </div>
        </a>
    @endforeach
    
</div>
@endforeach

@else
{{-- SORT SELECT --}}
<div class="flex items-center justify-between text-sm tracking-widest uppercase mb-4">
    <p class="text-gray-500 dark:text-gray-300">@yield('count')</p>
    <div class="flex items-center">
        <p class="text-gray-500 dark:text-gray-300 mr-3">Sort</p>
        <select class="form-select rounded-lg focus:border-0 focus:border-none font-medium text-gray-700 bg-transparent dark:text-gray-500 focus:outline-none" onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
            <option value="{{ url()->current() }}">Recommended</option>
            <option value="{{ url()->current() }}?sort=product_name&sortBy=1" {{ url()->full() == url()->current().'?sort=product_name&sortBy=1' ? "selected" : "" }}>Name (A-Z)</option>
            <option value="{{ url()->current() }}?sort=product_name&sortBy=0" {{ url()->full() == url()->current().'?sort=product_name&sortBy=0' ? "selected" : "" }}>Name (Z-A)</option>
            <option value="{{ url()->current() }}?sort=product_price&sortBy=1" {{ url()->full() == url()->current().'?sort=product_price&sortBy=1' ? "selected" : "" }}>Price (Ascending)</option>
            <option value="{{ url()->current() }}?sort=product_price&sortBy=0" {{ url()->full() == url()->current().'?sort=product_price&sortBy=0' ? "selected" : "" }}>Price (Decrease)</option>
        </select>
    </div>
</div>
{{-- SORT SELECT --}}
@section('count')
    {{ $data->total() }} Items
@endsection
@if($data->total() == 0)
   <div class="w-full text-white bg-gray-700">
        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
            <div class="flex">
                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                    <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z"></path>
                </svg>

                <p class="mx-3">No products</p>
            </div>

        </div>
    </div>
@endif
<div class="grid grid-cols-1 gap-8 mt-4 md:grid-cols-2 xl:grid-cols-4">
    @foreach ($data as $product)
        <a href="{{ route('product.details',[$product->category->category_slug,$product->product_slug]) }}" class="flex flex-col max-w-xs mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 {{-- transform hover:scale-110 motion-reduce:transform-none --}}">
            <div class="px-4 py-2 flex-grow">
                <h1 class="text-xl font-black text-gray-800 uppercase dark:text-white">{{ strlen($product->product_name) > 40 ? substr($product->product_name,0,40)."..." : $product->product_name }}</h1>
                <p class="mt-1 text-xs text-gray-600 dark:text-gray-400">{{ strlen($product->product_desc) > 100 ? substr($product->product_desc,0,100)."..." : $product->product_desc }}</p>
            </div>

            <img class="object-cover w-full h-48 mt-2" src="{{ $imageProcessing->getURL($product->product_image,'sm') }}" alt="NIKE AIR">
          
            <div class="flex items-center justify-between px-4 py-2 bg-gray-700">
                <h1 class="text-lg font-bold text-white">$ {{ number_format($product->product_price, 2)  }}</h1>
                <add-to-cart class="px-2 py-1 text-xs font-semibold text-gray-700 uppercase transition-colors duration-200 transform bg-white rounded hover:bg-gray-200 focus:outline-none" :product_id="{{ $product->id }}" :quantity="1" :available="{{ $product->available ? 1 : 0 }}" :login_url="'{{ route('login') }}'"></add-to-cart>
            </div>
        </a>
    @endforeach
    
</div>
<div class="flex justify-center mt-6">
    {{ $data->links('pagination.tailwind') }}
</div>
@endif
@endsection

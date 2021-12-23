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
@section('vue-id')
id="shop"
@endsection
@section('content')

<search-view :categories="{{ $categories }}"></search-view>

@endsection

@section('script')
    <script src="{{ asset('js/web.js') }}" defer></script>
@endsection
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card outer-card">
            <div class="card-header h5 text-dark"><a class="btn btn-light text-dark btn-sm mr-2" href="#" onclick="openNav()"><i class="fas fa-bars"></i></a>Categories</div>

            <div class="card-body table-responsive">
                <router-view name="categoriesIndex"></router-view>
                <router-view></router-view>
            </div>
        </div>
    </div>
</div>
@endsection
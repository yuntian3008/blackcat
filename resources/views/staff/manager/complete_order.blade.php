@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card outer-card">

            <div class="card-body table-responsive">
                <router-view name="completeordersIndex"></router-view>
                <router-view></router-view>
            </div>
        </div>
    </div>
</div>
@endsection
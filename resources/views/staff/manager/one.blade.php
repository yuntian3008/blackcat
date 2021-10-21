@extends('layouts.app')

@section('content')
<div class="container-fruid">
    <div class="row">
        <div class="col-md-12">
            <router-view name="dashboardIndex"></router-view>
            <router-view></router-view>
        </div>
    </div>
</div>
@endsection
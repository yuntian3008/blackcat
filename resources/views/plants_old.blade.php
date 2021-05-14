@extends('layouts.web')

@section('content')
<div class="container-fluid pt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if ($data->isNotEmpty())
            <ul class="list-unstyled">
                    @foreach ($data as $item)
                    <li class="alert alert-light">
                        <a class="media alert-link" href="{{url()->current()."/".$item->plant_slug}}">
                        <img class="align-self-center mr-3" height="128" width="128" src="{{asset('storage/sm_'.$item->plant_image)}}" alt="{{$item->plant_slug}}">
                            <div class="media-body">
                                <h5 class="mb-0">{{$item->plant_name}}</h5>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            {{ $data->links()}}
            @else
            <div class="alert alert-light text-sm-center" role="Nodata">
                <h4 class="alert-heading">No data</h4>
                <a href="{{route('home')}}" class="btn btn-outline-primary btn-md" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Go homepage</a>
            </div>
            @endif
            
            
            
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="login-form bg-light mt-4 p-4">
                <form method="POST" action="{{ route('admin.login') }}" class="row g-3">
                    @csrf
                    <h4>{{ __('Login') }}</h4>
                    @if (session('message'))
                        <div class="alert alert-danger">{{ session('message') }}</div>
                    @endif
                    <div class="col-12">
                        <label>{{ __('Username') }}</label>
                        <input type="text" name="username" class="form-control" placeholder="{{ __('Username') }}">
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <label>{{ __('Password') }}</label>
                        <input type="password" name="password" class="form-control" placeholder="{{ __('Password') }}">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="rememberMe"> {{ __('Remember Me') }}</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark float-end">{{ __('Login') }}</button>
                    </div>
                </form>
                {{-- <hr class="mt-4">
                <div class="col-12">
                    <p class="text-center mb-0">Have not account yet? <a href="#">Signup</a></p>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="container mx-auto sm:px-4">
    <div class="flex flex-wrap ">
        <div class="md:w-1/3 pr-4 pl-4 md:mx-1/3">
            <div class="login-form bg-gray-100 mt-4 p-6">
                <form method="POST" action="{{ route('admin.login') }}" class="flex flex-wrap  g-3">
                    @csrf
                    <h4>{{ __('Login') }}</h4>
                    @if (session('message'))
                        <div class="relative px-3 py-3 mb-4 border rounded bg-red-200 border-red-300 text-red-800">{{ session('message') }}</div>
                    @endif
                    <div class="w-full">
                        <label>{{ __('Username') }}</label>
                        <input type="text" name="username" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" placeholder="{{ __('Username') }}">
                        @error('username')
                            <span class="hidden mt-1 text-sm text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="w-full">
                        <label>{{ __('Password') }}</label>
                        <input type="password" name="password" class="block appearance-none w-full py-1 px-2 mb-1 text-base leading-normal bg-white text-gray-800 border border-gray-200 rounded" placeholder="{{ __('Password') }}">
                        @error('password')
                            <span class="hidden mt-1 text-sm text-red" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="w-full">
                        <div class="relative block mb-2">
                            <input class="absolute mt-1 -ml-6" type="checkbox" id="rememberMe" {{ old('remember') ? 'checked' : '' }}>
                            <label class="text-gray-700 pl-6 mb-0" for="rememberMe"> {{ __('Remember Me') }}</label>
                        </div>
                    </div>
                    <div class="w-full">
                        <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-gray-900 text-white hover:bg-gray-900 float-end">{{ __('Login') }}</button>
                    </div>
                </form>
                {{-- <hr class="mt-4">
                <div class="w-full">
                    <p class="text-center mb-0">Have not account yet? <a href="#">Signup</a></p>
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection

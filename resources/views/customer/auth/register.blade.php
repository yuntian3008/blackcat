@extends('layouts.web')

@section('style')
<style type="text/css">
</style>

@endsection

@section('title')
{{ __('Sign up') }}
@endsection

@section('main-class')
mt-5
@endsection

@section('nav-cart-class')
style="display:none;"
@endsection

@section('content')
<div class="lg:mt-20 flex max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl">
    <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
        <h2 class="text-2xl text-center text-gray-700 dark:text-white"><strong>Black</strong>Cat</h2>

        <p class="text-xl text-center text-gray-600 dark:text-gray-200">Sign up</p>

        {{-- <a href="#" class="flex items-center justify-center mt-4 text-gray-600 border rounded-lg dark:bg-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
            <div class="px-4 py-2">
                <svg class="w-6 h-6" viewBox="0 0 40 40">
                    <path d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 9.99999 20 9.99999C22.5492 9.99999 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" fill="#FFC107"/>
                    <path d="M5.25497 12.2425L10.7308 16.2583C12.2125 12.59 15.8008 9.99999 20 9.99999C22.5491 9.99999 24.8683 10.9617 26.6341 12.5325L31.3483 7.81833C28.3716 5.04416 24.39 3.33333 20 3.33333C13.5983 3.33333 8.04663 6.94749 5.25497 12.2425Z" fill="#FF3D00"/>
                    <path d="M20 36.6667C24.305 36.6667 28.2167 35.0192 31.1742 32.34L26.0159 27.975C24.3425 29.2425 22.2625 30 20 30C15.665 30 11.9842 27.2359 10.5975 23.3784L5.16254 27.5659C7.92087 32.9634 13.5225 36.6667 20 36.6667Z" fill="#4CAF50"/>
                    <path d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.7592 25.1975 27.56 26.805 26.0133 27.9758C26.0142 27.975 26.015 27.975 26.0158 27.9742L31.1742 32.3392C30.8092 32.6708 36.6667 28.3333 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" fill="#1976D2"/>
                </svg>
            </div>

            <span class="w-5/6 px-4 py-3 font-bold text-center">Sign in with Google</span>
        </a> --}}

        {{-- <div class="flex items-center justify-between mt-4">
            <span class="w-1/5 border-b dark:border-gray-600 lg:w-1/4"></span>

            <a href="#" class="text-xs text-center text-gray-500 uppercase dark:text-gray-400 hover:underline">or login with email</a>

            <span class="w-1/5 border-b dark:border-gray-400 lg:w-1/4"></span>
        </div> --}}
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="mt-4">
                @error('phone')
                <div x-data="{ errorOpen : true }">
                    <div class="w-full text-white bg-red-500 mb-2" x-show="errorOpen">
                        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                            <div class="flex">
                                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                    <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                                </svg>

                                <p class="mx-3">{{ $message }}</p>
                            </div>

                            <button type="button" class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none" x-on:click="errorOpen = false">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                @enderror
                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="phone"> {{  __('Phone number') }}</label>
                <input type="tel" id="phone" name="phone" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" value="{{ old('phone') }}" required autocomplete="phone">   
            </div>

            <div class="mt-4">
                @error('email')
                <div x-data="{ errorOpen : true }">
                    <div class="w-full text-white bg-red-500 mb-2" x-show="errorOpen">
                        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                            <div class="flex">
                                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                    <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                                </svg>

                                <p class="mx-3">{{ $message }}</p>
                            </div>

                            <button type="button" class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none" x-on:click="errorOpen = false">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                @enderror
                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="email"> {{  __('Email') }}</label>
                <input type="email" id="email" name="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" value="{{ old('email') }}" required autocomplete="email">
            </div>

            <div class="mt-4">
                @error('username')
                <div x-data="{ errorOpen : true }">
                    <div class="w-full text-white bg-red-500 mb-2" x-show="errorOpen">
                        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                            <div class="flex">
                                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                    <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                                </svg>

                                <p class="mx-3">{{ $message }}</p>
                            </div>

                            <button type="button" class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none" x-on:click="errorOpen = false">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                @enderror
                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="username"> {{  __('Username') }}</label>
                <input id="username" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="text" name="username" value="{{ old('username') }}" required autocomplete="username" autofocus>
            </div>

            <div class="mt-4">
                @error('password')
                <div x-data="{ errorOpen : true }">
                    <div class="w-full text-white bg-red-500 mb-2" x-show="errorOpen">
                        <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                            <div class="flex">
                                <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                    <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z"></path>
                                </svg>

                                <p class="mx-3">{{ $message }}</p>
                            </div>

                            <button type="button" class="p-1 transition-colors duration-200 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none" x-on:click="errorOpen = false">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                @enderror
                <div class="flex justify-between">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="password">{{  __('Password') }}</label>
                </div>

                <input id="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="password" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
            </div>

            <div class="mt-4">
                <div class="flex justify-between">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="confirm_password">{{  __('Confirm Password') }}</label>
                </div>

                <input id="confirm_password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="password" name="password_confirmation" required autocomplete="new-password" autofocus>
            </div>

            <div class="mt-8">
                <button type="submit" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                    {{ __('Sign up') }}
                </button>
            </div>
            
            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>

                <a href="{{ route('login') }}" class="text-xs text-gray-500 uppercase dark:text-gray-400 hover:underline">or sign in</a>
                
                <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
            </div>
        </form> 
    </div>
    <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image:url('https://images.unsplash.com/photo-1513211888420-0a4531c612b2?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80')"></div>
</div>
@endsection

{{-- @extends('layouts.web')

@section('style')
<style type="text/css">
    .or-seperator {
    margin: 20px 0 10px;
    text-align: center;
    border-top: 1px solid #ccc;
}
.or-seperator i {
    padding: 0 10px;
    background: #ffffff;
    position: relative;
    top: -11px;
    z-index: 1;
}
.login-form {
    background-color: #fff;
}
</style>

@endsection

@section('main-class')
mt-5
@endsection

@section('nav-cart-class')
style="display:none;"
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-md-6">
            <div class="login-form border p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h3 class="text-center pb-2">{{ __('Đăng kí') }}</h3>
                    <h5>Infomation</h5>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-phone-alt"></i></div>
                                </div>
                                <input type="tel" id="phone" name="phone" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" class="form-control @error('phone') is-invalid @enderror" placeholder="Số điện thoại" value="{{ old('phone') }}" required autocomplete="phone">

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-5 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-envelope"></i></div>
                                </div>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Địa chỉ email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-3 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-transgender-alt"></i></div>
                                </div>
                                <select id="gender" name="gender" class="custom-select @error('dob') is-invalid @enderror" value="{{ old('dob') }}" required autocomplete="gender">
                                    <option value="0">Nam</option>
                                    <option value="1">Nữ</option>
                                    <option value="-1">Khác</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="firstname" name="firstname" class="form-control @error('firstname') is-invalid @enderror" placeholder="Tên" value="{{ old('firstname') }}" required autocomplete="firstname">

                                @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="lastname" name="lastname" class="form-control @error('lastname') is-invalid @enderror" placeholder="Họ và tên lót" value="{{ old('lastname') }}" required autocomplete="lastname">

                                @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-birthday-cake"></i></div>
                                </div>
                                <input type="date" id="dob" name="dob" class="form-control @error('dob') is-invalid @enderror" max="{{ now()->toDateString()}}" value="{{ old('dob') }}" required autocomplete="new-password">
                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h5>Address</h5>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror" placeholder="Country" value="{{ old('country') }}" required autocomplete="country">

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="province" name="province" class="form-control @error('province') is-invalid @enderror" placeholder="Province/City" value="{{ old('province') }}" required autocomplete="province">

                                @error('province')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="district" name="district" class="form-control @error('district') is-invalid @enderror" placeholder="District" value="{{ old('district') }}" required autocomplete="district">

                                @error('district')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="ward" name="ward" class="form-control @error('ward') is-invalid @enderror" placeholder="Ward" value="{{ old('ward') }}" required autocomplete="ward">

                                @error('ward')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" placeholder="Address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <h5>Account</h5>
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-user-alt"></i></div>
                                </div>
                                <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Tên người dùng" value="{{ old('username') }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Mật khẩu" value="{{ old('password') }}" required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <input type="password" id="password_confirm" name="password_confirmation" placeholder="Nhập lại mật khẩu" class="form-control"required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <span class="text-brown">Already have an account?</span> <a href="#" class="text- text-decoration-none">Sign in</a>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <button type="submit" class="btn btn-outline-dark" id="signup">Đăng kí</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="col"></div>
    </div>
</div><div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>
                                <a class="btn btn-link" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                                @if (Route::has('password.request'))
                                    |<a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> --}}
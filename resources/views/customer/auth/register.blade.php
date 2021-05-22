@extends('layouts.web')

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

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col"></div>
        <div class="col-md-3">
            <div class="login-form border p-4">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <h3 class="text-center pb-2">{{ __('Đăng kí') }}</h3>
                    <div class="form-group row">
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
                        <div class="col-sm-12 mb-1">
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
</div>
{{-- <div class="container">
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
@endsection

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
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <h3 class="text-center pb-2">{{ __('Reset password') }}</h3>
                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="uid" value="{{ $uid }}">
                    <input type="hidden" name="id" value="{{ $id }}">
                    <div class="form-group row">
                        <div class="col-sm-12 mb-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="fas fa-key"></i></div>
                                </div>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="New password" required autocomplete="new-password">

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
                                <input type="password" id="password_confirm" name="password_confirmation" placeholder="Confirm new password" class="form-control"required autocomplete="new-password">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <button type="submit" class="btn btn-outline-dark" id="signup">Set new password</button>
                        </div>
                    </div>
                </form>
            </div>
            
        </div>
        <div class="col"></div>
    </div>
</div>
@endsection
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
        <div class="col-lg-3 col-md-6 col-sm-10">
            <div class="login-form border p-4">
                <form id="user-login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <h3 class="text-center pb-2">{{ __('Verify Your Phone Number') }}</h3>
                    {{-- <a class="btn btn-outline-primary btn-block" href="#"><i class="fab fa-facebook-f mx-2"></i>Sign in with <b>Facebook</b></a>
                    <a class="btn btn-outline-danger btn-block" href="#"><i class="fab fa-google mx-2"></i>Sign in with <b>Google</b></a> --}}
                    {{-- <div class="or-seperator"><i>or</i></div> --}}
                    @guest
                    <div class="form-group row">
                        <div class="alert alert-warning col-sm-12 mb-0" id="message">Please verify OTP to change password</div>
                        <div class="alert alert-danger col-sm-12 mt-2 mb-0" id="error" style="display: none;"></div>
                        <div class="alert alert-success col-sm-12 mt-2 mb-0" id="successAuth" style="display: none;"></div>
                        <div class="alert alert-success col-sm-12 mt-2 mb-0" id="successOtpAuth" style="display: none;"></div>
                    </div>
                
                    <div class="form-group row">
                        <div id="recaptcha-container" class="col-sm-12 text-center"></div>
                    </div>
                    
                    <div class="form-group row">
                        <div class="input-group col-sm-12 p-0">
                            <input type="text" class="form-control" placeholder="Phone number" id="phone" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" required autocomplete="phone">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button"id="send-link" onclick="sendOTP();">Send OTP</button>
                                {{-- <strong id="countdownDisplay" style="display: none;"></strong> --}}
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <input type="text" id="verification" class="form-control col-sm-12" placeholder="Verification code">
                    </div>
                    <div class="form-group row">
                        <button type="button" class="btn btn-warning col-sm-12" onclick="verify()">Verify</button>
                    </div>
                    <!-- The core Firebase JS SDK is always required and must be listed first -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                    <script src="https://www.gstatic.com/firebasejs/8.6.1/firebase.js"></script>

                    <!-- TODO: Add SDKs for Firebase products that you want to use
                         <setup id="available-libraries"></setup> -->

                    <script>
                      // Your web app's Firebase configuration
                      var firebaseConfig = {
                        apiKey: "AIzaSyC67ztfyyqe6bUsZQ6DuwAheZ7YzjsjV6o",
                        authDomain: "blackcat-6457a.firebaseapp.com",
                        projectId: "blackcat-6457a",
                        storageBucket: "blackcat-6457a.appspot.com",
                        messagingSenderId: "1008282368219",
                        appId: "1:1008282368219:web:d93f28c3b67d55791d74fe"
                      };
                      // Initialize Firebase
                      firebase.initializeApp(firebaseConfig);
                    </script>
                    <script type="text/javascript">
                        function countdown(duration) {
                            $('#send-link').attr("disabled", true);
                            var timer = duration,
                                seconds;
                            var interval = setInterval(function () {

                                seconds = parseInt(timer % 60, 10);

                                $('#send-link').text("Try again in " + seconds);

                                if (--timer < 0) {
                                    $('#send-link').text("Send OTP");
                                    $('#send-link').attr("disabled", false);
                                    $("#successAuth").fadeOut(100);
                                    clearInterval(interval);
                                    return;
                                }
                            }, 1000);
                        };
                        window.onload = function () {
                            render();
                            $("#successAuth").hide();
                        };

                        function render() {
                            window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
                            recaptchaVerifier.render();
                        }

                        function sendOTP() {
                            if ($('#phone')[0].checkValidity() == true) {
                                var number = $("#phone").val();
                                number = "+84"+number.substring(1,number.length);
                                firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                                    window.confirmationResult = confirmationResult;
                                    coderesult = confirmationResult;
                                    //console.log(coderesult);
                                    $("#error").hide();
                                    $("#successAuth").text("Verification code sent. Check your phone");
                                    setTimeout(function() {
                                        
                                    }, 2000);
                                    $('#recaptcha-container').parent().fadeOut(100);
                                    $("#successAuth").show();
                                    countdown(59);
                                }).catch(function (error) {
                                    $("#error").text(error.message);
                                    $("#error").show();
                                });
                            }
                            else {
                                $("#error").text("Phone number is not valid");
                                $("#error").show();
                            }
                        }

                        function verify() {
                            var code = $("#verification").val();
                            coderesult.confirm(code).then(function (result) {
                                var user = result.user;
                                $("#successOtpAuth").text("Auth is successful");
                                $("#successOtpAuth").show();
                                $("#error").hide();
                                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                                $.post(
                                    '/password/otp',
                                    {
                                        _token: CSRF_TOKEN, 
                                        token: user.refreshToken,
                                        uid: user.uid,
                                    }, function (data, status) { 
                                        document.location.href = '/password/reset/'+data; 
                                    }); 
                            }).catch(function (error) {
                                $("#error").text(error.message);
                                $("#error").show();
                            });
                        }
                    </script>
                    @endguest
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

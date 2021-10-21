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
<div class="lg:mt-20 flex max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-1xl">
    
        <div class="w-full px-6 py-8 md:px-8">
            <h2 class="text-2xl text-center text-gray-700 dark:text-white"><strong>Black</strong>Cat</h2>

            <p class="text-xl text-center text-gray-600 dark:text-gray-200 mt-2">Before proceeding, please verify your phone for a OTP code</p>

                <div class="mt-4 flex justify-center">
                     <div id="recaptcha-container"></div>
                </div>
                <div class="mt-4 flex justify-between">
                    <div>Your phone: {{ substr(Auth::user()->phone, 0, 2) . "******" . substr(Auth::user()->phone, 8, 2)}}</div>
                    <button type="button" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-700 focus:ring-opacity-80" id="send-link" onclick="sendOTP();">
                        Send code
                    </button>
                    <strong id="countdownDisplay" class="hidden"></strong>
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
                        <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="verification">{{  __('Verification Code') }}</label>
                    </div>

                    <input id="verification" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="text" required>
                </div>

                <div class="mt-8">
                    <button type="button" class="w-full px-4 py-2 tracking-wide text-white transition-colors duration-200 transform bg-gray-700 rounded hover:bg-gray-600 focus:outline-none focus:bg-gray-600" onclick="verify()">
                        {{ __('Verify') }}
                    </button>
                </div>
        </div>
    
</div>
@endsection

@section("script")
@auth
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="application/javascript" src="https://www.gstatic.com/firebasejs/8.6.1/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     <setup id="available-libraries"></setup> -->

<script type="application/javascript">
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
<script type="application/javascript">
    function countdown(duration, display) {
        $('#send-link').fadeOut(100);
        var timer = duration,
            seconds;
        var interval = setInterval(function () {

            seconds = parseInt(timer % 60, 10);

            display.show();
            display.text("Try again in " + seconds+'s');

            if (--timer < 0) {
                display.hide();
                clearInterval(interval);
                $('#send-link').show();
                return;
            }
        }, 1000);
    };
    window.onload = function () {
        render();
    };

    function render() {
        window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
        recaptchaVerifier.render();
    }

    function sendOTP() {
        var number = "{{ Auth::user()->phone }}";
        number = "+84"+number.substring(1,number.length);
        firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
            window.confirmationResult = confirmationResult;
            coderesult = confirmationResult;
            //console.log(coderesult);
            Swal.fire(
              'Successfully!',
              'Message sent. Check your phone',
              'success'
            ).then((result) => {
                $('#recaptcha-container').parent().fadeOut(100);
                countdown(59,$("#countdownDisplay"));
            });
            
        }).catch(function (error) {
            Swal.fire(
              'Error?',
              error.message,
              'error'
            );
        });
    }

    function verify() {
        var code = $("#verification").val();
        coderesult.confirm(code).then(function (result) {
            var user = result.user;
            Swal.fire(
              'Successfully!',
              'Your phone number is verified!',
              'success'
            ).then((result) => {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    /* the route pointing to the post function */
                    url: '/verify-otp',
                    type: 'POST',
                    /* send the csrf-token and the input to the controller */
                    data: {
                        _token: CSRF_TOKEN, 
                        token: user.refreshToken,
                        uid: user.uid,
                    },
                    /* remind that 'data' is the response of the AjaxController */
                    success: function (data) { 
                        console.log("successfully");
                        setTimeout(function(){// wait for 5 secs(2)
                               location.reload(); // then reload the page.(3)
                          }, 2000); 
                    }
                }).done(function(data) {
                   location.reload();
                }); 
            });
            
        }).catch(function (error) {
            Swal.fire(
              'Error?',
              error.message,
              'error'
            );
        });
    }
</script>
@endauth
@endsection
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
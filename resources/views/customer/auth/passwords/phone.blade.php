@extends('layouts.web')

@section('title')
{{ __('Verify Phone') }}
@endsection

@section('content')
<div class="lg:mt-20 flex max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-1xl">

        <div class="w-full px-6 py-8 md:px-8">
            <h2 class="text-2xl text-center text-gray-700 dark:text-white"><strong>Black</strong>Cat</h2>

            <p class="text-xl text-center text-gray-600 dark:text-gray-200 mt-2">{{ __('Reset password') }}</p>

                <div class="mt-4 flex justify-center">
                     <div id="recaptcha-container"></div>
                </div>
                <div class="mt-4 flex">
                    <div class="block w-full">
                        <div class="flex justify-between">
                        <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="phone">{{  __('Phone number') }}</label>
                        </div>

                        <input id="phone" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" type="text" required>
                    </div>
                </div>
                <div class="mt-4">
                    <button type="button" class="px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-700 focus:ring-opacity-80" id="send-link" onclick="sendOTP();">
                        Send code
                    </button>
                    <strong id="countdownDisplay" class="hidden"></strong>
                </div>
                <div class="mt-4 hidden verification">
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

                <div class="mt-4 hidden verification">
                    <button type="button" class="flex justify-center items-center px-4 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-200 transform bg-gray-700 rounded-md hover:bg-gray-600 focus:outline-none focus:ring focus:ring-gray-700 focus:ring-opacity-80" onclick="verify()">
                        {{ __('Verify') }}
                        <svg width="20" height="20" fill="currentColor" class="hidden loading ml-2 animate-spin" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                            <path d="M526 1394q0 53-37.5 90.5t-90.5 37.5q-52 0-90-38t-38-90q0-53 37.5-90.5t90.5-37.5 90.5 37.5 37.5 90.5zm498 206q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-704-704q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm1202 498q0 52-38 90t-90 38q-53 0-90.5-37.5t-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-964-996q0 66-47 113t-113 47-113-47-47-113 47-113 113-47 113 47 47 113zm1170 498q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-640-704q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm530 206q0 93-66 158.5t-158 65.5q-93 0-158.5-65.5t-65.5-158.5q0-92 65.5-158t158.5-66q92 0 158 66t66 158z">
                            </path>
                        </svg>
                    </button>
                </div>
        </div>

</div>
@endsection

@section("script")
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="application/javascript" src="https://www.gstatic.com/firebasejs/8.6.1/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     <setup id="available-libraries"></setup> -->

<script type="application/javascript">
  // Your web app's Firebase configuration
  const firebaseConfig = {
  apiKey: "AIzaSyA1faUfcsyeQ6HrCvO8AsPycOtXGy2EHcg",
  authDomain: "blackcat-322610.firebaseapp.com",
  databaseURL: "https://blackcat-322610-default-rtdb.asia-southeast1.firebasedatabase.app",
  projectId: "blackcat-322610",
  storageBucket: "blackcat-322610.appspot.com",
  messagingSenderId: "585485829153",
  appId: "1:585485829153:web:d22ed075dcb9e943298f60",
  measurementId: "G-NY2YV5MC3Y"
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
        if ($('#phone')[0].checkValidity() == true) {
            var number = $("#phone").val();
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
                    $('.verification').fadeIn();
                });

            }).catch(function (error) {
                Swal.fire(
                  'Error?',
                  error.message,
                  'error'
                );
            });
        }
        else Swal.fire(
                  'Error?',
                  'Phone number is invalid',
                  'error'
                );
    }

    function verify() {
        $('.verification').show();
        var code = $("#verification").val();
        coderesult.confirm(code).then(function (result) {
            var user = result.user;
            Swal.fire(
              'Successfully!',
              '',
              'success'
            ).then((result) => {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.post(
                        '/password/otp',
                        {
                            _token: CSRF_TOKEN,
                            token: user.refreshToken,
                            uid: user.uid,
                        }, function (data, status) {
                            document.location.href = '/password/reset/'+data;
                    }).catch(function (error) {
                        Swal.fire(
                          'Error?',
                          error.message,
                          'error'
                        );
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
@endsection

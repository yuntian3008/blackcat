<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="{{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->api_token : '' }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="shortcut icon" type="image/png" href="{{asset('favicon.ico')}}"/>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    .zoom {
    transition: transform .2s; /* Animation */
    }

    .zoom:hover {
    transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
</style>
</head>
<body>
    @guest
    @else
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="{{route('admin.manager.dashboard')}}">Dashboard</a>
        @if (Auth::guard('admin')->user()->hasAnyRole(['admin','superadmin']))
        <a href="{{route('admin.manager.customer')}}">Customer</a>
        <a href="{{route('admin.manager.staff')}}">Staff</a>
        @endif
        @if (Auth::guard('admin')->user()->hasAnyRole(['productmanager','superadmin']))
        <a href="{{route('admin.manager.category')}}">Categories</a>
        <a href="{{route('admin.manager.product')}}">Products</a>
        @endif
        @if (Auth::guard('admin')->user()->hasAnyRole(['ordermanager','superadmin']))
        <a href="{{route('admin.manager.get-orders')}}">Get orders</a>
        <a href="{{route('admin.manager.ship-orders')}}">Ship orders</a>
        @endif
        @if (Auth::guard('admin')->user()->hasAnyRole(['shipper','superadmin']))
        <a href="{{route('admin.manager.complete-orders')}}">Complete orders</a>
        @endif
    </div>
    @endguest
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                {{-- <a class="navbar-brand" href="{{route('admin.index')}}">
                    {{ config('app.name', 'Laravel') }} Manager
                </a> --}}
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            {{-- <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="btn btn-outline-dark dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::guard('admin')->user()->first_name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    {{-- <a class="dropdown-item" href="{{ route('user_dashboard') }}">Dashboard</a> --}}
                                    {{-- <a class="dropdown-item" href="{{ route('user_profile') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('user_security') }}">Security</a> --}}
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pb-4">
            @yield('content')
        </main>
        <footer class="bd-footer text-muted">
            <div class="container-fluid p-3 p-md-5">
                <ul class="bd-footer-links">
                <li><a href="https://github.com/thiensgith/web0001">GitHub</a></li>
                <li><a href="https://www.facebook.com/borntodiee">A Cute Cat</a></li>
                <li><a href="#">About</a></li>
                </ul>
                <p>Designed and built with all the love of <a href="https://www.facebook.com/borntodiee">A Cute Cat</a> with the help of <a href="#">open source</a>.</p>
            </div>
        </footer>
    </div>
    @yield('script')
    <script type="text/javascript">
        /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
        function openNav() {
          document.getElementById("mySidenav").style.width = "250px";
          document.getElementById("app").style.marginLeft = "250px";
        }

        /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
        function closeNav() {
          document.getElementById("mySidenav").style.width = "0";
          document.getElementById("app").style.marginLeft = "0";
        }
    </script>
</body>
</html>

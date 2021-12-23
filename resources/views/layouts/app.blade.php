<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
    body {
        font-family: 'Quicksand', 'Open Sans';
        padding-top: 0;
    }
    .zoom {
    transition: transform .2s; /* Animation */
    }

    .zoom:hover {
    transform: scale(1.1); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
</style>
</head>
<body>
    <div id="app">
        @auth
        <div class="offcanvas offcanvas-start bg-dark text-light" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header bg-white">
                <h5 class="offcanvas-title " id="offcanvasWithBothOptionsLabel"><a class="text-dark text-decoration-none" href="#"><strong>Black</strong>Cat - Admin Page</a></h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body navbar-dark">
                <ul class="navbar-nav flex-column fsize-24 text-light">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link" data-bs-dismiss="offcanvas">Dashboard</router-link>
                    </li>
                    @if (Auth::guard('admin')->user()->hasAnyRole(['admin','superadmin']))
                    <li class="nav-item">
                        <router-link :to="{name: 'indexCustomer'}" class="nav-link" data-bs-dismiss="offcanvas">Customer</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'indexStaff'}" class="nav-link" data-bs-dismiss="offcanvas">Staff</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'indexSetting'}" class="nav-link" data-bs-dismiss="offcanvas">Setting</router-link>
                    </li>
                    @endif
                    @if (Auth::guard('admin')->user()->hasAnyRole(['productmanager','superadmin']))
                    <li class="nav-item">
                        <router-link :to="{name: 'indexCategory'}" class="nav-link" data-bs-dismiss="offcanvas">Category</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'indexProduct'}" class="nav-link" data-bs-dismiss="offcanvas">Product</router-link>
                    </li>
                    @endif
                    @if (Auth::guard('admin')->user()->hasAnyRole(['ordermanager','superadmin']))
                    <li class="nav-item">
                        <router-link :to="{name: 'indexHandleOrder'}" class="nav-link" data-bs-dismiss="offcanvas">Handle Orders</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'indexShipOrder'}" class="nav-link" data-bs-dismiss="offcanvas">Ready Orders</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'indexCompleteOrder'}" class="nav-link" data-bs-dismiss="offcanvas">Orders are being delivered</router-link>
                    </li>
                    @endif
                    {{-- @if (Auth::guard('admin')->user()->hasAnyRole(['shipper','superadmin']))
                    <li class="nav-item">
                        <router-link :to="{name: 'indexShipOrder'}" class="nav-link" data-bs-dismiss="offcanvas">Ready Orders</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link :to="{name: 'indexCompleteOrder'}" class="nav-link" data-bs-dismiss="offcanvas">Orders are being delivered</router-link>
                    </li>
                    @endif --}}
                    @if (Auth::guard('admin')->user()->hasAnyRole(['accountant','superadmin']))
                    <li class="nav-item">
                        <router-link :to="{name: 'indexStatistic'}" class="nav-link" data-bs-dismiss="offcanvas">Statistic</router-link>
                    </li>
                    @endif
                    
                    {{-- <li class="nav-item">
                        <router-link :to="{name: 'indexPermission'}" class="nav-link" data-bs-dismiss="offcanvas">Permission</router-link>
                    </li> --}}
                    
                    
                </ul>
            </div>
        </div>
        @endauth
        <nav class="navbar navbar-expand navbar-light bg-light fsize-20">
            <div class="container">
                @guest
                <a class="navbar-brand py-0" href="#"><strong>Black</strong>Cat - Admin Page</a>
                @endguest
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        {{-- <li class="nav-item">
                            <a class="btn btn-light text-dark btn-sm mr-2" href="#" onclick="openNav()"><i class="fas fa-bars"></i></a>
                        </li> --}}
                        @auth
                        <li class="nav-item">
                            <a href="#" class="nav-link" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions"><i class="bi bi-list"></i>Menu</a>
                        </li>
                        @endauth
                        
                    </ul>


                    <ul class="navbar-nav d-flex">
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
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::guard('admin')->user()->firstname }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                {{-- <a class="dropdown-item" href="{{ route('user_dashboard') }}">Dashboard</a> --}}
                                {{-- <a class="dropdown-item" href="{{ route('user_profile') }}">Profile</a>
                                <a class="dropdown-item" href="{{ route('user_security') }}">Security</a> --}}
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.logout') }}"
                                        onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                                
                            </ul>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="pb-4">
            <div class="container">
            @yield('content')
            </div>  
        </main>
        {{-- <footer class="bd-footer text-muted">
            <div class="container p-3 p-md-5">
                <ul class="bd-footer-links">
                <li><a href="https://github.com/thiensgith/web0001">GitHub</a></li>
                <li><a href="https://www.facebook.com/borntodiee">A Cute Cat</a></li>
                <li><a href="#">About</a></li>
                </ul>
                <p>Designed and built with all the love of <a href="https://www.facebook.com/borntodiee">A Cute Cat</a> with the help of <a href="#">open source</a>.</p>
            </div>
        </footer> --}}
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

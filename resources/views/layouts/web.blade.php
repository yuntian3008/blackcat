    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="api-token" content="null">
    <title>@yield('title') - {{ config('app.name', 'Miaogo') }}</title>

    {{-- <link rel="shortcut icon" href="../_public/images/logo/favicon.ico" type="image/x-icon"> --}}

    {{-- <link rel="icon" href="../_public/images/logo/favicon.ico" type="image/x-icon"> --}}

    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/fontawesome/css/all.css')}}">

    <!-- Styles -->
    <link href="{{ asset('css/utilities.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    @yield('style')
    
</head>

<body>
    <!-- ============= MENU ============== -->
    <nav class="navbar navbar-expand-md navbar-dark bg-light fixed-top fsize-20 p-md-0">
        <a class="navbar-brand abs fsize-40 mx-md-3 text-brown" href="#">
            {{-- <img src="{{ asset('assets/images/logo/WantedCoffee.png') }}" width="100" height="100" class="d-inline-block align-top mr-2" alt="" loading="lazy"> --}}WANTED COFFEE
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse pl-3" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link hvr-underline-from-left py-3 mr-2 text-brown" href="{{ route('home') }}">HOME</a>
                </li>
                <li class="nav-item subnav">
                    <a class="nav-link hvr-underline-from-left py-3 mr-2 dropdown-toggle text-brown" href="#">CATEGORY</a>
                    <div class="subnav-content p-3">
                        <div class="single category">
                            <h3 class="side-title">Category</h3>
                            <ul class="list-unstyled">
                                @foreach ($navbar_data as $category)
                                    <li><a href="{{ route('products', $category->category_slug) }}" title="">{{ $category->category_name }} <span class="float-right">{{ $category->products()->where('product_visible', 1)->count() }}</span></a></li>
                                @endforeach
                                
                            </ul>
                       </div>
                        {{-- <div class="row no-gutters">
                            <div class="col-md-3 p-1">
                                <h5 class="m-0 text-brown mb-3">BARISTA</h5>
                                <ul class="list-unstyled text-small">
                                    <li><a class="text-warning subimg" href="#">BARISTA TOOLS</a></li>
                                    <li><a class="text-warning subimg" href="#">BOOKS</a></li>
                                    <li><a class="text-warning subimg" href="#">CUPS AND MUGS</a></li>
                                    <li><a class="text-warning subimg" href="#">MILK JUGS & LATTE ART</a></li>
                                    <li><a class="text-warning subimg" href="#">TEMPERS</a></li>
                                </ul>
                            </div>

                            <div class="col-md-3 p-1">
                                <h5 class="m-0 text-brown mb-3">BREWING</h5>
                                <ul class="list-unstyled text-small">
                                    <li><a class="text-warning subimg" href="#">BREWERS</a></li>
                                    <li><a class="text-warning subimg" href="#">FILTERS</a></li>
                                    <li><a class="text-warning subimg" href="#">GRINDERS & ACCESSORIES</a></li>
                                    <li><a class="text-warning subimg" href="#">KATTLES AND SCALES</a></li>
                                </ul>
                            </div>

                            <div class="col-md-3 p-1">
                                <h5 class="m-0 text-brown mb-3">MACHINES</h5>
                                <ul class="list-unstyled text-small">
                                    <li><a class="text-warning subimg" href="#">MACHINES</a></li>
                                </ul>
                            </div>
                            
                            <div class="col-md-3 p-1">
                                <h5 class="m-0 text-brown mb-3">ROASTING</h5>
                                <ul class="list-unstyled text-small">
                                    <li><a class="text-warning subimg" href="#">ROASTING</a></li>
                                </ul>
                            </div>
                        </div> --}}
                    </div>
                </li>
                {{-- <li class="nav-item">
                    <div id="searchzone">
                        <a id="ad-search" class="text-white" href="#">Advanced search</a>
                        <div class="search-container">
                            <input type="text" placeholder="Search..." id="search-bar">
                            <div class="search"></div>
                            <a href="#" id="advanced-search">Search more</a>
                        </div>
                        <ul class="search-bar list-group" id="search-result">   
                        </ul>
                    </div>
                    
                    
                    <!-- <a class="nav-link hvr-underline-from-left py-3 mr-2 text-brown" href="#"><i class="fas fa-search mx-2"></i></a> -->
                </li> --}}
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link hvr-underline-from-left py-3 mr-2 text-brown" href="#"><i class="fas fa-shopping-cart mx-2" id="iconCartCount"></i></a>
                </li>
                <li class="nav-item" id="auth">
                    
                </li>
            </ul>
        </div>
    </nav>
    <!-- =========================== -->
    <main class="@yield('main-class')">
        @yield('content')
    </main>

    {{-- <script type="text/javascript">
        // $.getJSON( "../data.json", function( data ) {
        //     alert(data.logged);
        // });
    </script>
    <div insert-html="../_template/footer_category_coffee.html"></div>
    <script src="../_public/js/lib/jquery-3.5.1.min.js"></script>
    <script data-main="../_public/js/main" src="../_public/js/require.js"></script> --}}
    @yield('script')
</body>

</html>
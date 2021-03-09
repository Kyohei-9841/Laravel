<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/add.css') }}" rel="stylesheet">

    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/now-ui-dashboard.css?v=1.5.0') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="{{ asset('assets/demo/demo.css') }}" rel="stylesheet" />

</head>
<body class="">
    <div class="wrapper ">
        @guest
        @else
            <div class="sidebar" data-color="orange">
                <div class="logo">
                    <a href="{{ url('/') }}" class="simple-text logo-normal">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                @if (Auth::user()->role == 1)
                    <div class="sidebar-wrapper" id="sidebar-wrapper">
                        <ul class="nav">
                            <li>
                                <a href="{{ route('home') }}">
                                    <i class="now-ui-icons sport_user-run"></i>
                                    <p>{{ __('ランキング') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('fishing-results') }}">
                                    <i class="now-ui-icons design_bullet-list-67"></i>
                                    <p>{{ __('釣果一覧') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{route('upload', ['id' => Auth::user()->id])}}">
                                    <i class="now-ui-icons arrows-1_cloud-upload-94"></i>
                                    <p>{{ __('アップロード') }}</p>
                                </a>
                            </li>
                        </ul>
                    </div>        
                @elseIf (Auth::user()->role == 0)
                    <div class="sidebar-wrapper" id="sidebar-wrapper">
                        <ul class="nav">
                            <li>
                                <a href="{{ route('home') }}">
                                    <i class="now-ui-icons sport_user-run"></i>
                                    <p>{{ __('ランキング') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin-fishing-results') }}">
                                    <i class="now-ui-icons design_bullet-list-67"></i>
                                    <p>{{ __('釣果一覧') }}</p>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('approval') }}">
                                    <i class="now-ui-icons ui-2_like"></i>
                                    <p>{{ __('画像承認') }}</p>
                                </a>
                            </li>
                        </ul>
                    </div>        
                @endif
            </div>
        @endguest
        <div class="main-panel" id="main-panel">
            <nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        @guest
                        @else
                            <div class="navbar-toggle">
                                <button type="button" class="navbar-toggler">
                                    <span class="navbar-toggler-bar bar1"></span>
                                    <span class="navbar-toggler-bar bar2"></span>
                                    <span class="navbar-toggler-bar bar3"></span>
                                </button>
                            </div>
                        @endguest
                        <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="now-ui-icons arrows-1_minimal-right"></i>
                                        <p>
                                            <span class="d-lg-none d-md-block">{{ __('Login') }}</span>
                                        </p>
                                    </a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">
                                            <i class="now-ui-icons media-2_sound-wave"></i>
                                            <p>
                                                <span class="d-lg-none d-md-block">{{ __('Entry') }}</span>
                                            </p>
                                        </a>
                                    </li>    
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('home') }}">
                                        <i class="now-ui-icons sport_user-run"></i>
                                        <p>
                                            <span class="d-lg-none d-md-block">{{ __('ランキング') }}</span>
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="now-ui-icons location_world"></i>
                                        <p>
                                            <span class="d-lg-none d-md-block">{{ Auth::user()->name }}</span>
                                        </p>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </li>    
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="panel-header panel-header-sm">
            </div>
            <div class="content">
                <div class="row">
                    <main class="py-4" style="width:100%">
                        @yield('content')
                    </main>                
                </div>
            </div>
        </div>
    </div>
    <!--   Core JS Files   -->
    <script src="{{ asset('assets/js/core/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('assets/js/plugins/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets/js/now-ui-dashboard.min.js?v=1.5.0') }}" type="text/javascript"></script><!-- Now Ui Dashboard DEMO methods, don't include it in your project! -->
    <script src="{{ asset('assets/demo/demo.js') }}"></script>
</body>
</html>

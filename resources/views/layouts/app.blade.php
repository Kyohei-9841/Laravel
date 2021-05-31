<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ config('app.name', 'Laravel') }}</title>
		{{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

		<link rel="stylesheet" href="{{ asset('css/app.css') }}">
		<script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=true"></script>
		{{-- <script src="js/fixmenu_pagetop.js"></script> --}}
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
        <nav id="follow-header" class="navbar navbar-expand-lg navbar-dark bg-primary">
            @php
                $url = url()->current();
            @endphp
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item {{ $url == "http://localhost:8000" ? "active" : "" }}">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('トップページ') }}</a>
                        </li>
                        <li class="nav-item {{ strpos($url, "login") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                        </li>
                        <li class="nav-item {{ strpos($url, "register") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('会員登録') }}</a>
                        </li>
                    @else
                        <li class="nav-item {{ $url == "http://localhost:8000" ? "active" : "" }}">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('トップページ') }}</a>
                        </li>
                        <li class="nav-item {{ strpos($url, "profile") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route('profile', ['id' => Auth::user()->id, 'back_btn_flg' => 0]) }}">{{ __('プロフィール') }}</a>
                        </li>
                        <li class="nav-item {{ strpos($url, "event") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route('event-management', ['id' => Auth::user()->id]) }}">{{ __('イベント管理') }}</a>
                        </li>

                        {{-- <li class="nav-item dropdown {{ strpos($url, "event") ? "active" : "" }}">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ __('イベント管理') }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dark bg-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="{{ url('/') }}">{{ __('参加中イベント') }}</a>
                                <a class="dropdown-item" href="{{ url('/') }}">{{ __('企画イベント') }}</a>
                            </div>
                        </li> --}}
                        <li class="nav-item {{ strpos($url, "upload") ? "active" : "" }}">
                            <a class="nav-link" href="{{ route('upload-top', ['id' => Auth::user()->id]) }}">{{ __('釣果アップロード') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('友達一覧') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('メッセージ') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">{{ __('通知') }}</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"
                            >{{ __('ログアウト') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                        {{-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dropdown link
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> --}}
                    @endguest
                </ul>
            </div>
        </nav>
        <div id="app">
            <!--ロード画面の記述-->
            <div id="loader-bg">
                <div id="loading" class="text-center">
                    <img src="{{ asset('images/gif/Spinner-3.gif')}}">
                    <p id="loader-text" class="font-size-10"></p>
                </div>
            </div>
            <!--ロード画面の記述ここまで-->

            @yield('content')
        </div>
	</body>
</html>

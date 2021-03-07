<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> --}}

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/add.css') }}" rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/masonry.css') }}" rel="stylesheet">
    <link href="{{ asset('css/odometer-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pushy.css') }}" rel="stylesheet">

    <link href="{{ asset('bootstrap/css/theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,700,100' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Raleway:300,700,900,500' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/typicons/2.0.7/typicons.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/magnific-popup.css') }}" rel="stylesheet">
    <link href="{{ asset('css/masonry.css') }}" rel="stylesheet">
    <link href="{{ asset('css/odometer-theme-default.css') }}" rel="stylesheet">
    <link href="{{ asset('css/pushy.css') }}" rel="stylesheet">
    <script>
    window.odometerOptions = {
      selector: '.odometer',
      format: '(,ddd)', // Change how digit groups are formatted, and how many digits are shown after the decimal point
      duration: 13000, // Change how long the javascript expects the CSS animation to take
      theme: 'default'
    };
    </script>
</head>

<body>
    @yield('content')
    <script src="{{ asset('js/util/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="https://netdna.bootstrapcdn.com/twitter-bootstrap/2.0.4/js/bootstrap-scrollspy.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="{{ asset('js/util/ie10-viewport-bug-workaround.js') }}"></script>
    <script src="http://masonry.desandro.com/masonry.pkgd.js"></script>
    <script src="{{ asset('js/util/masonry.js') }}"></script>
    <script src="{{ asset('js/util/pushy.min.js') }}"></script>
    <script src="{{ asset('js/util/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/util/wow.min.js') }}"></script>
    <script src="{{ asset('js/util/scripts.js') }}"></script>
    <script src="{{ asset('js/util/odometer.js') }}"></script>
</body>
</html>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  
    ga('create', 'UA-34344036-1', 'auto');
    ga('send', 'pageview');
  
</script>
  
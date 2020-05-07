<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IMDB') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>
<body>  
    @include('inc.navbar')
    <div class="container pl-0" style="min-width:1050px;">
        @include('inc.messages')
        <div class="row pl-0 pr-0"  >
            <div class="col pl-0 pr-0">
                
            </div>
            <div class="col-8 pl-0">
                @yield('content')
            </div>
            <div class="col pl-0">
                <img src="https://d2slcw3kip6qmk.cloudfront.net/marketing/press/images/template-gallery/print-banners-executive-business-01.jpg" alt="">
            </div>
        </div>  
    </div>
    @yield('footer')

</body>
</html>
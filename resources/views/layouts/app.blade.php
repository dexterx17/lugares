<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @yield('title','Cuánto conoces tu región?')
    </title>

    <!-- Styles -->
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"/>
    @yield('css')

</head>
<body id="app-layout" base-url="{{ url('/') }}" >
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12 user-stats">
                @include('layouts.user_stats')
            </div>
            <div class="col-md-6 col-xs-12 text-center page-header">
                <h1 class="game-name">
                    <small>@yield('country')</small>
                    <a href="@yield('main_url',url('/'))" title="{{ trans('comun.app_name') }}">{{ trans('comun.app_name') }}</a>
                    <small>{{ trans('comun.slogan') }}</small>    
                </h1>   
            </div>
            <div class="col-md-3 col-xs-12 user-stats text-center">
                @yield('mini_stats')
            </div>
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        </div>

        @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"  crossorigin="anonymous"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script src="{{ asset('js/app.js') }}" type="text/javascript" charset="utf-8"></script>
    @yield('js')
</body>
</html>

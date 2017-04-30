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
<body id="app-layout">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-xs-12 user-stats">
                <div class="well">
                    <h5>
                        <strong>{{ trans('comun.username') }}: </strong> {{ (Auth::guest())? trans('comun.invitado'): Auth::user()->name }} <span class="pull-right label label-info">{{ (Auth::guest())? trans('comun.explorer'): Auth::user()->type }}</span> 
                    </h5>
                    <h5>
                        <strong>{{ trans('comun.nivel') }}: </strong> {{ (Auth::guest())? 0 : Auth::user()->getNivel() }}
                    </h5>
                    <h5>
                        <strong>{{ trans('comun.monedas') }}: </strong>0
                    </h5>
                    <h5>
                        <strong>{{ trans('comun.puntos') }}: </strong> {{ (Auth::guest())? 0 : Auth::user()->getPuntos() }}
                    </h5>
                    <hr />
                    <h5>
                    @if (Auth::guest())
                        <a href="{{ url('/login') }}" class="pull-left">{{ trans('comun.iniciar_sesion') }}</a>
                        <a href="{{ url('/register') }}" class="pull-right">{{ trans('comun.registrate') }}</a>
                        <div class="clearfix"></div>
                    @else
                        <a href="#" class="pull-left">{{ trans('comun.estadisticas') }}</a>
                        <a href="{{ url('/logout') }}" class="pull-right"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
                        <div class="clearfix"></div>
                    @endif
                    </h5>
                </div>
            </div>
            <div class="col-md-6 col-xs-12 text-center page-header">
                <h1 class="game-name">
                    <small>@yield('country')</small>
                    <a href="{{ url('/') }}" title="{{ trans('comun.app_name') }}">{{ trans('comun.app_name') }}</a>
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

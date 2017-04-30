<header>
    <div class="header-logo">
      <div class="limit"><a class="current" href="{{ url('') }}"><img class="img-loaded" src="{{ asset('imagenes/icon.png') }}" alt="{{ trans('comun.app_name') }}"></a></div>
    </div>
    <div class="header-nav">
        <nav class="mobile">
            <ul>
                <li class="current-menu-item"><a href="#"><img class="img-loaded" src="{{ asset('imagenes/es.png') }}" alt="{{ trans('comun.espanol') }}"></a>
                <ul>
                <li class="current-menu-item"><a href="{{ url('') }}" class="active current"><img class="img-loaded" src="{{ asset('imagenes/es.png') }}" alt="{{ trans('comun.espanol') }}"> {{ trans('comun.espanol') }}</a></li>
                <li><a href="{{ url('') }}" class=""><img class="img-loaded" src="{{ asset('imagenes/en.png') }}" alt="{{ trans('comun.ingles' )}}"> {{ trans('comun.ingles' )}}</a></li>
                </ul>
            </ul>
        </nav>
        <nav class="header-nav-primary">
            <!--googleoff: all-->
            <div class="nav-inner">
                <ul>
                    <li class="menu-item menu-item-type-post_type_archive menu-item-object-events"><a href="{{ url('/categorias') }}">{{ trans('comun.categorias') }}</a></li>
                    <li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="{{ url('/paises') }}">{{ trans('comun.paises') }}</a></li>
                </ul>
                     <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">{{ trans('comun.iniciar_sesion') }}</a></li>
                        <li><a href="{{ url('/register') }}">{{ trans('comun.registrate') }}</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
            <!--googleon: all-->
        </nav><!--/header-nav-primary-->
    </div><!--/nav-header-->

    <div class="header-button-planificador">
        <a href="{ route('front.planificador')}}">
            <span class="header-num-likes">0</span>
            <img class="img-loaded" src="{{ asset('imagenes/icon-planificador.png') }}" alt="{{ trans('comun.app_name') }}">
        </a>
    </div>

    <div class="header-button-search">
        <span class="fa fa-search"></span>
        <span class="text">{{ trans('comun.buscar') }}</span>
    </div>

    <div class="header-search">
      <form action="{{ url('') }}" method="GET">
        <div class="fa fa-search"></div>
        <input name="s" placeholder="{{ trans('comun.buscar_en') }} {{ trans('comun.app_name') }} ..." type="text">
      </form>
    </div>

    <div class="header-hamburger">
        <span class="fa fa-bars"></span>
        <span class="fa fa-times"></span>
    </div>
</header>
<div class="well">
    <h5>
        <strong>{{ trans('comun.username') }}: </strong> {{ (Auth::guest())? trans('comun.invitado'): Auth::user()->name }} <span class="pull-right label label-info">{{ (Auth::guest())? trans('comun.explorer'): Auth::user()->type }}</span> 
    </h5>
    <h5>
        <strong>{{ trans('comun.nivel') }}: </strong> {{ (Auth::guest())? 0 : Auth::user()->getNivel() }}
    </h5>
    <h5>
        <strong>{{ trans('comun.puntos') }}: </strong> <span id="user_points">{{ (Auth::guest())? 0 : Auth::user()->getPuntos() }}</span>
    </h5>
    <h5>
        <strong>{{ trans('comun.monedas') }}: </strong>0
    </h5>
    <hr />
    <h5>
    @if (Auth::guest())
        <a href="{{ url('/login') }}" class="pull-left">{{ trans('comun.iniciar_sesion') }}</a>
        <a href="{{ url('/register') }}" class="pull-right">{{ trans('comun.registrate') }}</a>
        <div class="clearfix"></div>
    @else
        <a href="{{ route('stats') }}" class="pull-left">{{ trans('comun.estadisticas') }}</a>
        <a href="{{ url('/logout') }}" class="pull-right"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
        <div class="clearfix"></div>
    @endif
    </h5>
</div>
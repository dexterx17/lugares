@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('comun.bienvenido') }}</div>
                <div class="panel-body">
                   <h4 id="objetivo_corto">{{ trans('comun.objetivo_corto') }}</h4>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="{{ url('/login') }}">{{ trans('comun.iniciar_sesion') }}</a>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">
                    <a href="{{ url('/register') }}">{{ trans('comun.registrate') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

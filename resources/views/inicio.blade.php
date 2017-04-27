@extends('layouts.app')

@section('content')
<div class="container">
    <div id="fb-root"></div>
    <div class="row">
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('comun.bienvenido') }}</div>

                <div class="panel-body">
                    <form  accept-charset="utf-8">
                        <div class="form-group">
                            <label for="provincia">{{ trans('comun.selecciona_provincia') }}</label>
                            {!! Form::select('provincia',$provincias,'',['id'=>"select_provincia",'required'=>'required','class'=>'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <label for="categoria">{{ trans('comun.selecciona_categoria') }}</label>
                            {!! Form::select('categoria',$categorias,'',['id'=>"select_categoria",'required'=>'required','class'=>'form-control']) !!}
                        </div>
                        <a id="btnIniciar" base-url="{{ route('game') }}" href="{{ route('game.provincia',['categoria'=>'bank','provincia'=>20]) }}" type="button" class="btn btn-primary btn-lg btn-block">{{ trans('comun.iniciar') }}</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('comun.bienvenido') }}</div>
                <div class="panel-body">
                    <h4>{{ trans('comun.objetivo_medio') }}</h4>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12" id="provincia_categoria_seleccionada">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

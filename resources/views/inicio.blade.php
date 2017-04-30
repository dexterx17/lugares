@extends('layouts.app')

@section('country',$pais->pais)
@section('mini_stats')
    @include('layouts.mini_stats',['total_lugares'=>$items,'total_categorias'=>$total_categorias])
@endsection
@section('content')
<div class="container">
    <div id="fb-root"></div>
        <div class="page-nav">
            <div class="page-nav-fixed">
                <div class="limit">
                    <nav class="page-nav-breadcrubms">
                        <div class="page-nav-breadcrumbs-text">{{ trans('comun.estas_en') }}</div>
                        <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                            <li class="current-menu-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                <a itemprop="item" href="#">
                                    <span itemprop="name"> {{ $pais->pais }}</span><span class="fa fa-chevron-down"></span>
                                </a>
                                <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                                    @foreach($paises as $p)
                                        @if($pais->id!=$p->id)
                                            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                                <a itemprop="item" href="{{route('game',$p->id_0)}}">
                                                    <span itemprop="name"> {{ $p->pais }}</span>
                                                </a>
                                            </li>
                                        @endif 
                                    @endforeach
                                </ul>
                                <meta itemprop="position" content="1">
                            </li>
                        </ul>
                        <meta itemprop="position" content="2">
                    </nav>
                    <nav class="page-nav-subpages" data-icons="false,map-marker,calendar,star,image">
                        <ul>
                            <li><a class="current" href="#"><span id="n_lugares_total" class="badge">{{ $items }}</span> {{ trans('comun.lugares_total') }}</a></li>
                        </ul>
                    </nav>
                </div><!--/limit-->
            </div><!--/page-nav-fixed-->
        </div><!--/page-nav-->
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

@extends('layouts.app')

@section('country',$provincia->pais->pais)

@section('title',$provincia->provincia.' - '.$categoria->nombre)

@section('mini_stats')
    @include('layouts.mini_stats',['total_lugares'=>$items,'total_categorias'=>$total_categorias])
@endsection

@section('content')
<div class="container">
    <div id="fb-root"></div>

    <div class="panel panel-default">
        <div class="panel-heading panel-explorar-heading">
            <div class="page-nav">
                <div class="page-nav-fixed">
                    <div class="limit">
                        <nav class="page-nav-breadcrubms">
                            <div class="page-nav-breadcrumbs-text">{{ trans('comun.estas_en') }}</div>
                            <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                                <li class="current-menu-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                    <a itemprop="item" href="#">
                                        <span itemprop="name"> {{ $provincia->provincia }}</span><span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                                        @foreach($provincias as $prov)
                                            @if($provincia->id!=$prov->id)
                                                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                                    <a itemprop="item" href="{{route('game.provincia',[ 'pais' => $prov->id_0, 'provincia'=>$prov->id_1,'categoria'=>$categoria->categoria])}}">
                                                        <span itemprop="name"> {{ $prov->provincia }}</span>
                                                    </a>
                                                </li>
                                            @endif 
                                        @endforeach
                                    </ul>
                                    <meta itemprop="position" content="1">
                                </li>
                                <li class="current-menu-item" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                    <a itemprop="item" href="#">
                                        <span itemprop="name"> {{ $categoria->nombre }}</span><span class="fa fa-chevron-down"></span>
                                    </a>
                                    <ul itemscope="" itemtype="http://schema.org/BreadcrumbList">
                                        @foreach($categorias as $cat)
                                            @if($categoria->categoria!=$cat->categoria)
                                                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                                                    <a itemprop="item" href="{{route('game.provincia',['categoria'=>$cat->categoria,'pais'=>$provincia->id_0, 'provincia'=>$provincia->id_1])}}">
                                                        <span itemprop="name"> {{ $cat->nombre }}</span>
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
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-md-6 col-lg-8">
                    <div id="mapa"></div>   
                </div>
                <div class="col-md-6 col-lg-4">
                    <div id="tabs">
                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#lugares" aria-controls="lugares" role="tab" data-toggle="tab">{{ trans('comun.por_visitar') }} <span id="n_lugares" class="badge">0</span></a></li>
                        <li role="presentation"><a href="#detail" aria-controls="detail" role="tab" data-toggle="tab">Detalles</a></li>
                        <li role="presentation"><a href="#explorados" aria-controls="explorados" role="tab" data-toggle="tab">{{ trans('comun.visitados') }} <span id="n_lugares_explorados" class="badge">0</span> </a></li>
                       </ul>

                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active contenedor-lugares" id="lugares" base-url="{{ route('loader') }}" token="{{ Session::token() }}">
                            <div class="help">
                                {{ trans('comun.desplazate_en_mapa') }}
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="detail">
                            Selecciona un <button  id="btn_lugares" title="Lugar">lugar</button>
                        </div>
                        <div role="tabpanel" class="tab-pane contenedor-lugares" id="explorados">
                            <div class="ocultar-visitados">
                                {{ trans('comun.ocultar_visitados',['accion'=>'ocultar']) }}
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="templates">
                            <div class="template-lugar " id="">
                                <div class="media-left">
                                    <a href="#" class="">
                                        <img alt="name" class="media-object" width="50" height="50" src=""/>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="" title="name">name</a>
                                    </h4>
                                        <span class="vicinity">dir</span>
                                </div>
                            </div>
                            <div class="panel panel-default template-lugar-info">
                                <div class="panel-heading">
                                    <h3>
                                        Titi Park
                                        <button type="button" base-url="{{ url('visited') }}" place="" class="visitado pull-right btn btn-info">Visitado</button>
                                    </h3>
                                </div>
                                <div class="panel-body">
                                <img class="img-responsive" src="#">
                                    <ul class="list-group">
                                        <li class="list-group-item direction"><i class="glyphicon glyphicon-home"></i> {{ trans('comun.no_direction') }}</li>
                                        <li class="list-group-item international-phone"><i class="glyphicon glyphicon-earphone"></i> {{ trans('comun.no_number') }}</li>
                                        <li class="list-group-item phone"><i class="glyphicon glyphicon-earphone"></i> {{ trans('comun.no_number') }} </li>
                                        <li class="list-group-item website"><i class="glyphicon glyphicon-globe"></i> <a href="#">website</a></li>
                                        <li class="list-group-item">{{ trans('comun.categorias') }}: 
                                            <ul class="categorias">
                                            </ul>
                                        </li>
                                    </ul
                                    ><hr>
                                </div>
                            </div>
                        </div>
                      </div>

                    </div>

                </div>
            </div>
        </div>
        <div class="panel-footer">
            <div class="">
                <span id="n_peticiones">0</span>
                <span id="n_peticiones_responses">0</span>
                |||
                <span id="id_categoria">{{ $categoria->categoria }}</span>
                <span class="zoom">{{ $provincia->zoom }}</span>
                |||
                <span class="lat">{{ $provincia->lat }}</span>,
                <span class="lng">{{ $provincia->lng }}</span>
                |||
                <span class="bounds">
                        {{ $provincia->minx }},{{ $provincia->miny }} - {{ $provincia->maxx }},{{ $provincia->maxy }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ920_mAj7Lcw2Mc6JOqrxbJEKHQS0BRE&libraries=places&callback=initMap">
    </script>
@endsection
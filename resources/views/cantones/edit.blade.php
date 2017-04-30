@extends('layouts.app')

@section('title',trans('comun.editar').' '.$provincia->provincia)

@section('css')
<style type="text/css" media="screen">
        #mapa{
            width: 100%;
            height: 300px;
        }
</style>
@endsection

@section('content')
<div class="container body">
    <div class="main_container">
        <div class="right_col" role="main">
         
            <div class="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2> {{trans('comun.editar') }} {{ $provincia->provincia}} </h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="" id="tabs" data-example-id="togglable-tabs" role="tabpanel">
                                    <!-- required for floating -->
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a data-toggle="tab" href="#infor">
                                               {{ trans('comun.informacion') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#ubicacion">
                                               {{ trans('comun.ubicacion') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a data-toggle="tab" href="#traducciones">
                                                {{ trans('comun.traducciones') }}
                                            </a>
                                        </li>
                                    </ul>
                                
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="infor">
                                            <form class="form-horizontal form-label-left" action="{{route('provincias.update',$provincia->id)}}" method="POST">
                                            {{ csrf_field() }}
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                                                        {{ trans('comun.nombre') }}
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" value="{{$provincia->provincia}}" id="name" name="name" placeholder="{{ trans('comun.nombre') }}" required="required" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="short_name">
                                                        {{ trans('comun.short_name') }}
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" value="{{$provincia->short_name}}" id="short_name" name="short_name" readonly="readonly" disabled="disabled">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion">
                                                        {{ trans('comun.descripcion') }}
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea class="form-control col-md-7 col-xs-12"  id="descripcion" name="descripcion" required="required">{{ $provincia->descripcion }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="ln_solid">
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <a  href="{{ route('provincias.index',$provincia->id_0) }}"class="btn btn-primary" >
                                                            {{ trans('comun.cancelar') }}
                                                        </a>
                                                        <button class="btn btn-success" id="send" type="submit">
                                                            {{ trans('comun.guardar') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="ubicacion">
                                            <p class="alert alert-success">{{ trans('comun.establece_zoom') }} <strong>{{ $provincia->provincia }}</strong> </p>
                                            <form class="form-horizontal form-label-left" action="{{route('provincias.update',$provincia->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="latitud">
                                                        {{ trans('comun.latitud') }}
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" value="{{$provincia->lat}}" id="latitud" name="lat" placeholder="{{ trans('comun.latitud') }}" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-6" for="longitud">
                                                        {{ trans('comun.longitud') }}
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" value="{{$provincia->lng}}" id="longitud" name="lng" placeholder="{{ trans('comun.longitud') }}" type="text">
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="zoom">
                                                        {{ trans('comun.zoom') }}
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        {!! Form::select('zoom',$zoom_list,$provincia->zoom,['id'=>'zoom','class'=>'form-control col-md-7 col-xs-12']) !!}
                                                        </input>
                                                    </div>
                                                </div>
                                                <div class="ln_solid">
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <a  href="{{ route('provincias.index',$provincia->id_0) }}"class="btn btn-primary" >
                                                            {{ trans('comun.cancelar') }}
                                                        </a>
                                                        <button class="btn btn-success" id="send" type="submit">
                                                            {{ trans('comun.guardar') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="tab-pane" id="traducciones">
                                            <form class="form-horizontal form-label-left" action="{{route('provincias.update',$provincia->id)}}" method="POST">
                                                {{ csrf_field() }}
                                                <div class="row">
                                                    <span class="section">
                                                        {{ trans('menu.espanol') }}
                                                    </span>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion_es">
                                                            {{ trans('comun.descripcion') }}
                                                            <span class="required">
                                                                *
                                                            </span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea class="form-control col-md-7 col-xs-12"  id="descripcion_es" name="descripcion_es" required="required">{{ $provincia->descripcion }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slogan_es">
                                                            {{ trans('comun.slogan') }}
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea class="form-control col-md-7 col-xs-12"  id="slogan_es" name="slogan_es" required="required">{{ $provincia->slogan }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <span class="section">
                                                        {{ trans('menu.ingles') }}
                                                    </span>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion_en">
                                                            {{ trans('comun.descripcion') }}
                                                            <span class="required">
                                                                *
                                                            </span>
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea class="form-control col-md-7 col-xs-12"  id="descripcion_en" name="descripcion_en" required="required">{{ $provincia->descripcion }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="item form-group">
                                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="slogan_en">
                                                            {{ trans('comun.slogan') }}
                                                        </label>
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                                            <textarea class="form-control col-md-7 col-xs-12"  id="slogan_en" name="slogan_en" required="required">{{ $provincia->slogan }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="ln_solid">
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-md-6 col-md-offset-3">
                                                        <a  href="{{ route('provincias.index',$provincia->id_0) }}"class="btn btn-primary" >
                                                            {{ trans('comun.cancelar') }}
                                                        </a>
                                                        <button class="btn btn-success" id="send" type="submit">
                                                            {{ trans('comun.guardar') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix">
                                </div>
                            </div>
                        </div><!--/x_panel-->
                        <div class="x_panel">
                            <div id="mapa"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
     <script tpye="text/javasript">
        var map;
        var marker = null;

        function initMap() {
            function onDragMarker(e) {
                $('#tabs a[href="#ubicacion"]').tab('show');
                $('#latitud').val(e.latLng.lat);
                $('#longitud').val(e.latLng.lng);
            }

            function placeMarker(location) {
                if(this.marker==null){
                    marker = new google.maps.Marker({
                        position: location, 
                        map: map,
                        draggable: true,
                    });
                    $('#latitud').val(location.lat);
                    $('#longitud').val(location.lng);
                    google.maps.event.addListener(marker,'dragend',onDragMarker);
                }
            }
               
            if(('{{ $provincia->lat }}' != '')  && ('{{ $provincia->lng }}' != '') && ('{{ $provincia->zoom }}' != '') ) {
                map = new google.maps.Map(document.getElementById('mapa'), {
                    center: {lat: parseFloat('{{ $provincia->lat }}'), lng: parseFloat('{{ $provincia->lng }}')},
                    zoom: parseInt('{{ $provincia->zoom }}')
                });
                marker = new google.maps.Marker({
                    position: {lat: parseFloat('{{ $provincia->lat }}'), lng: parseFloat('{{ $provincia->lng }}')},
                    map: map,
                    draggable: true,
                });
                google.maps.event.addListener(marker,'dragend',onDragMarker);
            }else{
                map = new google.maps.Map(document.getElementById('mapa'), {
                    center: {lat: -2.2749909608065475 , lng: -78.21441650390625},
                    zoom: 6
                });
            }

            google.maps.event.addListener(map, 'click', function(event) {
                   placeMarker(event.latLng);
            });

            map.addListener('zoom_changed', function() {
                $('#tabs a[href="#ubicacion"]').tab('show');
                $('#zoom').val(map.getZoom()+1);
            });

        }

    </script>
    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDJ920_mAj7Lcw2Mc6JOqrxbJEKHQS0BRE&callback=initMap">
    </script>
@endsection
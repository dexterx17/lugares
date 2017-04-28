@extends('layouts.app')

@section('title',trans('comun.editar').' '.$categoria->nombre)
@section('content')
<div class="container body">
    <div class="main_container">
<div class="right_col" role="main">
 
    <div class="">
        <div class="row">
            <div class="col-md-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>{{trans('comun.editar') }} {{ $categoria->nombre}}</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <!-- content starts here -->
                        <div class="" data-example-id="togglable-tabs" role="tabpanel">
                                <!-- required for floating -->
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#infor">
                                           {{ trans('comun.informacion') }}
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
                                        <form class="form-horizontal form-label-left" action="{{route('categorias.update',$categoria->categoria)}}" method="POST">
                                        {{ csrf_field() }}
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre">
                                                    {{ trans('comun.categoria') }}
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" value="{{$categoria->nombre}}" id="nombre" name="nombre" placeholder="{{ trans('comun.nombre') }}" required="required" type="text">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="categoria">
                                                    {{ trans('comun.slug') }}
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" value="{{$categoria->categoria}}" id="categoria" name="categoria" readonly="readonly" disabled="disabled">
                                                    </input>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="orden">
                                                    {{ trans('comun.orden') }}
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <input class="form-control col-md-7 col-xs-12" value="{{$categoria->orden}}" id="orden" name="orden" required="required" type="number">
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
                                                    <textarea class="form-control col-md-7 col-xs-12"  id="descripcion" name="descripcion" required="required">{{ $categoria->descripcion }}</textarea>
                                                </div>
                                            </div>
                                            <div class="item form-group">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="objetivo">
                                                    {{ trans('comun.objetivo') }}
                                                    <span class="required">
                                                        *
                                                    </span>
                                                </label>
                                                <div class="col-md-6 col-sm-6 col-xs-12">
                                                    <textarea class="form-control col-md-7 col-xs-12"  id="objetivo" name="objetivo" required="required">{{ $categoria->objetivo }}</textarea>
                                                </div>
                                            </div>
                                            <div class="ln_solid">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <a  href="{{ route('categorias.index') }}"class="btn btn-primary" >
                                                        {{ trans('comun.cancelar') }}
                                                    </a>
                                                    <button class="btn btn-success" id="send" type="submit">
                                                        {{ trans('comun.guardar') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!--/tab-->
                                    <div class="tab-pane" id="traducciones">
                                        <form class="form-horizontal form-label-left" action="{{route('categorias.update',$categoria->categoria)}}" method="POST">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <span class="section">
                                                    {{ trans('comun.espanol') }}
                                                </span>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre_es">
                                                        {{ trans('comun.categoria') }}
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" value="{{ $categoria->nombre }}" id="nombre_es" name="nombre_es" placeholder="{{ trans('comun.categoria') }}" required="required" type="text">
                                                    </input>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion_es">
                                                        {{ trans('comun.descripcion') }}
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea class="form-control col-md-7 col-xs-12"  id="descripcion_es" name="descripcion_es" required="required">{{ $categoria->descripcion }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <span class="section">
                                                    {{ trans('comun.ingles') }}
                                                </span>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nombre_en">
                                                        {{ trans('comun.categoria') }}
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <input class="form-control col-md-7 col-xs-12" value="{{ $categoria->nombre }}" id="nombre_en" name="nombre_en" placeholder="{{ trans('comun.categoria') }}" required="required" type="text">
                                                    </input>
                                                    </div>
                                                </div>
                                                <div class="item form-group">
                                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descripcion_en">
                                                        {{ trans('comun.descripcion') }}
                                                        <span class="required">
                                                            *
                                                        </span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                                        <textarea class="form-control col-md-7 col-xs-12"  id="descripcion_en" name="descripcion_en" required="required">{{ $categoria->descripcion }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ln_solid">
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-6 col-md-offset-3">
                                                    <a  href="{{ route('categorias.index') }}"class="btn btn-primary" >
                                                        {{ trans('comun.cancelar') }}
                                                    </a>
                                                    <button class="btn btn-success" id="send" type="submit">
                                                        {{ trans('comun.guardar') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div><!--/tab-->
                                </div><!--/tab-content-->
                            </div>
                        <!-- content ends here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
    <script type="text/javascript" charset="utf-8" >
        $(document).ready(function(){
            $('.dropzone').dropzone({
                'maxFilesize':1,
                'maxFiles':3,
                'acceptedFiles':'image/*',
                'paramName':'imagen',
                sending:function(file, xhr, formData){
                    formData.append("_token", '{{ Session::token() }}');
                    formData.append("referencia", 'categorias');
                }
            });
        });
    </script>
@endsection
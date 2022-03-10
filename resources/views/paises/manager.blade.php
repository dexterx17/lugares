@extends('layouts.app')

@section('title',trans('comun.paises').' admin')

@section('content')
<div class="container body">
    <div class="main_container">
        <div class="right_col" role="main">
            <div class="">
                <div class="clearfix">
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>
                                    {{ trans('comun.paises') }}
                                    <small>
                                        {{ trans('comun.listado') }}
                                    </small>
                                </h2>
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="x_content">
                                <!-- content starts here -->
                                <!-- start paises list -->
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                {{ trans('comun.pais') }}
                                            </th>
                                            <th>
                                                {{ trans('comun.lugares') }}
                                            </th>
                                            <th>
                                                {{ trans('comun.zoom') }}
                                            </th>
                                            <th class="text-right">
                                                {{ trans('comun.acciones') }}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paises_data as $index=>$pais)
                                        <tr id="{{$pais->id}}" data-categoria="{{$pais->id}}">
                                            <td>
                                                {{ ($pais->id_0) }}
                                            </td>
                                            <td>
                                                <a>
                                                    {{ $pais->pais }}
                                                </a>
                                                <span class="pull-right">
                                                    <a href="{{ route('provincias.index',$pais->id_0) }}" title="Provincias">Provincias</a>
                                                </span>
                                            </td>
                                            <td>
                                                {{-- {{ $pais->lugares()->count() }} --}}
                                            </td>
                                            <td>
                                                {{ $pais->zoom }}
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-info btn-xs" href="{{ route('paises.edit',$pais->id)}}">
                                                    <i class="fa fa-pencil">
                                                    </i>
                                                    {{ trans('comun.editar') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- end paises list -->
                                <!-- content ends here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/right-col-->
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
    });
</script>
@endsection
    
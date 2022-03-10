@extends('layouts.app')

@section('title',trans('comun.cantones').' '.$provincia->provincia.' admin')

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
                                    {{ trans('comun.cantones') }}
                                    {{ $provincia->provincia }}
                                    <small>
                                        {{ trans('comun.listado') }}
                                    </small>
                                </h2>
                                <div class="clearfix">
                                </div>
                            </div>
                            <div class="x_content">
                                <!-- content starts here -->
                                <!-- start cantones list -->
                                <table class="table table-responsive table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                #
                                            </th>
                                            <th>
                                                {{ trans('comun.canton') }}
                                            </th>
                                            <th>
                                                {{ trans('comun.lugares') }}
                                                <span class="badge">
                                                    {{-- {{ $provincia->lugares()->count()}} --}}
                                                </span>
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
                                        @foreach($cantones_data as $index=>$canton)
                                        <tr id="{{$canton->id}}" data-categoria="{{$canton->id}}">
                                            <td>
                                                {{ ($canton->id_1) }}
                                            </td>
                                            <td>
                                                <a>
                                                    {{ $canton->canton }}
                                                </a>
                                                <span class="pull-right">
                                                    <a href="#" title="Cantones">Cantones</a>
                                                </span>
                                            </td>
                                            <td>
                                                {{-- {{ $canton->lugares()->count() }} --}}
                                            </td>
                                            <td>
                                                {{ $canton->zoom }}
                                            </td>
                                            <td class="text-right">
                                                <a class="btn btn-info btn-xs" href="{{ route('cantones.edit',$canton->id)}}">
                                                    <i class="fa fa-pencil">
                                                    </i>
                                                    {{ trans('comun.editar') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- end cantones list -->
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
    
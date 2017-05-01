@extends('layouts.app')

@section('country',$pais->pais)
@section('mini_stats')
    @include('layouts.mini_stats',['total_lugares'=>$items,'total_categorias'=>$total_categorias, 'total_visitados'=>$items_user])
@endsection
@section('content')
<div class="container">
    <div id="fb-root"></div>
    @include('layouts.nav_paises')
    <div class="row">
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('comun.leaderboard') }}</div>
                <div class="panel-body">
                <table class="table table-responsive table-hover ">
                    <thead>
                        <tr>
                            <th>{{ trans('comun.username') }}</th>
                            <th>{{ trans('comun.puntos') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name}}</td>
                            <td>{{ $user->puntos }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>
        </div>
        <div class="col-md-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('comun.categorias').' '.strtolower(trans('comun.populares')) }}</div>
                <div class="panel-body">
                    <table class="table table-responsive table-hover">
                        <thead>
                            <tr>
                                <th>{{ trans('comun.categoria') }}</th>
                                <th>{{ trans('comun.lugares') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categorias as $categoria )
                            <tr>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->puntos }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

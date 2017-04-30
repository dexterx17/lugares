 <h5>{{ $total_lugares }} {{ trans('comun.lugares').' '.strtolower(trans('comun.para_visitar'))  }}</h5>
<div class="progress">
    <div class="progress-bar progress-bar-success" style="width: 100%;">
        0 {{ trans('comun.visitados') }}
    </div>
</div>
<h5>{{ $total_categorias }} {{ trans('comun.categorias').' '.strtolower(trans('comun.para_completar'))  }}</h5>
<div class="progress">
    <div class="progress-bar" style="width: 100%;">
        0 {{ trans('comun.completadas') }}
    </div>
</div>
<h5>{{ trans('comun.trivias') }} <small>{{ trans('comun.proximamente') }}</small></h5>
<div class="progress">
    <div class="progress-bar progress-bar-info" style="width: 100%;">
        0
    </div>
</div>
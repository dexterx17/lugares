 <h5><span id="n_lugares_total">{{ $total_lugares }}</span> {{ trans('comun.lugares').' '.strtolower(trans('comun.para_visitar'))  }}</h5>
<div class="progress">
    <div class="progress-bar progress-bar-success bar-lugares" style="width: {{ ($total_lugares!=0)? ($total_visitados/$total_lugares)*100 : 0 }}%;">
        <span id="n_total_visitados">{{ $total_visitados }}</span> {{ trans('comun.visitados') }}
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
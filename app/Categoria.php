<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
     protected $primaryKey = 'categoria'; // or null

    public $incrementing = false;

    protected $table = 'categorias';

    protected $fillable = [
        'categoria', 'descripcion', 'icono','icono_url','nombre','orden','objetivo','activa'
    ];


    /**
     * Una lugar puede tener varias actividades
     * @return [App\Lugar]   Array de objetos tipo Lugar
     */
    public function lugares(){
        return $this->belongsToMany('App\Lugar');
    }

    public function scopeOrderByLugares($query){
        return $query->select('categoria','nombre',\DB::raw('COUNT(lugar_id) as puntos'))
            ->orderBy('puntos','DESC')
            ->join('categoria_lugar',function($join){
                $join->on('categorias.categoria','=', 'categoria_lugar.categoria_id');
            })->groupBy('categoria');
    }
}

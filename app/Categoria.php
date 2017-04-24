<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
     protected $primaryKey = 'categoria'; // or null

    public $incrementing = false;

    protected $table = 'categorias';

    protected $fillable = [
        'categoria', 'descripcion', 'icono','icono_url'
    ];


    /**
     * Una lugar puede tener varias actividades
     * @return [App\Lugar]   Array de objetos tipo Lugar
     */
    public function lugares(){
        return $this->belongsToMany('App\Lugar');
    }
}

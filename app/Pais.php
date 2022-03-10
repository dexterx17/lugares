<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Lugar;

class Pais extends Model
{
    // protected $connection = 'pgsql';
    protected $table ="paises";

    protected $fillable = [
        'gid0',
        'pais',
        'slug',
        'codigo',
        'orden',
        'estado',
        'minx',
        'miny',
        'maxx',
        'maxy',
        'lat',
        'lng',
        'zoom',
        'pitch',
        'bearing',

        'short_name',
        'continente',
        'descripcion',
        'bandera_url',
        'escudo_url',
        'zipcode',

        'n_items',

    ];

    public $timestamps = false;

    public function provincias(){
    	return $this->hasMany('App\Provincia');
    }

    public function scopeLugares(){
        return Lugar::where('id_0',$this->id_0);
    }
}

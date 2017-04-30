<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Lugar;

class Pais extends Model
{
    protected $connection = 'pgsql';
    
    protected $table ="paises";

    protected $fillable = [
        'pais','short_name','continente','descripcion',
        'bandera_url','escudo_url','zipcode','lat','lng',
        'zoom','n_items', 'minx', 'miny', 'maxx', 'maxy'
    ];

    public $timestamps = false;

    public function provincias(){
    	return $this->hasMany('App\Provincia');
    }

    public function scopeLugares(){
        return Lugar::where('id_0',$this->id_0);
    }
}

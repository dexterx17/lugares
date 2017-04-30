<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Pais;
use App\Provincia;
use App\Parroquia;

class Canton extends Model
{
    protected $connection = 'pgsql';
    
    protected $table = "cantones";

    protected $fillable = [
    	'canton', 'descripcion', 'bandera_url', 'escudo_url',
    	'zipcode', 'lat', 'lng', 'zoom', 'n_items', 'minx', 'miny',
    	'maxx','maxy','id_1','id_0','id_2'
    ];

    public $timestamps = false;

    public function ScopeByProvincia($query,$pais_id,$provincia_id){
        return $query->select('id', 'canton', 'descripcion', 'bandera_url', 'escudo_url',
        'zipcode', 'lat', 'lng', 'zoom', 'n_items', 'minx', 'miny','maxx','maxy','id_1','id_0','id_2')
        ->where('id_0',$pais_id)
        ->where('id_1',$provincia_id);
    }

    public function scopeLugares(){
        return Lugar::where('id_0',$this->id_0)->where('id_1',$this->id_1)->where('id_2',$this->id_2);
    }

    /**
     * Provincia a la que pertenece el canton
     * @return App/Provincia Objeto de tipo Provincia
     */
    public function scopeProvincia(){
        return Provincia::where('id_0',$this->id_0)
                ->where('id_1',$this->id_1)->first();
    }

    /**
     * Pais al que pertenece el canton
     * @return App/Pais Objeto de tipo Canton
     */
    public function scopePais(){
    	return Pais::where('id_0',$this->id_0)->first();
    }

    /**
     * Parroquias del canton
     * @return [type] Coleccion de Objetos tipo Parroquia
     */
    public function scopeParroquias(){
	   return Parroquia::where('id_0',$this->id_0)
            ->where('id_1',$this->id_1)
            ->where('id_2',$this->id_2);
    }

    /**
     * Cantones explorados por un usuario
     * @param  [type] $query   [description]
     * @param  integer $pais_id Clave primaria del pais
     * @param  integer $provincia_id Clave primaria de la provincia
     * @param  integer $user_id Clave primaria del usuario
     * @return [type]          [description]
     */
    public function scopeExploredProvinciaByUser($query,$pais_id,$provincia_id,$user_id){
        return $query->select('id', 'canton', 'descripcion', 'bandera_url', 'escudo_url',
        'zipcode', 'lat', 'lng', 'zoom', 'n_items', 'minx', 'miny','maxx','maxy','id_1','id_0','id_2')
        ->where('id_0',$pais_id)
        ->where('id_1',$provincia_id)
        ->whereIn('id_2',function($squery) use ($user_id) {
            $squery->select('canton_id')
            ->from('locations')
            ->whereIn('item_id',function($squery2) use ($user_id){
                $squery2->select('item_id')
                ->from('items_visitados')
                ->where('user_id',$user_id);
            });
        });
    }
}

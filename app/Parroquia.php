<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Comunidad;
use App\Canton;

class Parroquia extends Model
{
    protected $connection = 'pgsql';
    
    protected $table = "parroquias";

    protected $fillable = [
    	'parroquia', 'descripcion', 'bandera_url', 'escudo_url',
    	'zipcode', 'lat', 'lng', 'zoom', 'n_items', 'minx', 'miny',
    	'maxx','maxy'
    ];

    public $timestamps = false;

    public function ScopeByCanton($query,$pais_id,$provincia_id,$canton_id){
        return $query->select('id', 'parroquia', 'descripcion', 'bandera_url', 'escudo_url',
        'zipcode', 'lat', 'lng', 'zoom', 'n_items', 'minx', 'miny','maxx','maxy','id_1','id_0','id_2','id_3')
        ->where('id_0',$pais_id)
        ->where('id_1',$provincia_id)
        ->where('id_2',$canton_id);
    }

    /**
     * Canton al que pertenece la parroquia
     * @return App/Canton Objeto de tipo Canton
     */
    public function scopeCanton(){
    	return Canton::where('id_0',$this->id_0)
                ->where('id_1',$this->id_1)
                ->where('id_2',$this->id_2)->first();
    }

    /**
     * Comunidades de la parroquia
     * @return App\Comunidad Coleccion de Objetos Tipo Comunidad
     */
    public function scopeComunidades(){
    	 return Comunidad::where('id_0',$this->id_0)
            ->where('id_1',$this->id_1)
            ->where('id_2',$this->id_2)
            ->where('id_3',$this->id_3);
    }

    /**
     * Parroquias exploradas por un usuario
     * @param  [type] $query   [description]
     * @param  integer $pais_id Clave primaria del pais
     * @param  integer $provincia_id Clave primaria de la provincia
     * @param  integer $canton_id Clave primaria del canton
     * @param  integer $user_id Clave primaria del usuario
     * @return [type]          [description]
     */
    public function scopeExploredCantonByUser($query,$pais_id,$provincia_id,$canton_id,$user_id){
        return $query->select('id', 'parroquia', 'descripcion', 'bandera_url', 'escudo_url',
        'zipcode', 'lat', 'lng', 'zoom', 'n_items', 'minx', 'miny','maxx','maxy','id_1','id_0','id_2','id_3')
        ->where('id_0',$pais_id)
        ->where('id_1',$provincia_id)
        ->where('id_2',$canton_id)
        ->whereIn('id_3',function($squery) use ($user_id) {
            $squery->select('parroquia_id')
            ->from('locations')
            ->whereIn('item_id',function($squery2) use ($user_id){
                $squery2->select('item_id')
                ->from('items_visitados')
                ->where('user_id',$user_id);
            });
        });
    }
}

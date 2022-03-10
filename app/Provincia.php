<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Canton;

class Provincia extends Model
{
    // protected $connection = 'pgsql';
    
    protected $table = "provincias";

    protected $fillable = [
        'gid0', //pais
        'gid1', //provincia
        'provincia',
        'slug',
        'tipo',
        'engtype',
        'descripcion',
        'bandera_url',
        'escudo_url',
        'zipcode',
        'minx',
        'miny',
        'maxx',
        'maxy',
        'lat',
        'lng',
        'zoom',
        'estado',
        'pitch',
        'bearing',

  
        'n_items',
        'pais_id',
        'id_0',
        'id_1',
    ];

    public $timestamps = false;

    /**
     * Una provincia pertenece a un Pais
     * @return App\Pais objeto tipo Pais
     */
    public function pais(){
    	return $this->belongsTo('App\Pais');
    }

    public function scopeLugares(){
        return Lugar::where('id_0',$this->id_0)->where('id_1',$this->id_1);
    }

    /**
     * Provincias de un pais
     * @param [type] $query   [description]
     * @param integer $pais_id Clave primaria del pais
     */
    public function ScopeByPais($query,$pais_id){
        return $query->select('id','provincia', 'descripcion',
         'bandera_url', 'escudo_url', 'zipcode', 'lat', 'lng',
         'zoom', 'n_items', 'minx', 'miny','maxx','maxy','pais_id',
         'id_0','id_1')
        ->where('pais_id',$pais_id);
    }

    /**
     * Una provincia tiene varios cantones
     * @return [App/Canton] Coleccion de Objetos tipo Canton
     */
    public function scopeCantones(){
    	return Canton::where('id_0',$this->id_0)
                ->where('id_1',$this->id_1);
    }

    /**
     * Provincias exploradas por un usuario
     * @param  [type] $query   [description]
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    public function scopeExploredPaisByUser($query,$pais_id,$user_id){
        return $query->select('id','provincia', 'descripcion',
         'bandera_url', 'escudo_url', 'zipcode', 'lat', 'lng',
         'zoom', 'n_items', 'minx', 'miny','maxx','maxy','pais_id',
         'id_0','id_1')
        ->where('id_0',$pais_id)
        ->whereIn('id_1',function($squery) use ($user_id) {
            $squery->select('provincia_id')
            ->from('locations')
            ->whereIn('item_id',function($squery2) use ($user_id){
                $squery2->select('item_id')
                ->from('items_visitados')
                ->where('user_id',$user_id);
            });
        });
    }
}

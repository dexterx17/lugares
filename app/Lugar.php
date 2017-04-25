<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';

    protected $fillable = [
        'name', 'direccion', 'telefono','web','google_id','lat','lng','loaded'
    ];

    /**
     * Un lugar pertenece a varias categorias
     * @return [App\Actividad] Coleccion de objetos de tipo Actividad
     */
    public function categorias()
    {
    	return $this->belongsToMany('App\Categoria');
    }

    /**
     * Un lugar pertenece a un usuario
     * @return App\User Objeto de tipo User
     */
    public function user()
    {
        return $this->belongsToMany('App\User');
    }

    public function scopeVisited($query,$user_id){
        $lugar_id = $this->id;
        return $query->whereIn('id',function($sq) use ($user_id,$lugar_id){
            $sq->select('lugar_id');
            $sq->from('lugar_user');
            $sq->where('user_id',$user_id);
            $sq->where('lugar_id',$lugar_id);
        });
    }
}

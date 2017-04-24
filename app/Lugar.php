<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';

    protected $fillable = [
        'name', 'direccion', 'telefono','web','google_id','lat','lng'
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
        return $this->belongsTo('App\User');
    }

}

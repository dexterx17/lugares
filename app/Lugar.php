<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model
{
    protected $table = 'lugares';

    protected $fillable = [
       'google_id','lat','lng','loaded'
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

    public function scopeIsVisited($query,$user_id){
        $lugar_id = $this->id;
        return $query->whereIn('id',function($sq) use ($user_id,$lugar_id){
            $sq->select('lugar_id')
            ->from('lugar_user')
            ->where('user_id',$user_id)
            ->where('lugar_id',$lugar_id);
        });
    }

    public function scopeIsVisitedByCategoriaProvincia($query,$user_id,$categoria_id,$provincia_id){
        //dd($user_id,$categoria_id,$provincia_id);
        return $query->where('id_1',$provincia_id)
            ->whereIn('id',function($sq) use ($user_id){
                $sq->select('lugar_id');
                $sq->from('lugar_user');
                $sq->where('user_id',$user_id);
               // $sq->where('lugar_id',$lugar_id);
            })
            ->whereIn('id',function($sq) use ($categoria_id){
                $sq->select('lugar_id');
                $sq->from('categoria_lugar');
                $sq->where('categoria_id',$categoria_id);
             //   $sq->where('lugar_id',$lugar_id);
            });
    }

    public function scopeByCategoria($query, $categoria){
        return $query->whereIn('id',function($q) use ($categoria) {
            $q->select('lugar_id');
            $q->from('categoria_lugar');
            $q->where('categoria_id',$categoria);
        });
    }
}

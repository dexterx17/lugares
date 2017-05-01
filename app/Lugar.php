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

    public function scopeVisitedByPais($query,$user_id,$pais_id){
        return $query->where('id_0',$pais_id)
            ->whereIn('id',function($sq) use ($user_id){
                $sq->select('lugar_id');
                $sq->from('lugar_user');
                $sq->where('user_id',$user_id);
            });
    }

    public function scopeByCategoria($query, $categoria){
        return $query->whereIn('id',function($q) use ($categoria) {
            $q->select('lugar_id');
            $q->from('categoria_lugar');
            $q->where('categoria_id',$categoria);
        });
    }

    public function scopeByPais($query, $pais){
        return $query->where('id_0',$pais);
    }

    public function scopeByCategoriaProvincia($query, $categoria, $provincia){
        return $query->where('id_0',$provincia->id_0)
            ->where('id_1',$provincia->id_1)
            ->whereIn('id',function($q) use ($categoria) {
            $q->select('lugar_id');
            $q->from('categoria_lugar');
            $q->where('categoria_id',$categoria);
        });
    }

    public function scopeVisitedByCategoriaProvincia($query,$user_id,$categoria_id,$provincia){
       // dd($this->id,$user_id,$categoria_id,$provincia->id_0,$provincia->id_1);
        return $query->where('id_0',$provincia->id_0)
            ->where('id_1',$provincia->id_1)
            ->whereIn('id',function($sq) use ($user_id){
                $sq->select('lugar_id');
                $sq->from('lugar_user');
                $sq->where('user_id',$user_id);
            })
            ->whereIn('id',function($sq) use ($categoria_id){
                $sq->select('lugar_id');
                $sq->from('categoria_lugar');
                $sq->where('categoria_id',$categoria_id);
            });
    }
}

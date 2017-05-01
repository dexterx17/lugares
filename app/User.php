<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','pais','facebook_id','google_id','provider', 'provider_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Un usuario puede tener varios lugares
     * @return App\Lugar Objeto de tipo Lugar
     */
    public function lugares(){
        return $this->belongsToMany('App\Lugar');
    }

    public function getPuntos(){
        $items = \DB::table('lugar_user')
                ->where('user_id',$this->id)->count();

        return $items*10;
    }

    public function getNivel(){
        return 1;
    }

    public function scopeOrderByPoints($query){
        return $query->select('name',\DB::raw('COUNT(lugar_id) as puntos'))
            ->join('lugar_user',function($join){
            $join->on('users.id','=', 'lugar_user.user_id');
        });
    }
}

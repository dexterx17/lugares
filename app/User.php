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
}

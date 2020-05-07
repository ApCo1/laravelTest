<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','metaphone'
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function mreviews(){
        return $this->hasMany(Mreview::class); 
    }
    public function treviews(){
        return $this->hasMany(Treview::class); 
    }
    public function mwatchlaters(){
        return $this->hasMany(Mwatchlater::class); 
    }
    public function twatchlaters(){
        return $this->hasMany(Twatchlater::class); 
    }


    public function scopeSearch($query, $s){
        $m = metaphone($s);
        return $query->where('name', 'like', '%' .$s. '%')->orWhere('metaphone', 'like', '%' .$m. '%');
    }

}

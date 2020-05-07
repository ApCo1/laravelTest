<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tvshow extends Model
{
    //Table Name
    protected $table = 'tvshows';
    //Primary Key
    public $primaryKey = 'id';
    public function actors(){
        return $this->belongsToMany(Actor::class)->withPivot('character')->orderBy('name', 'asc');
    }
    public function creators(){
        return $this->belongsToMany(Creator::class)->orderBy('name', 'asc');
    }
    public function tgenres(){
        return $this->hasMany(Tgenre::class); 
    }
    public function treviews(){
        return $this->hasMany(Treview::class); 
    }
    public function twatchlaters(){
        return $this->hasMany(Twaterlater::class); 
    }
    

    public function scopeSearch($query, $s){
        $m = metaphone($s);
        return $query->where('name', 'like', '%' .$s. '%')->orWhere('metaphone', 'like', '%' .$m. '%');
    }
}

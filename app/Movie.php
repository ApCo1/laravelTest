<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    //Table Name
    protected $table = 'movies';
    //Primary Key
    public $primaryKey = 'id';
    //Actor-Movie pivot table
    public function actors(){
        return $this->belongsToMany(Actor::class)->withPivot('character')->orderBy('name', 'asc');
    }
    public function directors(){
        return $this->belongsToMany(Director::class)->orderBy('name', 'asc');
    }
    public function mgenres(){
        return $this->hasMany(Mgenre::class); 
    }
    public function mreviews(){
        return $this->hasMany(Mreview::class); 
    }
    public function mwatchlaters(){
        return $this->hasMany(Mwatchlater::class); 
    }
    
}

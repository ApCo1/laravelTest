<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Actor extends Model
{
    //Table Name
    protected $table = 'actors';
    //Primary Key
    public $primaryKey = 'id';
    //Actor-Movie pivot table
    public function movies(){
        return $this->belongsToMany(Movie::class)->withPivot('character')->orderBy('rating', 'desc');
    }
    //Actor-TV Show pivot table
    public function tvshows(){
        return $this->belongsToMany(Tvshow::class)->withPivot('character')->orderBy('rating', 'desc');
    }


    public function scopeSearch($query, $s){
        $m = metaphone($s);
        return $query->where('name', 'like', '%' .$s. '%')->orWhere('metaphone', 'like', '%' .$m. '%');
    }
}

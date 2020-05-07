<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creator extends Model
{
    //Table Name
    protected $table = 'creators';
    //Primary Key
    public $primaryKey = 'id';
    //Director-Movie pivot table
    public function tvshows(){
        return $this->belongsToMany(Tvshow::class)->orderBy('rating', 'desc');
    }
}

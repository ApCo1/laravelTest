<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    //Table Name
    protected $table = 'directors';
    //Primary Key
    public $primaryKey = 'id';
    //Director-Movie pivot table
    public function movies(){
        return $this->belongsToMany(Movie::class)->orderBy('rating', 'desc');
    }
}

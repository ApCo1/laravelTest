<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mgenre extends Model
{
    public function movie(){
        return $this->belongsTo(Movie::class); 
    }
    public function user(){
        return $this->belongsTo(User::class); 
    }
}

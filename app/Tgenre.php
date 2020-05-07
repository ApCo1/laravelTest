<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tgenre extends Model
{
    public function tvshow(){
        return $this->belongsTo(Tvshow::class); 
    }
}

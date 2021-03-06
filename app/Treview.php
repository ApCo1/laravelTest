<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Treview extends Model
{
    public function tvshow(){
        return $this->belongsTo(Tvshow::class); 
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}

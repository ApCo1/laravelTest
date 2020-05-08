<?php

namespace App\Http\Controllers\api\v1\actors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Actor;

class ActorController extends Controller
{
    public function index()
    {
        return Actor::all();
    }

    public function show($id)
    {
        $actor = Actor::where('id', '=', $id)->first();
        
        if(!isset($actor)){
            return response(['message' => 'No actor with the given id']);    
        }

        return $actor;
    }
}

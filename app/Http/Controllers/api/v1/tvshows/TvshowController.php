<?php

namespace App\Http\Controllers\api\v1\tvshows;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tvshow;

class TvshowController extends Controller
{
    public function index()
    {
        return Tvshow::all();
    }

    public function show($id)
    {
        $tvshow = Tvshow::where('id', '=', $id)->first();
        
        if(!isset($tvshow)){
            return response(['message' => 'No TV Show with the given id']);    
        }

        return $tvshow;
    }
}

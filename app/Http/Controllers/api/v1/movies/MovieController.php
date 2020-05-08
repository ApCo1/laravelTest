<?php

namespace App\Http\Controllers\api\v1\movies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();

        if(!empty($movies)){
            return response(['message' => 'No actors found']);    
        }

        return $movies;
    }

    public function show($id)
    {
        $movie = Movie::where('id', '=', $id)->first();
        
        if(!isset($movie)){
            return response(['message' => 'No movie with the given id']);    
        }

        return $movie;
    }
}

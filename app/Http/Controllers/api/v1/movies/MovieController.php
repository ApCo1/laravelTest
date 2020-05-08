<?php

namespace App\Http\Controllers\api\v1\movies;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Movie;

class MovieController extends Controller
{
    public function index()
    {
        return Movie::all();
    }
}

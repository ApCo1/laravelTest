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
}

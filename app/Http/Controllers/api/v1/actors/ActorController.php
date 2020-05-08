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
}

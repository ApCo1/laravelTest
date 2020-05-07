<?php

namespace App\Http\Controllers;

use App\Mwatchlater;
use Illuminate\Http\Request;
use App\Mreview;
use App\Movie;

class MwatchlaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()  
    {
        $user = auth()->user();
        if(!$user){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }
        $mwatchlaters = Mwatchlater::where('user_id','=', $user->id)->orderBy('place', 'desc')->paginate(5);
        return view('pages.users.watchlaterMovies')->with('mwatchlaters',$mwatchlaters); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $url = $req->input('url');
        $id1 = $req->input('movieid');
        $user = auth()->user();
        if(!$user){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }
        $id2= $user->id;
        $movie = Movie::find($id1);
        $p = 0;

        $m = Mwatchlater::where([
            ['movie_id','=',  $id1],
            ['user_id','=', $id2],
        ])->first();

        $mwl = Mwatchlater::where('user_id','=', $id2)->get();

        foreach($mwl as $mw){
            if($mw->place > $p){
                $p=$mw->place;
            }
        }
        
        if($m){
            $p=$p+1;
            $m->place = $p;
            $m->timestamps = false;
            $m->save();
        }else{
            $mwatchlater = new Mwatchlater;
            $mwatchlater->movie_id = $id1;
            $mwatchlater->user_id = $id2;
            $mwatchlater->place = $p+1;
            $mwatchlater->timestamps = false;
            $mwatchlater->save();
        }

        session(['success' => "Watchlater updated"]);
        redirect()->getUrlGenerator()->previous();
        return back();
    }

    public function remove(Request $req)
    {
        $id1 = $req->input('movieid');
        $user = auth()->user();
        $id2= $user->id;
        if(!$user){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }
        $movie = Movie::find($id1);
        $p = 0;

        $m = Mwatchlater::where([
            ['movie_id','=',  $id1],
            ['user_id','=', $id2],
        ])->first();

        $m->delete();
        session(['success' => "Watchlater updated"]);
        redirect()->getUrlGenerator()->previous();
        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Mwatchlater  $mwatchlater
     * @return \Illuminate\Http\Response
     */
    public function show(Mwatchlater $mwatchlater)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mwatchlater  $mwatchlater
     * @return \Illuminate\Http\Response
     */
    public function edit(Mwatchlater $mwatchlater)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mwatchlater  $mwatchlater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mwatchlater $mwatchlater)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mwatchlater  $mwatchlater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mwatchlater $mwatchlater)
    {
        //
    }
}

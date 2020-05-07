<?php

namespace App\Http\Controllers;

use App\Twatchlater;
use Illuminate\Http\Request;
use App\Treview;
use App\Tvshow;

class TwatchlaterController extends Controller
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
        $twatchlaters = Twatchlater::where('user_id','=', $user->id)->orderBy('place', 'desc')->paginate(5);
        return view('pages.users.watchlaterTvshows')->with('twatchlaters',$twatchlaters); 
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
        $id1 = $req->input('tvshowid');
        $user = auth()->user();
        $id2= $user->id;
        $tvshow = Tvshow::find($id1);
        $p = 0;

        $t = Twatchlater::where([
            ['tvshow_id','=',  $id1],
            ['user_id','=', $id2],
        ])->first();

        $twl = Twatchlater::where('user_id','=', $id2)->get();

        foreach($twl as $tw){
            if($tw->place > $p){
                $p = $tw->place;
            }
        }
        
        if($t){
            $p=$p+1;
            $t->place = $p;
            $t->timestamps = false;
            $t->save();
        }else{
            $twatchlater = new Twatchlater;
            $twatchlater->tvshow_id = $id1;
            $twatchlater->user_id = $id2;
            $twatchlater->place = $p+1;
            $twatchlater->timestamps = false;
            $twatchlater->save();
        }

        session(['success' => "Watchlater updated"]);
        redirect()->getUrlGenerator()->previous();
        return back();
    }

    public function remove(Request $req)
    {
        $id1 = $req->input('tvshowid');
        $user = auth()->user();
        $id2= $user->id;
        if(!$user){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }
        $tvshow = Tvshow::find($id1);
        $p = 0;

        $m = Twatchlater::where([
            ['tvshow_id','=',  $id1],
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
     * @param  \App\Twatchlater  $twatchlater
     * @return \Illuminate\Http\Response
     */
    public function show(Twatchlater $twatchlater)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Twatchlater  $twatchlater
     * @return \Illuminate\Http\Response
     */
    public function edit(Twatchlater $twatchlater)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Twatchlater  $twatchlater
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Twatchlater $twatchlater)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Twatchlater  $twatchlater
     * @return \Illuminate\Http\Response
     */
    public function destroy(Twatchlater $twatchlater)
    {
        //
    }
}

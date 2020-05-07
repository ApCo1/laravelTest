<?php

namespace App\Http\Controllers;

use App\Treview;
use Illuminate\Http\Request;
use App\Tvshow;

class TreviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if ($req->has('review')) {
            $url = $req->input('url');
            $id1 = $req->input('tvshowid');
            $user = auth()->user();
            $id2= $user->id;
            $tvshow = Tvshow::find($id1);
            $r = $req->input('review');
            $m = Treview::where([
                ['tvshow_id','=',  $id1],
                ['user_id','=', $id2],
            ])->first();

            if(!$req->input('review')){
                return view('pages.tvshows.tvshow')->with('tvshow',$tvshow);
            }elseif($req->input('review')<0 OR $req->input('review')>10){
                return view('pages.tvshows.tvshow')->with('tvshow',$tvshow);
            }else{
                if($m){
                    $m->rating = $r;
                    $m->timestamps = false;
                    $m->save();
                }else{
                    $treview = new Treview;
                    $treview->tvshow_id = $id1;
                    $treview->user_id = $id2;
                    $treview->rating = $r;
                    $treview->timestamps = false;
                    $treview->save();
                }

                $tvshow->rating = $tvshow->treviews->avg('rating');
                $tvshow->no_reviews = count($tvshow->treviews);
                $tvshow->timestamps = false;
                $tvshow->update();

                $all = Treview::where('user_id', '=', $id2)->get();
                $sum=0;
                foreach($all as $a){
                    $sum += $a->rating;
                }
                $user->tvshow_reviews = count($all);
                $user->average_treviews = $all->avg('rating');
                $user->timestamps = false;
                $user->save();
            }
            session(['success' => "Rating Complete"]);
            redirect()->getUrlGenerator()->previous();
            return back();
        }else{
            session(['error' => "Rating Failed"]);
            return back();
        }
        
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Treview  $treview
     * @return \Illuminate\Http\Response
     */
    public function show(Treview $treview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Treview  $treview
     * @return \Illuminate\Http\Response
     */
    public function edit(Treview $treview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Treview  $treview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Treview $treview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Treview  $treview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Treview $treview)
    {
        //
    }
}

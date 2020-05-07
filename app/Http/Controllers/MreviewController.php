<?php

namespace App\Http\Controllers;

use App\Mreview;
use Illuminate\Http\Request;
use App\Movie;

class MreviewController extends Controller
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
        $url = $req->input('url');
        if ($req->has('rate')) {

            $id1 = $req->input('movieid');
            $user = auth()->user();
            $id2= $user->id;
            $movie = Movie::find($id1);
            $r = $req->input('review');
            $m = Mreview::where([
                ['movie_id','=',  $id1],
                ['user_id','=', $id2],
            ])->first();
            
        
            if(!$req->input('review')){
                return view('pages.movies.movie')->with('movie',$movie);
            }elseif($req->input('review')<0 OR $req->input('review')>10){
                return view('pages.movies.movie')->with('movie',$movie);
            }else{
                if($m){
                    $m->rating = $r;
                    $m->timestamps = false;
                    $m->save();
                }else{
                    $mreview = new Mreview;
                    $mreview->movie_id = $id1;
                    $mreview->user_id = $id2;
                    $mreview->rating = $r;
                    $mreview->timestamps = false;
                    $mreview->save();
                }


                $movie->rating = $movie->mreviews->avg('rating');
                $movie->no_reviews = count($movie->mreviews);
                $movie->timestamps = false;
                $movie->update();

                $all = Mreview::where('user_id', '=', $id2)->get();
                $sum=0;
                foreach($all as $a){
                    $sum += $a->rating;
                }
                $user->movie_reviews = count($all);
                $user->average_mreviews = $all->avg('rating');
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
     * @param  \App\Mreview  $mreview
     * @return \Illuminate\Http\Response
     */
    public function show(Mreview $mreview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mreview  $mreview
     * @return \Illuminate\Http\Response
     */
    public function edit(Mreview $mreview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mreview  $mreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mreview $mreview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mreview  $mreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mreview $mreview)
    {
        //
    }
}

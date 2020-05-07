<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Tvshow;
use Illuminate\Http\Request;
use App\Auth;
use App\Treview;
use App\Actor;
use App\Creator;


class TvshowsController extends Controller
{
    public function index()
    {
        $tvshows = Tvshow::orderBy('name', 'desc')->paginate(5);
        $data = [
            'search'  => 'name',
            'order'   => 'desc',
            'tvshows'  => $tvshows
        ];
        return view('pages.tvshows.tvshows_sorted')->with('data',$data);
    }

    public function sort(Request $req)
    {
        if(!$req->input('sort')){
            $search='name';
        }
        if(!$req->input('sort')){
            $order='asc';
        }
        $search = $req->input('sort');
        $order = $req->input('order');
        
        switch ($search) {
            case 'title':
                if($order == 'asc'){
                    $tvshows = Tvshow::orderBy('name', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $tvshows = Tvshow::orderBy('name', 'desc')->paginate(5);
                }else{
                    $tvshows = Tvshow::orderBy('name', 'desc')->paginate(5);
                }
                break;
            case 'year_of_release':
                if($order == 'asc'){
                    $tvshows = Tvshow::orderBy('year_of_release', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $tvshows = Tvshow::orderBy('year_of_release', 'desc')->paginate(5);
                }else{
                    $tvshows = Tvshow::orderBy('year_of_release', 'desc')->paginate(5);
                }
                break;
            case 'duration':
                if($order == 'asc'){
                    $tvshows = Tvshow::orderBy('duration', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $tvshows = Tvshow::orderBy('duration', 'desc')->paginate(5);
                }else{
                    $tvshows = Tvshow::orderBy('duration', 'desc')->paginate(5);
                }
                break;
            case 'no_reviews':
                if($order == 'asc'){
                    $tvshows = Tvshow::orderBy('no_reviews', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $tvshows = Tvshow::orderBy('no_reviews', 'desc')->paginate(5);
                }else{
                    $tvshows = Tvshow::orderBy('no_reviews', 'desc')->paginate(5);
                }
                break;
            default:
                $tvshows = Tvshow::orderBy('name', 'desc')->paginate(5);
        }
        $data = [
            'search'  => $search,
            'order'   => $order,
            'tvshows'  => $tvshows
        ];
        return view('pages.tvshows.tvshows_sorted')->with('data',$data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $temp = auth()->user();
        if(!$temp){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }

        $tvshows = Tvshow::get();

        //Check for correct user level
        if($temp->level == 'editor' OR $temp->level == 'admin' or $temp->level == 'ultraadmin'){
            return view('pages.tvshows.create')->with('tvshows',$tvshows);
        }else{
            session(['error' => "Access Denied"]);
            return redirect('/tvshows');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'year_of_release' => 'required',
            'duration'  => 'required',
            'info' => 'required',
            'actorid'  => 'required',
            'creatorid'  => 'required',
            'genre' => 'required',
            'image' => 'required'
        ]);
        //Tvshow
        $tvshows = Tvshow::get();

        foreach($tvshows as $tvshow){
            if($tvshow->name == $request->input('title') and $tvshow->year_of_release == $request->input('year_of_release')){
                session(['error' => "Tvshow already exists"]);
                return view('pages.tvshows.tvshow')->with('tvshow',$tvshow);
            }
        }

        $m = new Tvshow;
        $m->name = $request->input('title');
        $m->metaphone = metaphone($request->input('title'));
        $m->year_of_release = $request->input('year_of_release');
        $m->year_of_end = $request->input('year_of_end');
        $m->duration = $request->input('duration');
        $m->image = $request->input('image');
        $m->info = $request->input('info');
        $m->no_seasons = $request->input('no_seasons');
        $m->no_episodes = $request->input('no_episodes');
        $m->timestamps = false;
        $m->save();



        //Actors
        $id_actor = $request->input('actorid');
        $i = 1;
        $actors = Actor::where('id', $id_actor[0])->get();
        if(isset($id_actor[$i])){
            do{
                (int)$temp = $id_actor[$i];
                $actor = Actor::where('id', $temp)->first();
                $actors->push($actor);
                $i++;
            }while(isset($id_actor[$i]));
        }
        foreach($actors as $actor){
            $temp = DB::table('actor_tvshow')->insert([
                'actor_id' => $actor->id, 'tvshow_id' => $m->id
            ]);
        }


        //Creators
        $id_creator = $request->input('creatorid');
        $i = 1;
        $creators = Creator::where('id', $id_creator[0])->get();
        if(isset($id_creator[$i])){
            do{
                (int)$temp = $id_creator[$i];
                $creator = Creator::where('id', $temp)->first();
                $creators->push($creator);
                $i++;
            }while(isset($id_creator[$i]));
        }
        foreach($creators as $creator){
            $temp = DB::table('creator_tvshow')->insert([
                'creator_id' => $creator->id, 'tvshow_id' => $m->id
            ]);
        }

        //Genres
        $genres = $request->input('genre');
        $i = 0;
        do{
            $temp = DB::table('mgenres')->insert([
                'tvshow_id' => $m->id, 'genre' => $genres[$i],
            ]);
            $i++;
        }while(isset($genres[$i]));
        
        session(['success' => "Tvshow Created"]);
        return view('pages.tvshows.tvshow')->with('tvshow',$m);
    }
    

    public function show(Tvshow $tvshow)
    {   
        return view('pages.tvshows.tvshow')->with('tvshow',$tvshow);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        /*
        //Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error',"Unauthorized access to page");
        }
        return view('posts.edit')->with('post',$post);
        */
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        /*
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);

        //Edit post
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->save();

        return redirect('/posts')->with('success', 'Post Updated');
        */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        /*
        //Check for correct user
        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error',"Unauthorized access to page");
        }

        $post->delete();
        return redirect('/dashboard')->with('success', 'Post Removed');
        */
    } 
}

<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Movie;
use App\Auth;
use App\Mreview;
use App\Actor;
use App\Director;
use Illuminate\Support\Facades\DB;

class MoviesController extends Controller
{
    public function index()
    {
        $movies = Movie::orderBy('rating', 'desc')->paginate(5);
        $data = [
            'search'  => 'rating',
            'order'   => 'desc',
            'movies'  => $movies
        ];
        return view('pages.movies.movies_sorted')->with('data',$data);   
    }

    public function sort(Request $req)
    {
        $search = $req->input('sort');
        $order = $req->input('order');
        $error = 0;
        
        switch ($search) {
            case 'title':
                if($order == 'asc'){
                    $movies = Movie::orderBy('name', 'asc')->paginate(5);
                    
                }elseif($order == 'desc'){
                    $movies = Movie::orderBy('name', 'desc')->paginate(5);
                }else{
                    $movies = Movie::orderBy('name', 'desc')->paginate(5);
                }
                break;
            case 'year_of_release':
                if($order == 'asc'){
                    $movies = Movie::orderBy('year_of_release', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $movies = Movie::orderBy('year_of_release', 'desc')->paginate(5);
                }else{
                    $movies = Movie::orderBy('year_of_release', 'desc')->paginate(5);
                }
                break;
            case 'duration':
                if($order == 'asc'){
                    $movies = Movie::orderBy('duration', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $movies = Movie::orderBy('duration', 'desc')->paginate(5);
                }else{
                    $movies = Movie::orderBy('duration', 'desc')->paginate(5);
                }
                break;
            case 'no_reviews':
                if($order == 'asc'){
                    $movies = Movie::orderBy('no_reviews', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $movies = Movie::orderBy('no_reviews', 'desc')->paginate(5);
                }else{
                    $movies = Movie::orderBy('no_reviews', 'desc')->paginate(5);
                }
                break;
            case 'rating':
                if($order == 'asc'){
                    $movies = Movie::orderBy('rating', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $movies = Movie::orderBy('rating', 'desc')->paginate(5);
                }else{
                    $movies = Movie::orderBy('rating', 'desc')->paginate(5);
                }
                break;
            default:
                $movies = Movie::orderBy('rating', 'desc')->paginate(5);
                $error = 1;
        }
        if($error = 1){
            $data = [
                'search'  => $search,
                'order'   => $order,
                'movies'  => $movies,
                'error'   => "Sort Failed",
            ];
            return view('pages.movies.movies_sorted')->with('data',$data);
        }
        $data = [
            'search'  => $search,
            'order'   => $order,
            'movies'  => $movies,
        ];
        return view('pages.movies.movies_sorted')->with('data',$data);
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //Check if logged-in in general
        $temp = auth()->user();
        if(!$temp){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }

        $movies = Movie::get();

        //Check for correct user level
        if($temp->level == 'editor' OR $temp->level == 'admin' or $temp->level == 'ultraadmin'){
            return view('pages.movies.create')->with('movies',$movies);
        }else{
            session(['error' => "Access Denied"]);
            return redirect('/movies');
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
            'directorid'  => 'required',
            'genre' => 'required',
            'image' => 'required'
        ]);
        //Movie
        $movies = Movie::get();

        foreach($movies as $movie){
            if($movie->name == $request->input('title') and $movie->year_of_release == $request->input('year_of_release')){
                session(['error' => "Movie already exists"]);
                return view('pages.movies.movie')->with('movie',$movie);
            }
        }

        $m = new Movie;
        $m->name = $request->input('title');
        $m->metaphone = metaphone($request->input('title'));
        $m->year_of_release = $request->input('year_of_release');
        $m->duration = $request->input('duration');
        $m->image = $request->input('image');
        $m->info = $request->input('info');
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
            $temp = DB::table('actor_movie')->insert([
                'actor_id' => $actor->id, 'movie_id' => $m->id
            ]);
        }


        //Directors
        $id_director = $request->input('directorid');
        $i = 1;
        $directors = Director::where('id', $id_director[0])->get();
        if(isset($id_director[$i])){
            do{
                (int)$temp = $id_director[$i];
                $director = Director::where('id', $temp)->first();
                $directors->push($director);
                $i++;
            }while(isset($id_director[$i]));
        }
        foreach($directors as $director){
            $temp = DB::table('director_movie')->insert([
                'director_id' => $director->id, 'movie_id' => $m->id
            ]);
        }

        //Genres
        $genres = $request->input('genre');
        $i = 0;
        do{
            $temp = DB::table('mgenres')->insert([
                'movie_id' => $m->id, 'genre' => $genres[$i],
            ]);
            $i++;
        }while(isset($genres[$i]));
        
        session(['success' => "Movie Created"]);
        return view('pages.movies.movie')->with('movie',$m);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)

    {   
        return view('pages.movies.movie')->with('movie',$movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        // 
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

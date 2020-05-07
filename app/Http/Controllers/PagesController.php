<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Movie;
use App\Actor;
use App\Tvshow;

class PagesController extends Controller
{
    public function index(){
        return view('pages.index');
    }
    
    public function redirect(){
        return redirect()->action('PagesController@index');
    }
    public function search(Request $req){  
        if ($req->has('searchbtn')) {
            if (strlen($req->input('s')) < 3){
                session(['error' => "Minimum 3 characters"]);
                return view('pages.index');
            }
            $s = $req->input('s');
            $option = $req->input('option');
            $m = metaphone($s);
            

            switch ($option) {
                case 'movies':
                    $movies = Movie::where('metaphone', 'like', '%' .$m. '%')->orWhere('name','like', '%' .$s. '%')->take(20)->get();
                    $data = array(
                        's' => $s,
                        'movies' => $movies
                    );
                    return view('pages.movies.search')->with('data',$data);

                case 'tvshows':
                    $tvshows = Tvshow::where('metaphone', 'like', '%' .$m. '%')->orWhere('name','like', '%' .$s. '%')->take(20)->get();
                    $data = array(
                        's' => $s,
                        'tvshows' => $tvshows
                    );
                    return view('pages.tvshows.search')->with('data', $data);

                case 'actors':
                    $actors = Actor::where('metaphone', 'like', '%' .$m. '%')->orWhere('name','like', '%' .$s. '%')->take(20)->get();
                    $data = array(
                        's' => $s,
                        'actors' => $actors
                    );
                    return view('pages.actors.search')->with('data', $data);
                
                case 'users':
                    $users = User::where([
                        ['metaphone', 'like', '%' .$m. '%'],
                        ['level', '<>', 'admin'],
                        ['level', '<>', 'ultraadmin'],
                    ])->orWhere([
                        ['name','like', '%' .$s. '%'],
                        ['level', '<>', 'admin'],
                        ['level', '<>', 'ultraadmin'],
                    ])->take(20)->get();
                    $data = array(
                        's' => $s,
                        'users' => $users
                    );
                    return view('pages.users.search')->with('data', $data);

                case 'admins':
                    $users = User::where([
                        ['metaphone', 'like', '%' .$m. '%'],
                        ['level', '=', 'admin'],
                    ])->orWhere([
                        ['name','like', '%' .$s. '%'],
                        ['level', '=', 'admin'],
                    ])->take(20)->get();
                    $data = array(
                        's' => $s,
                        'users' => $users
                    );
                return view('pages.users.search')->with('data', $data);
                default:
                session(['error' => "Something went wrong"]);
                return view('pages.index');
            } 
        }
        session(['error' => "Something went wrong"]);
        return view('pages.index');
    }
}

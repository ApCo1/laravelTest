<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\User;
use App\Mreview;
use App\Treview;
use Illuminate\Http\Request;

Route::any('olx', 'OlxsController');

Route::any('olx/{id}', function($id){
    if(!$id){
        session(['error' => "Incorrect input"]);
        return view('pages.index');
    }
    $adresa = 'https://www.olx.ba/api/kategorije/';
    $adresa .= $id;
    
    $user = auth()->user();
    if(!$user){
        session(['error' => "Access Denied"]);
        return view('pages.index');
    }

    $curl = curl_init();
    $idOLX = '877301020045';
    $tokenOLX = 'mOxqfD48dSTV8dh8830OoccXy54A';
    curl_setopt_array($curl, array(
        CURLOPT_URL => $adresa,
        //CURLOPT_URL => 'https://www.olx.ba/api/brendovi/1887',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_TIMEOUT => 30000,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            // Set Here Your Requesred Headers
            'OLX-CLIENT-ID:' . $idOLX,
            'OLX-CLIENT-TOKEN:' . $tokenOLX,
            'Content-Type: application/json',
        ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        //$json = '[' . $response . ']';
        $nresp = json_decode($response, true);
        //$status = $nresp[0]["status"];
        //$status = $this->statusAKS($status);
    }       
    //dd($nresp);
    //$data = $nresp['artikli'];
    // print_r ("CREATE TABLE 'pik' (
    //     'id_pik' int(11) unsigned NOT NULL,
    //     'naziv_pik' varchar(255) NOT NULL,
    //     'interni_id' int(11) unsigned NOT NULL,
    //     'interni_naziv' varchar(255) NOT NULL
    // )");
    //print_r("INSERT INTO 'pik' ('id_pik', 'naziv_pik', 'interni_id', 'interni_naziv') VALUES");
    //$this->rekurzija($nresp['kategorije']);
    //$data = $nresp;
    //return view('olx');//->with(compact('data', $data));
    return view('olx')->with('nresp',$nresp);
});

Route::get('/', 'PagesController@index')->name('/');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('movies','MoviesController');
Route::resource('tvshows','TvshowsController');
Route::resource('actors','ActorsController');
Route::resource('directors','DirectorsController');
Route::resource('creators','CreatorsController');
Route::resource('mreview', 'MreviewController');
Route::resource('treview', 'TreviewController');
Route::resource('mwatchlater','MwatchlaterController');
Route::resource('twatchlater','TwatchlaterController');


Route::any('movies_sorted', 'MoviesController@sort');
Route::any('tvshows_sorted', 'TvshowsController@sort');
Route::any('actors_sorted', 'ActorsController@sort');
Route::any('directors_sorted', 'DirectorsController@sort');
Route::any('creators_sorted', 'CreatorsController@sort');

Route::any('mwlremove', 'MwatchlaterController@remove')->name('mwlremove');
Route::any('twlremove', 'TwatchlaterController@remove')->name('twlremove');

Route::any('search', 'PagesController@search')->name('search');

Route::any('movies/create', 'MoviesController@create');
Route::any('actors/create','ActorsController@create');
Route::any('directors/create','DirectorsController@create');
Route::any('creators/create','CreatorsController@create');
Route::any('tvshows/create', 'TvshowsController@create');


Route::any('users_sorted', function(Request $req){
        $search = $req->input('sort');
        $order = $req->input('order');
        $error = 0;
        $temp = Auth::user();
        if(!$temp){
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }
        $level = $temp->level;
        if($level == 'admin') {
            switch ($search) {
                case 'name':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orderBy('name', 'asc')->paginate(25);
                        
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orderBy('name', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orderBy('name', 'desc')->paginate(25);
                    }
                    break;
                case 'id':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orderBy('id', 'asc')->paginate(25);
                        
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orderBy('id', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orderBy('id', 'asc')->paginate(25);
                    }
                    break;
                case 'mreviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orderBy('movie_reviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orderBy('movie_reviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orderBy('movie_reviews', 'desc')->paginate(25);
                    }
                    break;
                case 'treviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orderBy('tvshow_reviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orderBy('tvshow_reviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orderBy('tvshow_reviews', 'desc')->paginate(25);
                    }
                    break;
                case 'averagemreviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orderBy('average_mreviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orderBy('average_mreviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orderBy('average_mreviews', 'desc')->paginate(25);
                    }
                    break;
                case 'averagetreviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orderBy('average_treviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orderBy('average_treviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orderBy('average_treviews', 'desc')->paginate(25);
                    }
                    break;
                default:
                    $users = User::where('level', '=', 'user')->orderBy('id', 'asc')->paginate(25);
                    $error = 1;
            }
        }elseif($level == 'ultraadmin'){
            switch ($search) {
                case 'name':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('name', 'asc')->paginate(25);
                        
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('name', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('name', 'desc')->paginate(25);
                    }
                    break;
                case 'id':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('id', 'asc')->paginate(25);
                        
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('id', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('id', 'asc')->paginate(25);
                    }
                    break;
                case 'mreviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('movie_reviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('movie_reviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('movie_reviews', 'desc')->paginate(25);
                    }
                    break;
                case 'treviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('tvshow_reviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('tvshow_reviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('tvshow_reviews', 'desc')->paginate(25);
                    }
                    break;
                case 'averagemreviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('average_mreviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('average_mreviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('average_mreviews', 'desc')->paginate(25);
                    }
                    break;
                case 'averagetreviews':
                    if($order == 'asc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('average_treviews', 'asc')->paginate(25);
                    }elseif($order == 'desc'){
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('average_treviews', 'desc')->paginate(25);
                    }else{
                        $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('average_treviews', 'desc')->paginate(25);
                    }
                    break;
                default:
                    $users = User::where('level', '=', 'user')->orWhere('level', '=', 'admin')->orderBy('id', 'asc')->paginate(25);
                    $error = 1;
            }
        }else{
            session(['error' => "Access Denied"]);
            return view('pages.index');
        }
        
        
        if($error = 1){
            $data = [
                'search'  => 'id',
                'order'   => 'asc',
                'users'  => $users,
            ];
            session(['error' => "sorted By ID in Ascending order"]);
            return view('pages.users.users_sorted')->with('data',$data);
        }
        $data = [
            'search'  => $search,
            'order'   => $order,
            'users'  => $users,
        ];
        return view('pages.users.users_sorted')->with('data',$data);
})->name('users_sorted');

Route::get('users/{id}/edit', function($id){
    $user = User::where('id', '=', $id)->first();
    $temp = Auth::user();
    if(!$temp){
        session(['error' => "Access Denied"]);
        return view('pages.index');
    }
    return view('pages.users.edit')->with('user', $user);
})->name('users.edit');

Route::any('users/update', function(Request $req){
    $id = $req->input('id');
    $name = $req->input('name');
    $level = $req->input('lvl');
    if(!$id or !$name){
        session(['error' => "Incorrect input"]);
        return view('pages.index');
    }
    $user = User::find($id);
    $user->name = $name;
    $user->level = $level;
    $user->save();

    session(['success' => "User updated"]);
    return view('pages.users.user')->with('user', $user);
})->name('users.update');

Route::get('users/{id}', function($id){
    if(!$id){
        session(['error' => "Incorrect input"]);
        return view('pages.index');
    }
    $temp = Auth::user();
    if(!$temp){
        session(['error' => "Access Denied"]);
        return view('pages.index');
    }
    $user = User::find($id);
    return view('pages.users.user')->with('user', $user);
})->name('users.show');

Route::post('/user/deleteMovieReviews' , function(Request $req){
    $id = $req->input('muser');
    if(!$id){
        session(['error' => "Something went wrong"]);
        return view('pages.index');
    }
    $user = User::find($id);
    $temp = auth()->user();
    if(!$temp){
        session(['error' => "Access Denied"]);
        return view('pages.index');
    }
    $what = 0;
    switch($temp->level){
        case 'ultraadmin':
            if($user->level == 'ultraadmin'){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }else{
                foreach($user->mreviews as $mreview){
                    $mreview->delete();
                }
                $user->movie_reviews = '0';
                $user->average_mreviews = '0';
                $user->timestamps = false;
                $user->save();
            }
        break;
        case 'admin':
            if($user->level == 'admin' or $user->level == 'ultraadmin'){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }else{
                foreach($user->mreviews as $mreview){
                    $mreview->delete();
                }
                $user->movie_reviews = '0';
                $user->average_mreviews = '0';
                $user->timestamps = false;
                $user->save();
            } 
        break;
        default: 
            session(['error' => "Access Denied"]);
            return view('pages.index');
    }
    session(['success' => "Deleted successfully"]);
    return view('pages.users.user')->with('user', $user);

})->name('delete_mreview');

Route::post('/user/deleteTvShowReviews', function(Request $req){
    $id = $req->input('tuser');
    if(!$id){
        session(['error' => "Something went wrong"]);
        return view('pages.index');
    }
    $user = User::find($id);
    $temp = auth()->user();
    if(!$temp){
        session(['error' => "Access Denied"]);
        return view('pages.index');
    }
    $what = 0;
    switch($temp->level){
        case 'ultraadmin':
            if($user->level == 'ultraadmin'){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }else{
                foreach($user->treviews as $treview){
                    $treview->delete();
                }
                $user->tvshow_reviews = '0';
                $user->average_treviews = '0';
                $user->timestamps = false;
                $user->save();
            }
        break;
        case 'admin':
            if($user->level == 'admin' or $user->level == 'ultraadmin'){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }else{
                foreach($user->treviews as $treview){
                    $treview->delete();
                }
                $user->tvshow_reviews = '0';
                $user->average_treviews = '0';
                $user->timestamps = false;
                $user->save();
            } 
        break;
        default: 
            session(['error' => "Access Denied"]);
            return view('pages.index');
    }
    session(['success' => "Deleted successfully"]);
    return view('pages.users.user')->with('user', $user);
    
})->name('delete_treview');

Route::get('user/{id}/ratedMovies', function($id){
    $user = User::find($id);
    $mreviews = Mreview::where('user_id', '=',$user->id)->get();
    return view('pages.users.rated_movies')->with('mreviews',$mreviews);
})->name('ratedMovies');

Route::get('user/{id}/ratedTvShows', function($id){
    $user = User::find($id);
    $treviews = Treview::where('user_id', '=',$user->id)->get();
    return view('pages.users.rated_tvshows')->with('treviews',$treviews);
})->name('ratedTvShows');

Route::any('users/{id}/delete', function($id){
    if(!$id){
        session(['error' => "Something went wrong"]);
        return view('pages.index');
    }
    
    $user = User::find($id);
    $temp = auth()->user();
    if(!$temp){
        session(['error' => "Access Denied"]);
        return view('pages.index');
    }
    $what = 0;
    if(!$user){
        session(['error' => "User doesn't exist"]);
        return view('pages.index');
    }
    $name = $user->name;
    switch($temp->level){
        case 'ultraadmin':
            if($user->level == 'ultraadmin'){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }else{
                foreach($user->mreviews as $mreview){
                    $mreview->delete();
                }
                foreach($user->treviews as $treview){
                    $treview->delete();
                }
                $user->delete();
            }
        break;
        case 'admin':
            if($user->level == 'admin' or $user->level == 'ultraadmin'){
                session(['error' => "Access Denied"]);
                return view('pages.index');
            }else{
                foreach($user->mreviews as $mreview){
                    $mreview->delete();
                }
                foreach($user->treviews as $treview){
                    $treview->delete();
                }
                $user->delete();
            } 
        break;
        default: 
            session(['error' => "Access Denied"]);
            return view('pages.index');
    }
    session(['success' => "User". $name . "Deleted successfully"]);
    return view('pages.index');

})->name('users.delete');

<?php

namespace App\Http\Controllers;
use App\Actor;
use Illuminate\Http\Request;

class ActorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actors = Actor::orderBy('name', 'asc')->paginate(5);
        $data = [
            'search'  => 'name',
            'order'   => 'asc',
            'actors'  => $actors
        ];
        return view('pages.actors.actors_sorted')->with('data',$data);
    }

    public function sort(Request $request)
    {
        if($request->input('sort')){
            $search='name';
        }
        if($request->input('sort')){
            $order='desc';
        }
        $search = $request->input('sort');
        $order = $request->input('order');
        
        switch ($search) {
            case 'name':
                if($order == 'asc'){
                    $actors = Actor::orderBy('name', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $actors = Actor::orderBy('name', 'desc')->paginate(5);
                }else{
                    $actors = Actor::orderBy('name', 'desc')->paginate(5);
                }
                break;
            case 'dob':
                if($order == 'asc'){
                    $actors = Actor::orderBy('dob', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $actors = Actor::orderBy('dob', 'desc')->paginate(5);
                }else{
                    $actors = Actor::orderBy('dob', 'desc')->paginate(5);
                }
                break;
            case 'rating':
                if($order == 'asc'){
                    $actors = Actor::orderBy('rating', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $actors = Actor::orderBy('rating', 'desc')->paginate(5);
                }else{
                    $actors = Actor::orderBy('rating', 'desc')->paginate(5);
                }
                break;
            default:
                $actors = Actor::orderBy('name', 'asc')->paginate(5);
        }
        $data = [
            'search'  => $search,
            'order'   => $order,
            'actors'  => $actors
        ];
        return view('pages.actors.actors_sorted')->with('data',$data);
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

        $actors = Actor::get();

        //Check for correct user level
        if($temp->level == 'editor' OR $temp->level == 'admin' or $temp->level == 'ultraadmin'){
            return view('pages.actors.create')->with('actors',$actors);
        }else{
            session(['error' => "Access Denied"]);
            return redirect('/actors');
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
            'name' => 'required',
            'dob' => 'required',
            'sex'  => 'required',
            'info' => 'required',
            'image'  => 'required'
        ]);
        //Movie
        $actors = Actor::get();

        foreach($actors as $actor){
            if($actor->name == $request->input('name') and $actor->dob == $request->input('dob')){
                session(['error' => "Actor already exists"]);
                return view('pages.actors.actor')->with('actor',$actor);
            }
        }

        $a = new Actor;
        $a->name = $request->input('name');
        $a->metaphone = metaphone($request->input('name'));
        $a->dob = $request->input('dob');
        if($request->input('dod')!= null){
            $a->dod = $request->input('dod');
        }
        $a->image = $request->input('image');
        $a->info = $request->input('info');
        $a->timestamps = false;
        $a->save();

        session(['success' => "Actor Created"]);
        return view('pages.actors.actor')->with('actor',$a);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Actor $actor)
    {
        return view('pages.actors.actor')->with('actor',$actor);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

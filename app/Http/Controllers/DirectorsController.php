<?php

namespace App\Http\Controllers;
use App\Director;
use Illuminate\Http\Request;

class DirectorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directors = Director::orderBy('name', 'desc')->paginate(5);
        $data = [
            'search'  => 'name',
            'order'   => 'asc',
            'directors'  => $directors
        ];
        return view('pages.directors.directors_sorted')->with('data',$data);
    }

    public function sort(Request $req)
    {
        if(!$req->input('sort')){
            $search='name';
        }
        if(!$req->input('sort')){
            $order='desc';
        }
        $search = $req->input('sort');
        $order = $req->input('order');
        
        switch ($search) {
            case 'name':
                if($order == 'asc'){
                    $directors = Director::orderBy('name', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $directors = Director::orderBy('name', 'desc')->paginate(5);
                }else{
                    $directors = Director::orderBy('name', 'desc')->paginate(5);
                }
                break;
            case 'dob':
                if($order == 'asc'){
                    $directors = Director::orderBy('dob', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $directors = Director::orderBy('dob', 'desc')->paginate(5);
                }else{
                    $directors = Director::orderBy('dob', 'desc')->paginate(5);
                }
                break;
            case 'rating':
                if($order == 'asc'){
                    $directors = Director::orderBy('rating', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $directors = Director::orderBy('rating', 'desc')->paginate(5);
                }else{
                    $directors = Director::orderBy('rating', 'desc')->paginate(5);
                }
                break;
            default:
                $directors = Director::orderBy('name', 'asc')->paginate(5);
        }
        $data = [
            'search'  => $search,
            'order'   => $order,
            'directors'  => $directors
        ];
        return view('pages.directors.directors_sorted')->with('data',$data);
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

        $directors = Director::get();

        //Check for correct user level
        if($temp->level == 'editor' OR $temp->level == 'admin' or $temp->level == 'ultraadmin'){
            return view('pages.directors.create')->with('directors',$directors);
        }else{
            session(['error' => "Access Denied"]);
            return redirect('/directors');
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
        //Director
        $directors = Director::get();

        foreach($directors as $director){
            if($director->name == $request->input('name') and $director->dob == $request->input('dob')){
                session(['error' => "Director already exists"]);
                return view('pages.directors.director')->with('director',$director);
            }
        }

        $a = new Director;
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

        session(['success' => "Director Created"]);
        return view('pages.directors.director')->with('director',$a);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Director $director)
    {
        return view('pages.directors.director')->with('director',$director);
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

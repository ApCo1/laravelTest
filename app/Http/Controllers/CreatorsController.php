<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Creator;

class CreatorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $creators = Creator::orderBy('name', 'asc')->paginate(5);
        $data = [
            'search'  => 'name',
            'order'   => 'desc',
            'creators'  => $creators
        ];
        return view('pages.creators.creators_sorted')->with('data',$data);
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
                    $creators = Creator::orderBy('name', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $creators = Creator::orderBy('name', 'desc')->paginate(5);
                }else{
                    $creators = Creator::orderBy('name', 'desc')->paginate(5);
                }
                break;
            case 'dob':
                if($order == 'asc'){
                    $creators = Creator::orderBy('dob', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $creators = Creator::orderBy('dob', 'desc')->paginate(5);
                }else{
                    $creators = Creator::orderBy('dob', 'desc')->paginate(5);
                }
                break;
            case 'rating':
                if($order == 'asc'){
                    $creators = Creator::orderBy('rating', 'asc')->paginate(5);
                }elseif($order == 'desc'){
                    $creators = Creator::orderBy('rating', 'desc')->paginate(5);
                }else{
                    $creators = Creator::orderBy('rating', 'desc')->paginate(5);
                }
                break;
            default:
                $creators = Creator::orderBy('name', 'asc')->paginate(5);
        }
        $data = [
            'search'  => $search,
            'order'   => $order,
            'creators'  => $creators
        ];
        return view('pages.creators.creators_sorted')->with('data',$data);
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

        $creators = Creator::get();

        //Check for correct user level
        if($temp->level == 'editor' OR $temp->level == 'admin' or $temp->level == 'ultraadmin'){
            return view('pages.creators.create')->with('creators',$creators);
        }else{
            session(['error' => "Access Denied"]);
            return redirect('/creators');
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
        //Creator
        $creators = Creator::get();

        foreach($creators as $creator){
            if($creator->name == $request->input('name') and $creator->dob == $request->input('dob')){
                session(['error' => "Creator already exists"]);
                return view('pages.creators.creator')->with('creator',$creator);
            }
        }

        $a = new Creator;
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

        session(['success' => "Creator Created"]);
        return view('pages.creators.creator')->with('creator',$a);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Creator $creator)
    {
        return view('pages.creators.creator')->with('creator',$creator);
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

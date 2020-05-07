
@extends('layouts.app')
@section('content')
    <?php 
        $actors = $data['actors']; 
        switch ($data['search']) {
            case 'name':
                $search = 'Name';
                break;
            case 'dob':
                $search = 'Age';
                break;
            default: 
                $search = 'Name';
        }
        switch ($data['order']) {
            case 'asc':
                $order = 'Ascending';
                break;
            case 'desc':
                $order = 'Descending';
                break;
            default: 
                $order = 'Descending';
        }
    ?>
    @if(count($actors)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Actors:</h1>
            <div class="float-right pt-4">
                <form class="form-inline" method="post" action="actors_sorted">
                    {{ csrf_field() }}
                    <label for="sortActors" class="p-2" >Sort by: </label>
                    <select name="sort" class=" p-1  form-control form-control">
                        <option value="{{$data['search']}}" selected disabled hidden>{{$search}}</option>
                        <option value="name">Name</option>
                        <option value="dob">Age</option>
                    </select>
                    
                    <label for="orderActors" class="p-2"> order: </label>
                    <select placeholder="{{$order}}" name="order" class="p-1  form-control form-control">
                        <option value="{{$data['order']}}" selected disabled hidden>{{$order}}</option>
                        <option value="desc">Descending</option>
                        <option value="asc">Ascending</option>
                    </select>
                    
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary pl-3 pr-3">Sort</button>
                    </div>
                </form>
            </div>    
            <div style="clear:both;"></div>
            @foreach($actors as $actor)
                <div class="card p-3 mb-3">
                    <div class="d-flex">
                        <div class="p-2 bd-highlight">
                            <img src="{{$actor->image}}" style="width:180px;float:left;" alt="Actor poster for {{$actor->name}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class=" bd-highlight">
                                    <h1 class="p-0" style="clear:both;">
                                        <a href="/actors/{{$actor->id}}" style="font-size:60%" >{{$actor->name}}</a>
                                    </h1>
                                </div>
                                <div class=" bd-highlight">
                                    <span style="font-size:120%;">{{date('F dS, Y', strtotime($actor->dob))}}</span>
                                    @if($actor->dod)
                                        <span> - {{$actor->dod}} </span>
                                    @endif
                                </div>
                                <div class=" bd-highlight">
                                    <p class="mt-3" >
                                        {{$actor->info}}
                                    </p>
                                    @if (count($actor->movies)>1)
                                        <p> Movies: 
                                            @foreach ($actor->movies as $movie)
                                                @if ($loop->first)
                                                    <a href="/movies/{{$movie->id}}">{{$movie->name}}</a>
                                                @else
                                                    , <a href="/movies/{{$movie->id}}">{{$movie->name}}</a> 
                                                @endif
                                                @if ($loop->iteration == 5)
                                                    @break
                                                @endif
                                            @endforeach
                                        </p>
                                    @elseif (count($actor->movies)==1)
                                        <p> Movie:  
                                            @foreach ($actor->movies as $movie)
                                                <a href="/movies/{{$movie->id}}">{{$movie->name}}</a>
                                            @endforeach
                                        </p>
                                    @endif
                                    @if (count($actor->tvshows)>1)
                                        <p> TV Shows: 
                                            @foreach ($actor->tvshows as $tvshow)
                                                @if ($loop->first)
                                                    <a href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a>
                                                @else
                                                    , <a href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a> 
                                                @endif
                                                @if ($loop->iteration == 5)
                                                    @break
                                                @endif
                                            @endforeach
                                        </p>
                                    @elseif (count($actor->tvshows)==1) 
                                        <p> TV Show: 
                                            @foreach ($actor->tvshows as $tvshow)
                                                <a href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a>
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$actors->appends(request()->input())->links()}}
        </div>
    @else 
    <h1 class="mt-5 pl-5">No actors found</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

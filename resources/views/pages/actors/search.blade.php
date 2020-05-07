
@extends('layouts.app')
@section('content')
    <?php
        $actors = $data['actors'];
        $s = $data['s'];
    ?>
    @if(count($actors)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Search Actors for: "{{$s}}"</h1>
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
        </div>
    @else 
    <h1 class="mt-5 pl-5">No Actors found for: "{{$s}}"</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

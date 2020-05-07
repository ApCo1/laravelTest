@extends('layouts.app')
@section('content')
    @if(count($mwatchlaters)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="pb-2">Watch later Movies:</h1>
            @foreach($mwatchlaters as $mwatchlater)
            <div class="card p-3 mb-3">
                
                <div class="d-flex">
                    <div class="p-2 bd-highlight">
                        <img src="{{$mwatchlater->movie->image}}" style="width:180px;float:left;" alt="Movie poster for {{$mwatchlater->movie->name}}">
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class=" bd-highlight">
                                <h1 class="p-0" style="clear:both;">
                                    <a href="/movies/{{$mwatchlater->movie->id}}" style="font-size:60%" >{{$mwatchlater->movie->name}}</a>
                                </h1>
                            </div>
                            <div class=" bd-highlight">
                                <span style="font-size:120%;"> ({{$mwatchlater->movie->year_of_release}})</span>
                                <span> - {{$mwatchlater->movie->duration}} min </span>
                                <span style="font-size:70%;">
                                    @foreach ($mwatchlater->movie->mgenres as $mgenre)
                                        @if ($loop->last)
                                            {{$mgenre->genre}}
                                        @else
                                            {{$mgenre->genre}}, 
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                            <div class=" bd-highlight">
                                <span style="font-size:120%;">{{$mwatchlater->movie->rating}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{$mwatchlater->movie->no_reviews}} reviews</span>
                            </div>
                            <div class=" bd-highlight">
                                <p class="mt-1 mb-2" >
                                    {{$mwatchlater->movie->info}}
                                </p>
                                <p style="margin:0;padding:0;">
                                    @if(count($mwatchlater->movie->directors)>1)
                                        Directors:
                                        @foreach ($mwatchlater->movie->directors as $director)
                                            @if ($loop->last)
                                                <a href="/directors/{{$director->id}}">{{$director->name}}</a>
                                            @else
                                                <a href="/directors/{{$director->id}}">{{$director->name}}</a>, 
                                            @endif
                                        @endforeach
                                    @else 
                                        Director:
                                        @foreach ($mwatchlater->movie->directors as $director)
                                                <a href="/directors/{{$director->id}}">{{$director->name}}</a>
                                        @endforeach
                                    @endif
                                </p>
                                <p> Stars: 
                                    @foreach ($mwatchlater->movie->actors as $actor)
                                        @if ($loop->last)
                                            <a href="/actors/{{$actor->id}}">{{$actor->name}}</a>
                                        @else
                                            <a href="/actors/{{$actor->id}}">{{$actor->name}}</a>, 
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user())
                    <form method="POST" action="{{route('mwlremove')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="movieid" value="{{$mwatchlater->movie->id}}">
                        <div class="pl-2 pb-1">
                            <button type="submit" style="float:right;" class="btn btn-primary">Remove form watchlater</button>
                        </div>
                    </form>
                @endif
            </div>
            @endforeach
            
        </div>
    @else 
        <h1 class="mt-5 pl-5">No movies found</h1>
    @endif
@endsection


@section('footer')
@include('inc.footer')
@endsection 
@extends('layouts.app')
@section('content')
    @if(count($twatchlaters)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="pb-2">Watch later Movies:</h1>
            @foreach($twatchlaters as $twatchlater)
            <div class="card p-3 mb-3">
                
                <div class="d-flex">
                    <div class="p-2 bd-highlight">
                        <img src="{{$twatchlater->tvshow->image}}" style="width:180px;float:left;" alt="Movie poster for {{$twatchlater->tvshow->name}}">
                    </div>
                    <div class="p-2 bd-highlight">
                        <div class="d-flex flex-column bd-highlight mb-3">
                            <div class=" bd-highlight">
                                <h1 class="p-0" style="clear:both;">
                                    <a href="/tvshows/{{$twatchlater->tvshow->id}}" style="font-size:60%" >{{$twatchlater->tvshow->name}}</a>
                                </h1>
                            </div>
                            <div class=" bd-highlight">
                                <span style="font-size:120%;"> ({{$twatchlater->tvshow->year_of_release}})</span>
                                <span> - {{$twatchlater->tvshow->duration}} min </span>
                                <span style="font-size:70%;">
                                    @foreach ($twatchlater->tvshow->tgenres as $tgenre)
                                        @if ($loop->last)
                                            {{$tgenre->genre}}
                                        @else
                                            {{$tgenre->genre}}, 
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                            <div class=" bd-highlight">
                                <span style="font-size:120%;">{{$twatchlater->tvshow->rating}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{$twatchlater->tvshow->no_reviews}} reviews</span>
                            </div>
                            <div class=" bd-highlight">
                                <p class="mt-1 mb-2" >
                                    {{$twatchlater->tvshow->info}}
                                </p>
                                <p style="margin:0;padding:0;">
                                    @if(count($twatchlater->tvshow->creators)>1)
                                        Directors:
                                        @foreach ($twatchlater->tvshow->creators as $creator)
                                            @if ($loop->last)
                                                <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>
                                            @else
                                                <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>, 
                                            @endif
                                        @endforeach
                                    @else 
                                        Director:
                                        @foreach ($twatchlater->tvshow->creators as $creator)
                                                <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>
                                        @endforeach
                                    @endif
                                </p>
                                <p> Stars: 
                                    @foreach ($twatchlater->tvshow->actors as $actor)
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
                    <form method="POST" action="{{route('twlremove')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="tvshowid" value="{{$twatchlater->tvshow->id}}">
                        <div class="pl-2 pb-1">
                            <button type="submit" style="float:right;" class="btn btn-primary">Remove form watchlater</button>
                        </div>
                    </form>
                @endif
            </div>
            @endforeach
            
        </div>
    @else 
        <h1 class="mt-5 pl-5">No tvshows found</h1>
    @endif
@endsection


@section('footer')
@include('inc.footer')
@endsection 
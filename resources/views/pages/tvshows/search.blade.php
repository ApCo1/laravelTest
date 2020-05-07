
@extends('layouts.app')
@section('content')
    <?php
        $tvshows = $data['tvshows'];
        $s = $data['s'];
    ?>
    @if(count($tvshows)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Search TV Shows for: "{{$s}}"</h1>  
            <div style="clear:both;"></div>
            @foreach($tvshows as $tvshow)
                <div class="card p-3 mb-3">
                    <div class="d-flex">
                        <div class="p-2 bd-highlight">
                            <img src="{{$tvshow->image}}" style="width:180px;float:left;" alt="Movie poster for {{$tvshow->name}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class=" bd-highlight">
                                    <h1 class="p-0" style="clear:both;">
                                        <a href="/tvshows/{{$tvshow->id}}" style="font-size:60%" >{{$tvshow->name}}</a>
                                    </h1>
                                </div>
                                <div class=" bd-highlight">
                                    <span style="font-size:90%;">
                                        @foreach ($tvshow->tgenres as $tgenre)
                                            @if ($loop->last)
                                                {{$tgenre->genre}}
                                            @else
                                                {{$tgenre->genre}}, 
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                                <div class=" bd-highlight">
                                    <span style="font-size:120%;"> ( {{$tvshow->year_of_release}}
                                        @if( $tvshow->year_of_release == $tvshow->year_of_end )
                                            )</span>  
                                        @else
                                            - {{$tvshow->year_of_end}} )</span>
                                        @endif
                                    <span> - approx. {{$tvshow->duration}} min/ep</span> In total : {{$tvshow->total_watchtime}}
                                </div>
                                
                                <div class=" bd-highlight">
                                    <span style="font-size:120%;">{{$tvshow->treviews->avg('rating')}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{count($tvshow->treviews)}} reviews</span>
                                </div>
                                <div class=" bd-highlight">
                                    <p class="mt-3" >
                                        {{$tvshow->info}}
                                    </p>
                                    <p>
                                        @if(count($tvshow->creators)>1)
                                            Creators:
                                            @foreach ($tvshow->creators as $creator)
                                                @if ($loop->last)
                                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>
                                                @else
                                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>, 
                                                @endif
                                            @endforeach
                                        @else 
                                            Creator:
                                            @foreach ($tvshow->creators as $creator)
                                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>
                                            @endforeach
                                        @endif
                                    </p>
                                    <p> Stars: 
                                        @foreach ($tvshow->actors as $actor)
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
                </div>
            @endforeach
        </div>
    @else 
    <h1 class="mt-5 pl-5">No TV Shows found for: "{{$s}}"</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

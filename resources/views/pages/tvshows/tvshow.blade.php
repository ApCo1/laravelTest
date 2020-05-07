@extends('layouts.app')
@section('content')
    @isset($tvshow)
        <div class="card p-3 mb-3">
            <div class="d-flex">
                <div class="p-2 bd-highlight">
                    <img src="{{$tvshow->image}}" style="width:180px;float:left;" alt="Movie poster for {{$tvshow->name}}">
                </div>
                <div class="p-2 bd-highlight">
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class=" bd-highlight">
                            <h1 class="p-0" style="clear:both;">
                                {{$tvshow->name}}
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
                            <span style="font-size:120%;">{{$tvshow->rating}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{$tvshow->no_reviews}} reviews</span>
                        </div>
                        @if (Auth::user())
                            <div class=" bd-highlight">
                                <form class="form-inline" method="POST" action="{{ route('treview.store') }}">
                                    @csrf
                                    <label for="TVShowReview" class="p-2" >Rate: </label>
                                    <select name="review" class="form-control">
                                        <option value='0'>0</option>
                                        <option value='1'>1</option>
                                        <option value='2'>2</option>
                                        <option value='3'>3</option>
                                        <option value='4'>4</option>
                                        <option value='5'>5</option>
                                        <option value='6'>6</option>
                                        <option value='7'>7</option>
                                        <option value='8'>8</option>
                                        <option value='9'>9</option>
                                        <option value='10'>10</option>
                                    </select>
                                    <?php 
                                        $user = auth()->user();
                                        $id1 = $user->id;
                                        $id2 = $tvshow->id;
                                    ?>
                                    <input type="hidden" name="tvshowid" value="{{$tvshow->id}}">
                                    <input type="hidden" name="url" value="{{Request::url()}}">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Rate</button>
                                    </div>
                                    @foreach($tvshow->treviews as $treview)
                                        @if($treview->user_id == $id1 AND $treview->tvshow_id == $id2)
                                            <div class="col-auto" style="padding:0;">
                                                Your review: {{$treview->rating}}
                                            </div>
                                        @endif
                                    @endforeach
                                </form>
                            </div>
                        @endif
                        <div class=" bd-highlight">
                            <p class="mt-1 mb-2" >
                                {{$tvshow->info}}
                            </p>
                            <p style="margin:0;padding:0;">
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
            @if (Auth::user())
                <?php
                    $user = Auth::user();
                    $yes = 0;
                    foreach($user->twatchlaters as $twatchlater){
                        if($twatchlater->tvshow_id == $tvshow->id){
                            $yes = 1;
                            break;
                        }else{
                            $yes = 0;
                        }
                    }
                ?>
                @if($yes == 0)
                    <form method="POST" class="pb-2" action="{{ route('twatchlater.store') }}">
                        <input type="hidden" name="tvshowid" value="{{$tvshow->id}}">
                        <input type="hidden" name="url" value="{{Request::url()}}">
                        @csrf
                        <div class="pr-2">
                            <button type="submit" style="float:right;" class="btn btn-primary">Add to watchlater</button>
                        </div>
                    </form>
                @else 
                    <form method="POST" class="pb-2" action="{{route('twlremove')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="tvshowid" value="{{$tvshow->id}}">
                        <div class="pr-2">
                            <button type="submit" style="float:right;" class="btn btn-primary">Remove form watchlater</button>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    @endisset
    @empty($tvshow)
        <div class="card p-3 mb-3">
            <h1 class="mt-5 pl-5">No TV Shows found</h1>
        </div>
    @endempty

@endsection

@section('footer')
    @include('inc.footer')
@endsection
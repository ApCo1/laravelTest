@extends('layouts.app')
@section('content')
    @isset($movie)
        <div class="card pl-3 pt-3 mb-3 pb-0">
            <div class="d-flex">
                <div class="p-2 bd-highlight">
                    <img src="{{$movie->image}}" style="width:180px;float:left;" alt="Movie poster for {{$movie->name}}">
                </div>
                <div class="p-2 bd-highlight">
                    <div class="d-flex flex-column bd-highlight">
                        <div class="bd-highlight">
                            <h1 style="clear:both;margin:0;padding:0;">
                                {{$movie->name}} <span style="font-size:50%;">
                                @foreach ($movie->mgenres as $mgenre)
                                    @if ($loop->last)
                                        {{$mgenre->genre}}
                                    @else
                                        {{$mgenre->genre}}, 
                                    @endif
                                @endforeach
                                </span>
                            </h1>
                        </div>
                        <div class=" bd-highlight">
                            <span style="font-size:120%;"> ({{$movie->year_of_release}})</span>
                            <span> - {{$movie->duration}} min</span>
                        </div>
                        <div class=" bd-highlight">
                            <span style="font-size:120%;">{{$movie->rating}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{$movie->no_reviews}} reviews</span>
                        </div>
                        @if (Auth::user())
                            <div class=" bd-highlight">
                                <form class="form-inline" method="POST" action="{{ route('mreview.store') }}">
                                    @csrf
                                    <?php
                                        $user = auth()->user();
                                        $id1 = $user->id;
                                        $id2 = $movie->id;
                                        $true = false;
                                        foreach ($movie->mreviews as $mreview){
                                            if($mreview->user_id == $id1 AND $mreview->movie_id == $id2){
                                                $true = true;
                                                $m = $mreview;
                                            }
                                        }
                                    ?>
                                    @if($true)
                                        <select name="review" class="form-control">
                                            <option selected disabled hidden>{{$m->rating}}</option>
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
                                    @else
                                        <select name="review" class="form-control">
                                            <option selected disabled hidden>Rate</option>
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
                                    @endif
                                    <input type="hidden" name="movieid" value="{{$movie->id}}">
                                    <input type="hidden" name="url" value="{{Request::url()}}">
                                    <div class="col-auto">
                                        <button name="rate" type="submit" class="btn btn-primary">Rate</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        <div class=" bd-highlight" >
                            <p class="mt-1 mb-2" >
                                {{$movie->info}}
                            </p>
                            <p style="margin:0;padding:0;">
                                @if(count($movie->directors)>1)
                                    Directors:
                                    @foreach ($movie->directors as $director)
                                        @if ($loop->last)
                                            <a href="/directors/{{$director->id}}">{{$director->name}}</a>
                                        @else
                                            <a href="/directors/{{$director->id}}">{{$director->name}}</a>, 
                                        @endif
                                    @endforeach
                                @else 
                                    Director:
                                    @foreach ($movie->directors as $director)
                                            <a href="/directors/{{$director->id}}">{{$director->name}}</a>
                                    @endforeach
                                @endif
                            </p>
                            <p> Stars: 
                                @foreach ($movie->actors as $actor)
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
                    foreach($user->mwatchlaters as $mwatchlater){
                        if($mwatchlater->movie_id == $movie->id){
                            $yes = 1;
                            break;
                        }else{
                            $yes = 0;
                        }
                    }
                ?>
                @if($yes == 0)
                    <form method="POST" class="pb-2" action="{{ route('mwatchlater.store') }}">
                        <input type="hidden" name="movieid" value="{{$movie->id}}">
                        <input type="hidden" name="url" value="{{Request::url()}}">
                        @csrf
                        <div class="pr-2">
                            <button type="submit" style="float:right;" class="btn btn-primary">Add to watchlater</button>
                        </div>
                    </form>
                @else 
                    <form method="POST" class="pb-2" action="{{route('mwlremove')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="movieid" value="{{$movie->id}}">
                        <div class="pr-2">
                            <button type="submit" style="float:right;" class="btn btn-primary">Remove form watchlater</button>
                        </div>
                    </form>
                @endif
            @endif
        </div>
    @endisset
    @empty($movie)
        <div class="card p-3 mb-3">
            <h1 class="mt-5 pl-5">No movies found</h1>
        </div>
    @endempty

@endsection

@section('footer')
    @include('inc.footer')
@endsection  
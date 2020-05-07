
@extends('layouts.app')
@section('content')
    <?php 
        $movies = $data['movies']; 
        switch ($data['search']) {
            case 'title':
                $search = 'Title';
                break;
            case 'year_of_release':
                $search = 'Years';
                break;
            case 'rating':
                $search = 'Rating';
                break;
            case 'duration':
                $search = 'Duration';
                break;
            default: 
                $search = 'Title';
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
    @if(count($movies)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Movies:</h1>
            <div class="float-right pt-4">
                <form class="form-inline" method="post" action="movies_sorted">
                    {{ csrf_field() }}
                    <label for="sortMovies" class="p-2" >Sort by: </label>
                    <select name="sort" class=" p-1  form-control form-control">
                        <option value="{{$data['search']}}" selected disabled hidden>{{$search}}</option>
                        <option value="rating">Rating</option>
                        <option value="title">Titles</option>
                        <option value="year_of_release">Years</option>
                        <option value="duration">Durations</option>
                    </select>
                    
                    <label for="orderMovies" class="p-2"> order: </label>
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
            @foreach($movies as $movie)
                <div class="card p-3 mb-3">
                    <div class="d-flex">
                        <div class="p-2 bd-highlight">
                            <img src="{{$movie->image}}" style="width:180px;float:left;" alt="Movie poster for {{$movie->name}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class=" bd-highlight">
                                    <h1 class="p-0" style="clear:both;">
                                        <a href="/movies/{{$movie->id}}" style="font-size:60%" >{{$movie->name}}</a>
                                    </h1>
                                </div>
                                <div class=" bd-highlight">
                                    <span style="font-size:120%;"> ({{$movie->year_of_release}})</span>
                                    <span> - {{$movie->duration}} min </span>
                                    <span style="font-size:70%;">
                                        @foreach ($movie->mgenres as $mgenre)
                                            @if ($loop->last)
                                                {{$mgenre->genre}}
                                            @else
                                                {{$mgenre->genre}}, 
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                                <div class=" bd-highlight">
                                    <span style="font-size:120%;">{{$movie->rating}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{$movie->no_reviews}} reviews</span>
                                </div>
                                <div class=" bd-highlight">
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
            @endforeach
            {{$movies->appends(request()->input())->links()}}
        </div>
    @else 
    <h1 class="mt-5 pl-5">No movies found</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

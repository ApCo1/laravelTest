
@extends('layouts.app')
@section('content')
    <?php
        $movies = $data['movies'];
        $s = $data['s'];
    ?>
    @if(count($movies)>0)
    <div class="container p-3" style="min-width:720px;">
        <h1 class="float-left pb-2">Search Movies for: "{{$s}}"</h1>
        <div class="float-right pt-4">
            <form class="form-inline" method="post" action="movies_sorted">
                {{ csrf_field() }}
                <label for="sortMovies" class="p-2" >Sort by: </label>
                <select name="sort" class=" p-1  form-control form-control">
                    <option value="" disabled selected>Select</option>
                    <option value="rating">Rating</option>
                    <option value="title">Titles</option>
                    <option value="year_of_release">Years</option>
                    <option value="duration">Durations</option>
                </select>
                
                <label for="orderMovies" class="p-2"> order: </label>
                <select name="order" class="p-1  form-control form-control">
                    <option value="" disabled selected>Select</option>
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
                                <span> - {{$movie->duration}} min</span>
                            </div>
                            <div class=" bd-highlight">
                                <span style="font-size:120%;">{{$movie->rating}}</span><span style="font-size:90%;">/10</span><span style="font-size:100%;"> Based on: {{$movie->no_reviews}} reviews</span>
                            </div>
                            <div class=" bd-highlight">
                                <p class="mt-3" >
                                    {{$movie->info}}
                                </p>
                                <p>
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
            </div>
        @endforeach
    </div>
    @else 
    <h1 class="mt-5 pl-5">No Movies found for: "{{$s}}"</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

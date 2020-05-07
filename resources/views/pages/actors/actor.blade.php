@extends('layouts.app')
@section('content')
    @isset($actor)
        <div class="card p-3 mb-3">
            <div class="d-flex">
                <div class="p-2 bd-highlight">
                    <img src="{{$actor->image}}" style="width:180px;float:left;" alt="Actor poster for {{$actor->name}}">
                </div>
                <div class="p-2 bd-highlight">
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class=" bd-highlight">
                            <h1 class="p-0" style="clear:both;">
                                {{$actor->name}}
                            </h1>
                        </div>
                        <div class=" bd-highlight">
                            <span style="font-size:120%;">{{date('F dS, Y', strtotime($actor->dob))}}</span>
                            @if($actor->dod)
                                <span> - {{$actor->dod}} </span>
                            @endif
                        </div>
                        <div class=" bd-highlight">
                            <p style="font-size:130%" class="mt-3" >
                                {{$actor->info}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($actor->movies)>0)
                <table class="table table-striped table-dark pt-3 mt-3 ml-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Movie</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actor->movies as $movie)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td><a style="color:#BFBFF7" href="/movies/{{$movie->id}}">{{$movie->name}}</a></td>
                                <td>{{$movie->pivot->character}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            @if (count($actor->tvshows)>0)
                <table class="table table-striped table-dark pt-3 mt-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">TV Show</th>
                            <th scope="col">Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($actor->tvshows as $tvshow)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td><a href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a></td>
                                <td>{{$tvshow->pivot->character}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endisset

    @empty($actor)
        <div class="card p-3 mb-3">
            <h1 class="mt-5 pl-5">No actors found</h1>
        </div>
    @endempty

@endsection

@section('footer')
    @include('inc.footer')
@endsection
@extends('layouts.app')
@section('content')
    @isset($creator)
        <div class="card p-3 mb-3">
            <div class="d-flex">
                <div class="p-2 bd-highlight">
                    <img src="{{$creator->image}}" style="width:180px;float:left;" alt="Creator poster for {{$creator->name}}">
                </div>
                <div class="p-2 bd-highlight">
                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class=" bd-highlight">
                            <h1 class="p-0" style="clear:both;">
                                {{$creator->name}}
                            </h1>
                        </div>
                        <div class=" bd-highlight">
                            <span style="font-size:120%;">{{date('F dS, Y', strtotime($creator->dob))}}</span>
                            @if($creator->dod)
                                <span> - {{$creator->dod}} </span>
                            @endif
                        </div>
                        <div class=" bd-highlight">
                            <span style="font-size:120%;">{{$creator->rating}}</span><span style="font-size:90%;">/10</span>
                        </div>
                        <div class=" bd-highlight">
                            <p style="font-size:130%" class="mt-3" >
                                {{$creator->info}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($creator->tvshows)>0)
                <table class="table table-striped table-dark pt-3 mt-3 ml-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">TV Show</th>
                            <th scope="col">Rating</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($creator->tvshows as $tvshow)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td><a style="color:#BFBFF7" href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a></td>
                                <td>{{$tvshow->rating}}/10</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @endisset

    @empty($creator)
        <div class="card p-3 mb-3">
            <h1 class="mt-5 pl-5">No creators found</h1>
        </div>
    @endempty

@endsection

@section('footer')
    @include('inc.footer')
@endsection
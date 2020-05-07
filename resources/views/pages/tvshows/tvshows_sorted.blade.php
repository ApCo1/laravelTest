
@extends('layouts.app')
@section('content')
    <?php 
        $tvshows = $data['tvshows']; 
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
    @if(count($tvshows)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">TV Shows:</h1>
            <div class="float-right pt-4">
                <form class="form-inline" method="post" action="tvshows_sorted">
                    {{ csrf_field() }}
                    <label for="sortTVShows" class="p-2" >Sort by: </label>
                    <select name="sort" class=" p-1  form-control form-control">
                        <option value="{{$data['search']}}" selected disabled hidden>{{$search}}</option>
                        <option value="rating">Rating</option>
                        <option value="title">Titles</option>
                        <option value="year_of_release">Years</option>
                        <option value="duration">Durations</option>
                    </select>
                    
                    <label for="orderTVShows" class="p-2"> order: </label>
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
            @endforeach
            {{$tvshows->appends(request()->input())->links()}}
        </div>
    @else 
    <h1 class="mt-5 pl-5">No TV Shows found</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

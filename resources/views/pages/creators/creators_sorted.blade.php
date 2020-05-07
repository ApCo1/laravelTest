@extends('layouts.app')
@section('content')
    <?php 
        $creators = $data['creators']; 
        switch ($data['search']) {
            case 'name':
                $search = 'Name';
                break;
            case 'dob':
                $search = 'Age';
                break;
            case 'rating':
                $search = 'Rating';
                break;
            default: 
                $search = 'Name';
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
    @if(count($creators)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Creators:</h1>
            <div class="float-right pt-4">
                <form class="form-inline" method="post" action="creators_sorted">
                    {{ csrf_field() }}
                    <label for="sortCreators" class="p-2" >Sort by: </label>
                    <select name="sort" class=" p-1  form-control form-control">
                        <option value="{{$data['search']}}" disabled selected>{{$search}}</option>
                        <option value="rating">Rating</option>
                        <option value="name">Name</option>
                        <option value="dob">Age</option>
                    </select>
                    
                    <label for="orderCreators" class="p-2"> order: </label>
                    <select placeholder="{{$order}}" name="order" class="p-1  form-control form-control">
                        <option value="{{$data['order']}}" disabled selected>{{$order}}</option>
                        <option value="desc">Descending</option>
                        <option value="asc">Ascending</option>
                    </select>
                    
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary pl-3 pr-3">Sort</button>
                    </div>
                </form>
            </div>    
            <div style="clear:both;"></div>
            @foreach($creators as $creator)
                <div class="card p-3 mb-3">
                    <div class="d-flex">
                        <div class="p-2 bd-highlight">
                            <img src="{{$creator->image}}" style="width:180px;float:left;" alt="Creator poster for {{$creator->name}}">
                        </div>
                        <div class="p-2 bd-highlight">
                            <div class="d-flex flex-column bd-highlight mb-3">
                                <div class=" bd-highlight">
                                    <h1 class="p-0" style="clear:both;">
                                        <a href="/creators/{{$creator->id}}" style="font-size:60%" >{{$creator->name}}</a>
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
                                    <p class="mt-3" >
                                        {{$creator->info}}
                                    </p>
                                    @if (count($creator->tvshows)>0)
                                        <p> Movies: 
                                            @foreach ($creator->tvshows as $tvshow)
                                                @if ($loop->first)
                                                    <a href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a>
                                                @else
                                                    , <a href="/tvshows/{{$tvshow->id}}">{{$tvshow->name}}</a> 
                                                @endif
                                                @if ($loop->iteration == 5)
                                                    @break
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{$creators->appends(request()->input())->links()}}
        </div>
    @else 
    <h1 class="mt-5 pl-5">No creators found</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

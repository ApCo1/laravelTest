@extends('layouts.app')
@section('content')
<?php
    $temp = auth()->user();
    $temp2 = $mreviews->first();
?>
<div class="container p-3" style="min-width:720px;"> 
    <div style="clear:both;"></div>
    @if(count($mreviews)>0)
        @if($temp->id == $temp2->user_id)
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Movie reviews</th>
                        <th scope="col">Year of release</th>
                        <th scope="col">Director /s</th>
                        <th colspan="2" scope="col">Your review</th>
                    </tr>
                </thead>
                @foreach ($mreviews as $mreview)
                <tbody>
                    <tr class="table-info">
                        <td><a  href="/movies/{{$mreview->movie->id}}">{{$mreview->movie->name}}</a></td>
                        <td>{{$mreview->movie->rating}}</td>
                        <td>{{$mreview->movie->no_reviews}}</td>
                        <td>{{$mreview->movie->year_of_release}}</td>
                        <td>
                            @foreach ($mreview->movie->directors as $director)
                                @if ($loop->last)
                                    <a href="/directors/{{$director->id}}">{{$director->name}}</a>
                                @else
                                    <a href="/directors/{{$director->id}}">{{$director->name}}</a>, 
                                @endif
                            @endforeach    
                        </td>
                        <form method="POST" action="{{ route('mreview.store') }}">
                            @csrf
                            <input type="hidden" name="movieid" value="{{$mreview->movie->id}}">
                        <td>
                            <select name="review" class="form-control pl-2 mr-3">
                                <option selected disabled hidden>{{$mreview->rating}}</option>
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
                        </td>
                        <td class="pl-0 ml-0">
                            <button name="rate" type="submit" class="btn btn-primary">Change</button>
                        </td>
                        </form>
                    </tr>
                </tbody> 
                @endforeach
            </table>
        @else 
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Year of release</th>
                        <th scope="col">Director/s</th>
                        <th scope="col">User review</th>
                    </tr>
                </thead>
                @foreach ($mreviews as $mreview)
                <tbody>
                    <tr class="table-info">
                        <td><a href="/movies/{{$mreview->movie->id}}">{{$mreview->movie->name}}</a></td>
                        <td>{{$mreview->movie->rating}}</td>
                        <td>{{$mreview->movie->year_of_release}}</td>
                        <td>
                            @foreach ($mreview->movie->directors as $director)
                                @if ($loop->last)
                                    <a href="/directors/{{$director->id}}">{{$director->name}}</a>
                                @else
                                    <a href="/directors/{{$director->id}}">{{$director->name}}</a>, 
                                @endif
                            @endforeach    
                        </td>
                        <td>{{$mreview->rating}}</td>
                    </tr>
                </tbody> 
                @endforeach
            </table>
        @endif
    @else 
        <h1 class="p-3 m-3">No Reviews Yet</h1>
    @endif
</div>

@endsection

@section('footer')
    @include('inc.footer')
@endsection
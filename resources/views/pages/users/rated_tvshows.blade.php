@extends('layouts.app')
@section('content')
<?php
    $temp = auth()->user();
    $temp2 = $treviews->first();
?>
<div class="container p-3" style="min-width:720px;"> 
    <div style="clear:both;"></div>
    @if(count($treviews)>0)
        @if($temp->id == $temp2->user_id)
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Run-time</th>
                        <th scope="col">Creator /s</th>
                        <th colspan="2" scope="col">Your review</th>
                    </tr>
                </thead>
                @foreach ($treviews as $treview)
                <tbody>
                    <tr class="table-info">
                        <td><a  href="/tvshows/{{$treview->tvshow->id}}">{{$treview->tvshow->name}}</a></td>
                        <td>{{$treview->tvshow->rating}}</td>
                        <td>{{$treview->tvshow->year_of_release}} - @if($treview->tvshow->year_of_end){{$treview->tvshow->year_of_end}} @endif</td>
                        <td>
                            @foreach ($treview->tvshow->creators as $creator)
                                @if ($loop->last)
                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>
                                @else
                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>, 
                                @endif
                            @endforeach    
                        </td>
                        <form method="POST" action="{{ route('treview.store') }}">
                            @csrf
                            <input type="hidden" name="tvshowid" value="{{$treview->tvshow->id}}">
                        <td>
                            <select name="review" class="form-control pl-2 mr-3">
                                <option selected disabled hidden>{{$treview->rating}}</option>
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
                        <th scope="col">Run-time</th>
                        <th scope="col">Creator /s</th>
                        <th scope="col">User review</th>
                    </tr>
                </thead>
                @foreach ($treviews as $treview)
                <tbody>
                    <tr class="table-info">
                        <td><a href="/tvshows/{{$treview->tvshow->id}}">{{$treview->tvshow->name}}</a></td>
                        <td>{{$treview->tvshow->rating}}</td>
                        <td>{{$treview->tvshow->year_of_release}}</td>
                        <td>
                            @foreach ($treview->tvshow->creators as $creator)
                                @if ($loop->last)
                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>
                                @else
                                    <a href="/creators/{{$creator->id}}">{{$creator->name}}</a>, 
                                @endif
                            @endforeach    
                        </td>
                        <td>{{$treview->rating}}</td>
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
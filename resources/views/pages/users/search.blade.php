@extends('layouts.app')
@section('content')
    <?php
        $users = $data['users'];
        $s = $data['s'];
    ?>
    @if(count($users)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Search Users for: "{{$s}}"</h1> 
            <div style="clear:both;"></div>
            
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Level</th>
                        <th scope="col">Name</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Movie reviews</th>
                        <th scope="col">Avrg. review</th>
                        <th scope="col">TV Show reviews</th>
                        <th scope="col">Avrg. review</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Delete</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr class="table-info">
                        <td scope='row'>{{$user->level}}</td>
                        <td><a href="{{route('users.show', ['id' => $user->id])}}">{{$user->name}}</a></td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->movie_reviews}}</td>
                        <td>{{$user->average_mreviews}}</td>
                        <td>{{$user->tvshow_reviews}}</td>
                        <td>{{$user->average_treviews}}</td>
                        <td class="p-1">
                            <a href="{{route('users.edit', ['id' => $user->id])}}"><button name="editUser"  class="btn btn-primary">Edit</button></a>
                        </td>
                        <td class="p-1">
                            <a href="{{route('users.delete', ['id' => $user->id])}}">
                                <button name="deleteUser" type="submit" class="btn btn-primary">Delete</button>
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else 
    <h1 class="mt-5 pl-5">No Users found for: "{{$s}}"</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

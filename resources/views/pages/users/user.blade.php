@extends('layouts.app')
@section('content')
    <?php
        $temp = auth()->user();
        $what = 0;
        switch($temp->level){
            case 'ultraadmin':
                if($user->level == 'ultraadmin'){
                    $what = 1;
                }
            break;
            case 'admin':
                if($user->level == 'admin' or $user->level == 'ultraadmin'){
                    $what = 1;
                } 
            break;
            default: 
                $what = 1;
        }
    ?>
    @if($what == 0)
        <div class="container p-3" style="min-width:720px;"> 
            <div style="clear:both;"></div>
            @isset($user)
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
                        <tr class="table-info">
                            <td scope='row'>{{$user->level}}</td>
                            <td> {{$user->name}} </td>
                            <td> {{$user->email}} </td>
                            <td> {{$user->movie_reviews}} </td>
                            <td> @if($user->average_mreviews){{$user->average_mreviews}} @else N/A @endif</td>
                            <td> {{$user->tvshow_reviews}} </td>
                            <td> @if($user->average_treviews){{$user->average_treviews}} @else N/A @endif</td>
                            <td class="p-1">
                                <a class="btn btn-primary" href="{{route('users.edit', ['id' => $user->id])}}">Edit</a>
                            </td>
                            <td class="p-1">
                                <a href="{{route('users.delete', ['id' => $user->id])}}">
                                    <button name="deleteUser" type="submit" class="btn btn-primary">Delete</button>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endisset
        </div>
    @else
        <h1 class="p-5 m-5">ACCES DENIED</h1>
    @endif
                
    
@endsection

@section('footer')
    @include('inc.footer')
@endsection
@extends('layouts.app')
@section('content')
    <?php
        $temp = auth()->user();
        $what = 0;
        if(!$temp){
            $what = 1;
        }else{
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
        }
    ?>
    @if($what == 0)
        @isset($user)
            <h1>EDIT USER:</h1>
            <form action="{{route('users.update')}}" method="post">
                {{ csrf_field() }}
                <div class="form-inline pt-3">
                    <label class="pr-3">Change User's name:</label><br>
                    <input class="mr-4" name="name" type="text" value="{{$user->name}}"><br>
                    <label class="p-2" >Change level: </label>
                    <select name="lvl" class=" p-1  form-control form-control">
                        @if($user->level == 'user')
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                        @else 
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                            <option value="editor">Editor</option>
                        @endif
                    </select>
                    <div class="col-auto" >
                        <button type="submit" class="btn btn-primary m-3">Finish Editing</button>
                    </div>
                </div>
                <input type="hidden" name="id" value="{{$user->id}}">
            </form>
            
            <hr style="clear:both">
            <div class="pt-3">
                <form class="form-inline my-2 my-md-0" action="{{route('delete_mreview')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-auto">
                        <button name="delete_movies" type="submit" class="btn btn-primary">Delete all of {{$user->name}}'s Movie reviews</button>
                        <input type="hidden" name="muser" value="{{$user->id}}">
                    </div>
                </form>
            </div>
            <div class="pt-3">
                <form class="form-inline my-2 my-md-0" action="{{route('delete_treview')}}" method="POST">
                    {{ csrf_field() }}
                    <div class="col-auto">
                        <button name="delete_tvshows" type="submit" class="btn btn-primary">Delete all of {{$user->name}}'s TV Show reviews</button>
                        <input type="hidden" name="tuser" value="{{$user->id}}">
                    </div>
                </form>
            </div>
            <div class="pt-3 pl-3">
                <a href="{{route('users.show', ['id' => $user->id])}}" class="btn btn-primary ">Go back to {{$user->name}}</a>
            </div>
        @endisset
    @else
        <h1 class="p-5 m-5">ACCES DENIED</h1>
    @endif
    
@endsection
@section('footer')
    @include('inc.footer')
@endsection
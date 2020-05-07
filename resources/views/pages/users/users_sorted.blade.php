
@extends('layouts.app')
@section('content')
    <?php 
        $users = $data['users']; 
        switch ($data['search']) {
            case 'name':
                $search = 'Name';
                break;
            case 'id':
                $search = 'ID';
                break;
            case 'mreviews':
                $search = 'Number of Movie reviews';
                break;
            case 'treviews':
                $search = 'Average Movie review';
                break;
            case 'averagemreviews':
                $search = 'Number of TV Show reviews';
                break;
            case 'averagetreviews':
                $search = 'Average TV Show review';
                break;
            default: 
                $search = 'ID';
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
    @if(count($users)>0)
        <div class="container p-3" style="min-width:720px;">
            <h1 class="float-left pb-2">Users:</h1>
            <div class="float-right pt-4">
                <form class="form-inline" method="post" action="users_sorted">
                    {{ csrf_field() }}
                    <label for="sortUsers" class="p-2" >Sort by: </label>
                    <select name="sort" class=" p-1  form-control form-control">
                        <option value="{{$data['search']}}" disabled selected>{{$search}}</option>
                        <option value="id">ID</option>
                        <option value="name">Name</option>
                        <option value="mreviews">Number of Movie reviews</option>
                        <option value="averagemreviews">Average Movie review</option>
                        <option value="treviews">Number of TV Show reviews</option>
                        <option value="averagetreviews">Average TV Show review</option>
                    </select>
                    
                    <label for="orderUsers" class="p-2"> order: </label>
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
                <table class="table table-hover" id="myTable">
                    <thead class="thead-dark">
                        <tr>
                            <th >Level</th>
                            <th >Name</th>
                            <th >E-mail</th>
                            <th >Movie reviews</th>
                            <th >Avrg. review</th>
                            <th >TV Show reviews</th>
                            <th >Avrg. review</th>
                            <th >Edit</th>
                            <th >Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="table-info">
                                <td scope='row'>{{$user->level}}</td>
                                <td><a href="{{route('users.show', ['id' => $user->id])}}">{{$user->name}}</a></td>
                                <td> {{$user->email}} </td>
                                <td> {{$user->movie_reviews}} </td>
                                <td> @if($user->average_mreviews){{$user->average_mreviews}} @else N/A @endif</td>
                                <td> {{$user->tvshow_reviews}} </td>
                                <td> @if($user->average_treviews){{$user->average_treviews}} @else N/A @endif</td>
                                <td class="p-1">
                                    <a href="{{route('users.edit', ['id' => $user->id])}}">
                                        <button name="editUser" type="submit" class="btn btn-primary">Edit</button>
                                    </a>
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
                {{$users->appends(request()->input())->links()}}
            
        </div>
    @else 
    <h1 class="mt-5 pl-5">No users found</h1>
    @endif
@endsection


@section('footer')
    @include('inc.footer')
@endsection

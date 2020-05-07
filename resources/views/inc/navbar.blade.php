<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'IMDB') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
  
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
              <div class="navbar-nav">
                <a class="nav-item nav-link" href="/movies">Movies</a>
                <a class="nav-item nav-link" href="/tvshows">TV Shows</a>
                <a class="nav-item nav-link" href="/actors">Actors</a>
              </div>
            </ul>
  
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="pr-5 mr-5">
                        <form class="form-inline my-2 my-md-0" action="search" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select name="option" class="form-control" id="exampleFormControlSelect1">
                                    <option value="actors">Actors</option>
                                    <option value="movies">Movie Titles</option>
                                    <option value="tvshows">TV Show Titles</option>
                                </select>
                            </div>
                            <input name="s" class="form-control" type="text" placeholder="Search" pattern="[A-Za-z\s]{3,}">
                            <div class="col-auto">
                                <button name="searchbtn" type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                    
                    
                @else
                    <li class="pr-5 mr-5">
                        <form class="form-inline my-2 my-md-0" action="{{route('search')}}" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <select name="option" class="form-control" id="exampleFormControlSelect1">
                                    <option value="actors">Actors</option>
                                    <option value="movies">Movie Titles</option>
                                    <option value="tvshows">TV Show Titles</option>
                                    @if (Auth::user()->level == "admin")
                                        <option value="users">Users</option>
                                    @endif
                                    @if (Auth::user()->level=='ultraadmin')
                                        <option value="users">Users</option>
                                        <option value="admins">Admins</option>
                                    @endif
                                </select>
                            </div>
                            <input name="s" class="form-control" type="text" placeholder="Search" pattern="[A-Za-z\s]{3,}">
                            <div class="col-auto">
                                <button name="searchbtn" type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
  
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{route('mwatchlater.index')}}">Watach later Movies</a>
                            <a class="dropdown-item" href="{{route('twatchlater.index')}}">Watach later TV Shows</a>
                            <a class="dropdown-item" href="{{route('ratedMovies',['id' =>Auth::user()->id])}}">Rated movies</a>
                            <a class="dropdown-item" href="{{route('ratedTvShows',['id' =>Auth::user()->id])}}">Rated TV shows</a>
                            @if (Auth::user()->level == "admin")
                                <a class="dropdown-item" href="{{route('users_sorted')}}">All users</a>
                                <a href="{{route('movies.create')}}" class="dropdown-item">Create Movie</a>
                                <a href="{{route('actors.create')}}" class="dropdown-item">Create Actor</a>
                            @endif
                            @if (Auth::user()->level=='ultraadmin')
                                <a class="dropdown-item" href="{{route('users_sorted')}}">All users and admins</a>
                                <a href="{{route('movies.create')}}" class="dropdown-item">Create Movie</a>
                                <a href="{{route('actors.create')}}" class="dropdown-item">Create Actor</a>
                            @endif
                            @if (Auth::user()->level=='editor')
                                <a href="{{route('movies.create')}}" class="dropdown-item">Create Movie</a>
                                <a href="{{route('actors.create')}}" class="dropdown-item">Create Actor</a>
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                    
                @endguest
            </ul>
        </div>
    </div>
</nav>
<br>
  
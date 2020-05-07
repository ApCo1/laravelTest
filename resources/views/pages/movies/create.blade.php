<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IMDB') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>
    <body>  
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">
                {{session('success')}}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif
        <?php
            session()->forget('error');
            session()->forget('success');
        ?>
        <div class="container pl-0">
            <div class="card p-3 mb-3">
                <form action="{{route('movies.store')}}" method="POST" class="form" style="width:100%"> 
                    {{csrf_field()}}
                    <h1>Check if the movie already exist in the Database:</h1>
    
                    <table class="table table-hover" id="myTable" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Metaphone</th>
                                <th scope="col">Year of Release</th>
                                <th scope="col">Duration</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movies as $movie)
                                <tr class="table-info">
                                    <td scope='row'>{{$movie->name}}</td>
                                    <td> {{$movie->metaphone}}</td>
                                    <td> {{$movie->year_of_release}}</td>
                                    <td> {{$movie->duration}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h1>Add a movie to the Database: </h1>
                        <div style="float:left;width:30%;padding-left:5%;padding-top:5%;">
                            <div class="form-group">
                                <label>MOVIE Image</label>
                                <textarea class="form-control" name="image" rows="10" placeholder="URL of the image goes here"></textarea>
                            </div>
                        </div>
                        <div style="float:left;width:55%;padding-left:5%;padding-right:5%;padding-top:5%;margin-left:5%;">
                            <div class="form-group">
                                <label>MOVIE info</label>
                                <textarea name="title" class="form-control" rows="1" placeholder="Movie Title"></textarea>
                                <textarea name="year_of_release" class="form-control" style="margin-top:20px; width:40%; float:left; margin-right:10%; margin-left:5%" rows="1" placeholder="Year of Release"></textarea>
                                <textarea name="duration" class="form-control" style="margin-top:20px; width:40%;float:left" rows="1" placeholder="Duration"></textarea>
                                <textarea name="info" class="form-control" style="margin-top:75px; width:100%;" rows="5" placeholder="Info"></textarea>
                                <p class="pt-3">
                                    <input type="checkbox" name="genre[]" value="Action"/>Action &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Adventure"/>Adventure &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Animation"/>Animation &nbsp&nbsp&nbsp&nbsp
                                    <input type="checkbox" name="genre[]" value="Biography"/>Biography <input type="checkbox" name="genre[]" value="Comedy"/>Comedy <input type="checkbox" name="genre[]" value="Crime"/>Crime <br>
                                    <input type="checkbox" name="genre[]" value="Drama"/>Drama &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Documentary"/>Documentary &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Fantasy"/>Fantasy &nbsp&nbsp&nbsp&nbsp
                                    <input type="checkbox" name="genre[]" value="Historical"/>Historical <input type="checkbox" name="genre[]" value="Horror"/>Horror <input type="checkbox" name="genre[]" value="Musical"/>Musical <br>
                                    <input type="checkbox" name="genre[]" value="Mystery"/>Mystery &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Romance"/>Romance &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Sci-fi"/>Sci-fi &nbsp&nbsp&nbsp&nbsp
                                    <input type="checkbox" name="genre[]" value="Thriller"/>Thriller &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="War"/>War &nbsp&nbsp&nbsp&nbsp<input type="checkbox" name="genre[]" value="Western"/>Western <br>
                                </p>
                            </div>
                        </div>
                        <div style="clear:both">
                            <button style="float:right;" type="submit" class="btn btn-primary mb-3 mt-3">Next</button>
                        </div>
                    <hr style="clear:both">
                    <?php
                        use App\Actor;
                        $actors = Actor::get();
                    ?>
                
                    <h1>Check You have the Actors in the Database:</h1>
                
                    <table class="table table-hover" id="myTable2" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Select</th>
                                <th scope="col">Name</th>
                                <th scope="col">Metaphone</th>
                                <th scope="col">Date of Birth</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($actors as $actor)
                                <tr class="table-info">
                                    <td scope='row'><input type="checkbox" name="actorid[]" value="{{$actor->id}}"></td>
                                    <td scope='row'>{{$actor->name}}</td>
                                    <td>{{$actor->metaphone}}</td>
                                    <td>{{$actor->dob}}</td>
                                </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                    <hr>
                    <?php
                        use App\Director;
                        $directors = Director::get();
                    ?>
                
                    <h1>Check You have the Director/s in the Database:</h1>
                
                    <table class="table table-hover" id="myTable3" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Select</th>
                                <th scope="col">Name</th>
                                <th scope="col">Metaphone</th>
                                <th scope="col">Date of Birth</th>
                            </tr>
                        </thead>
                        <tbody>
                            <select>
                            @foreach($directors as $director)
                                <tr class="table-info">
                                    <td scope='row'><input type="checkbox" name="directorid[]" value="{{$director->id}}"></td>
                                    <td scope='row'>{{$director->name}}</td>
                                    <td>{{$director->metaphone}}</td>
                                    <td>{{$director->dob}}</td>
                                </tr>
                            @endforeach
                            </select>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <hr>
	<!-- Footer -->
	<footer class="page-footer font-small" style="background-color:#ccddff; width:100%;">

		<!-- Footer Links -->
		<div class="container">

		<!-- Grid row-->
			<div class="row text-center d-flex justify-content-center pt-5 mb-3">

				<!-- Grid column -->
				<div class="col-md-2 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a style="color:#030354" href="{{ url('/') }}">IMDB</a>
					</h6>
				</div>
				<!-- Grid column -->

				<!-- Grid column -->
				<div class="col-md-2 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a style="color:#030354" href="{{ url('/movies') }}">Movies</a>
					</h6>
				</div>
				<!-- Grid column -->

				<!-- Grid column -->
				<div class="col-md-2 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a style="color:#030354" href="/tvshows">TV Shows</a>
					</h6>
				</div>
				<!-- Grid column -->

				<!-- Grid column -->
				<div class="col-md-2 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a style="color:#030354" href="/actors">Actors</a>
					</h6>
				</div>
				<!-- Grid column -->
		
				<!-- Grid column -->
				<div class="col-md-2 mb-3">
					<h6 class="text-uppercase font-weight-bold">
						<a style="color:#030354" href="/contacts">Contact</a>
					</h6>
				</div>
				<!-- Grid column -->
			</div>

			<!-- Grid row-->
			<hr class="rgba-white-light" style="margin: 0 15%;">
		
			<!-- Grid row-->
			<div class="row d-flex text-center justify-content-center mb-md-0 mb-4">
		
				<!-- Grid column -->
				<div class="col-md-8 col-12 mt-3">
				<p style="line-height: 1.7rem">This site was made for practice purposes only!!!</p>
				</div>
				<!-- Grid column -->
			</div>

		</div>
		<!-- Footer Links -->

		<!-- Copyright -->
		<div class="footer-copyright text-center py-3">No Copyright Owned |  
			Original site <a href="{{url('https://www.imdb.com/')}}">www.imbd.com</a>
		</div>
		<!-- Copyright -->
	</footer>

    </body>
<script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous">
</script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    } );
    $(document).ready( function () {
        $('#myTable2').DataTable();
    } );
    $(document).ready( function () {
        $('#myTable3').DataTable();
    } );
</script>
</html>

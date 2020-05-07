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
                <!-- {{route('creators.store')}} -->
                <form action="{{route('creators.store')}}" method="POST" class="form" style="width:100%"> 
                    {{csrf_field()}}
                    <h1>Check if the creator already exist in the Database:</h1>
    
                    <table class="table table-hover" id="myTable" style="width:100%">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Metaphone</th>
                                <th scope="col">Date of Birth</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($creators as $creator)
                                <tr class="table-info">
                                    <td scope='row'>{{$creator->name}}</td>
                                    <td> {{$creator->metaphone}}</td>
                                    <td> {{$creator->dob}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h1>Add a Creator to the Database: </h1>
                        <div style="float:left;width:30%;padding-left:5%;padding-top:5%;">
                            <div class="form-group">
                                <label>Creator Image</label>
                                <textarea class="form-control" name="image" rows="10" placeholder="URL of the image goes here"></textarea>
                            </div>
                        </div>
                        <div style="float:left;width:55%;padding-left:5%;padding-right:5%;padding-top:5%;margin-left:5%;">
                            <div class="form-group">
                                <label style="width:60%; float:left">Creator info</label>
                                <textarea name="name" style="width:60%; float:left;margin-right:10%" class="form-control" rows="1" placeholder="Creator Full Name"></textarea>
                                <select name="sex" style="width:20%;float:left" rows="1" class="form-control">
                                    <option selected disabled hidden>Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <textarea name="dob" class="form-control" style="margin-top:20px; width:46%; float:left; margin-right:8%;" rows="1" placeholder="date of birth in yyyy-mm-dd format"></textarea>
                                <textarea name="dod" class="form-control" style="margin-top:20px; width:46%; float:left; margin-bottom:20px;" rows="1" placeholder="year of death in yyyy format"></textarea>
                                <textarea name="info" class="form-control" style="width:100%;" rows="5" placeholder="Info"></textarea>
                            </div>
                        </div>
                        <div style="clear:both;">
                            <button style="float:right;" type="submit" class="btn btn-primary mb-3 mt-3">Next</button>
                        </div>
                    <hr style="clear:both">
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

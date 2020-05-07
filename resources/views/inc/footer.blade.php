@section('footer')

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
@endsection

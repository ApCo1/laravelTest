@extends('layouts.app')
@section('content')
    <div class="container p-3" style="min-width:720px;">
        <h1 class="pb-2">Welcome to my practice copying <a href="https://www.imdb.com/">IMDB</a></h1>
        <h2>Disclaimer: <span style="font-size:70%;">This is not meant to take away traffic from the IMDb site</span></h2>
    </div>
    <div style="clear:both;"></div>
    <div class="card p-3 mb-3">
        <div class="d-flex">
            <div class="p-2 bd-highlight">
                <img src="img\Arsenije.jpg" style="width:180px;float:left;" alt="Image of the website creator Arsenije Gavric">
            </div>
            <div class="p-2 bd-highlight">
                <div class="d-flex flex-column bd-highlight mb-3">
                    <div class=" bd-highlight">
                        <h1 class="p-0" style="clear:both;">
                            Arsenije Gavric <span style="font-size:40%;"> (Website Creator)</span>
                        </h1>
                    </div>
                    <div class=" bd-highlight">
                        <span style="font-size:120%;"> Born: September 20th, 1997 </span>
                    </div>
                    <div class=" bd-highlight">
                        <p class="mt-3" >
                            Nema sta puno o meni da se prica
                        </p>    
                    </div>
                </div>
            </div>
        </div>
    </div> 
@endsection

@section('footer')
    @include('inc.footer')
@endsection

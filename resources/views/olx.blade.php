@extends('layouts.app')
@section('content')
<div class="container p-3" style="min-width:720px;">
    {{--  ['id' => 3526, 'vrijednost' => $bezicni], --}}
    <hr>
        <h2>{{$nresp['kategorija']}}</h2>
    <hr>
    <p style="font-family: 'monospace', monospace;">
    case {{$nresp['kategorija']}}: <br>
    &nbsp&nbsp&nbsp&nbsp// $listaPolja = array(<br>
    @foreach($nresp['polja'] as $n)
        <?php 
            $name = str_replace("polje", "",$n['name']);
        ?>
        &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp// ['id' => {{$name}}, 'vrijednost' => {{$n['naziv']}}], 
        @if($n['tip'] == 'select')
            @foreach($n['opcije'] as $opcija)
                @if ($loop->first)
                    // '{{$opcija}}'
                @else
                    , '{{$opcija}}'
                @endif
            @endforeach
        @elseif($n['tip'] == 'checkbox')
            @foreach($n['opcije'] as $opcija)
                @if ($loop->first)
                    // '{{$opcija}}'
                @else
                    , '{{$opcija}}'
                @endif
            @endforeach
        @endif
        <br>
    @endforeach
    &nbsp&nbsp&nbsp&nbsp// );<br>
    &nbsp&nbsp&nbsp&nbsp$listaPolja = []; <br>
    &nbsp&nbsp&nbsp&nbspreturn $listaPolja;
    </p>
    <hr>
</div>
    <div style="clear:both;"></div>
    <div class="card p-3 mb-3">
        <table class="table table-hover" id="myTable">
            <thead class="thead-dark">
                <tr>
                    <th>OBAVEZNO</th>
                    <th>NAZIV</th>
                    <th>NAME</th>
                    <th>TIP</th>
                    <th>OPCIJE <span style="font-size:70%"> (ako ih ima)<span></th>
                </tr>
            </thead>
            <tbody>
                @foreach($nresp['polja'] as $n)
                    <tr class="table-info">
                        <td scope='row'>@if($n['obavezno'])DA @else NE @endif</td>
                        <td>{{$n['naziv']}}</td>
                        <td>{{$n['name']}}</td>
                        <td>{{$n['tip']}}</td>
                        @if($n['tip'] == 'select')
                            <td>
                                @foreach($n['opcije'] as $opcija)
                                    @if ($loop->first)
                                        {{$opcija}}
                                    @else
                                        , {{$opcija}}
                                    @endif
                                @endforeach
                            </td>
                        @elseif($n['tip'] == 'checkbox')
                            <td>
                                @foreach($n['opcije'] as $opcija)
                                    @if ($loop->first)
                                        {{$opcija}}
                                    @else
                                        , {{$opcija}}
                                    @endif
                                @endforeach
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div> 
@endsection

@section('footer')
    @include('inc.footer')
@endsection
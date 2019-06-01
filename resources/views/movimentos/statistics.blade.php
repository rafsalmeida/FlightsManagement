@extends('master')
@section('title', "Estatisticas")
@section('content')

<div style="text-align: center; margin-top: 10px">
    <h4>{{$title}}</h4>
</div>
<div id="estatisticasGrafico">

    <div style="text-align: center; margin-top: 10px">
        <h5>{{$titleAeronave}}</h5>
    </div>
    <div style="text-align: center; margin-top: 10px">
        <h5>{{$titlePiloto}}</h5>
    </div>
    <br>
    <div style="text-align: center">
        <h5>Gráficos</h5>
    </div>
    <div id="year-chart"></div>
    <div id="month-chart"></div>
    <div id="pilot-month-chart"></div>
    <div id="pilot-year-chart"></div>

    <div class="container">
        <div class="row">
            @if (count($pilotos))
            <div class="col">
                <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
                    <thead class="thead-light">
                    <tr>
                        <th>Nº Sócio</th>
                        <th>Nome Informal</th>
                        <th>Estatísticas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($pilotos as $piloto)
                    <tr>
                        <td>{{ $piloto->num_socio }}</td>
                        <td>{{ $piloto->nome_informal }}</td>
                        <td>
                            <a class="btn btn-link" href="?id={{$piloto->id}}" name="id" style="width: 100%">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$pilotos->appends(request()->except('pilotos'))->links()}}
            </div>
            @endif
            @if (count($aeronaves))
            <div class="col">
                <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
                    <thead class="thead-light">
                    <tr>
                        <th>Matricula</th>
                        <th>Estatísticas</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($aeronaves as $aeronave)
                    <tr>
                        <td>{{ $aeronave->matricula }}</td>
                        <td>
                            <a class="btn btn-link" href="?matricula={{$aeronave->matricula}}" name="matricula" style="width: 100%">Ver</a>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
                {{$aeronaves->appends(request()->except('aeronaves'))->links()}}
            </div>
            @endif
        </div>
    </div>
</div>
<div style="text-align: center">
    <h5>Tabelas</h5>
</div>
<div id="estatisticasTabela">
    @if(count($aeronavesAno))
    <div class="col">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
            <thead class="thead-light">
            <tr>
                <th>Aeronaves/Ano</th>
                @foreach($anos as $ano)
                <th>{{$ano}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($aeronavesAno as $key => $aeronave)
            <tr>
                <td>{{$aeronave->matricula}}</td>
                @foreach($anos as $ano)
                <td>
                    @if(isset($aeronave->estatistica[$ano]))
                    {{number_format($aeronave->estatistica[$ano]/60,2,'.','')}}
                    @else
                    -
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
        {{$aeronavesAno->appends(request()->except('aeronavesAno'))->links()}}
    </div>
    @endif
    @if(count($aeronavesMes))
    <div class="col">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
            <thead class="thead-light">
            <tr>
                <th>Aeronave/Mês</th>
                @foreach($meses as $mes)
                <th>{{$mes}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($aeronavesMes as $key => $aeronave)
            <tr>
                <td>{{$aeronave->matricula}}</td>
                @foreach($meses as $mes)
                <td>
                    @if(isset($aeronave->estatistica[$mes]))
                    {{number_format($aeronave->estatistica[$mes]/60,2,'.','')}}
                    @else
                    -
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
        {{$aeronavesMes->appends(request()->except('aeronavesMes'))->links()}}
    </div>
    @endif
    @if(count($pilotosAno))
    <div class="col">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
            <thead class="thead-light">
            <tr>
                <th>Pilotos/Ano</th>
                @foreach($anos as $ano)
                <th>{{$ano}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($pilotosAno as $key => $pilotos)
            <tr>
                <td>{{$pilotos->id}}</td>
                @foreach($anos as $ano)
                <td>
                    @if(isset($pilotos->estatistica[$ano]))
                    {{number_format($pilotos->estatistica[$ano]/60,2,'.','')}}
                    @else
                    -
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
        {{$pilotosAno->appends(request()->except('pilotosAno'))->links()}}
    </div>
    @endif
    @if(count($pilotosMes))
    <div class="col">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
            <thead class="thead-light">
            <tr>
                <th>Pilotos/Mês</th>
                @foreach($meses as $mes)
                <th>{{$mes}}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($pilotosMes as $key => $pilotos)
            <tr>
                <td>{{$pilotos->id}}</td>
                @foreach($meses as $mes)
                <td>
                    @if(isset($pilotos->estatistica[$mes]))
                    {{number_format($pilotos->estatistica[$mes]/60,2,'.','')}}
                    @else
                    -
                    @endif
                </td>
                @endforeach
            </tr>
            @endforeach
            </tbody>
        </table>
        {{$pilotosAno->appends(request()->except('pilotosMes'))->links()}}
    </div>
    @endif

</div>
<!--
<div id="year-chart"></div>
<div id="month-chart"></div>
<div id="pilot-month-chart"></div>
<div id="pilot-year-chart"></div> -->

<!--<script>
// When the user clicks on <div>, open the popup
function myFunction() {
  var popup = document.getElementById("aeronaveMesPopup");
  popup.classList.toggle("show");
}
</script>-->

@endsection
@extends('master')
@section('title', "Estatisticas")
@section('content')

<div style="text-align: center; margin-top: 10px">
	<h4>{{$title}}</h4>
</div>


<div class="container">
	<div class="row">
		@if (count($pilotos))
		<div class="col">
			<table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
			    <thead class="thead-light">
			        <tr>
			            <th>Nº Sócio</th>
			            <th>Nome Informal</th>
			            <th>Mês</th>
			            <th>Ano</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach ($pilotos as $piloto)
			        <tr>
			            <td>{{ $piloto->num_socio }}</td>
			            <td>{{ $piloto->nome_informal }}</td>
			            <td></td>
			            <td></td>
			        </tr>
			    @endforeach
			    </tbody>
			</table>
		</div>
		@endif
		@if (count($aeronaves))
		<div class="col">
			<table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
			    <thead class="thead-light">
			        <tr>
			            <th>Matricula</th>
			            <th>Mês</th>
			            <th>Ano</th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach ($aeronaves as $aeronave)
			        <tr>
			            <td>{{ $aeronave->matricula }}</td>
			            <td></td>
			            <td></td>
			        </tr>
			    @endforeach
			    </tbody>
			</table>
		</div>

		@endif
	</div>
</div>
{{$pilotos->links()}}
<!--
<div id="year-chart"></div>
<div id="month-chart"></div>
<div id="pilot-month-chart"></div>
<div id="pilot-year-chart"></div> -->


@endsection

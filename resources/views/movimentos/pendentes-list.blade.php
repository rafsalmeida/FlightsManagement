@extends('master')
@section('title', "Assuntos pendentes")
@section('content')

<div style="text-align: center; margin-top: 10px">
	<h4>{{$title}}</h4>
</div>
<br>
<div class="container">
	<div class="row">
		@if(count($movimentosConflitos))
		<div class="col">
			<h5 class="text-center">Movimentos com conflitos</h5>
			<table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
			    <thead class="thead-light">
			        <tr>
			            <th>Data</th>
			            <th>Tipo de Conflito</th>
			            <th>Justificação</th>
			            <th></th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($movimentosConflito as $conflito)
			    	<tr>
			    		<td>{{$conflito->data}}</td>
			    		<td>{{$conflito->tipo_conflito}}</td>
			    		<td>{{$conflito->justificacao_conflito}}</td>
			    		<td>
                            <a class="btn btn-sm btn-xs btn-primary"  href="{{action('MovimentoController@edit', $conflito->id)}}">Resolver</a>
			    		</td>
			    	</tr>
				@endforeach
			    </tbody>
			</table>

		</div>
		@endif
		@if(count($movimentosConfirmar))
		<div class="col">
			<h5 class="text-center">Movimentos por confirmar</h5>
			<table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
			    <thead class="thead-light">
			        <tr>
			            <th>Data</th>
			            <th>Aeronave</th>
			            <th>Piloto</th>
			            <th></th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($movimentosConfirmar as $naoConfirmados)
			    	<tr>
			    		<td>{{$naoConfirmados->data}}</td>
			    		<td>{{$naoConfirmados->aeronave}}</td>
			    		<td>{{$naoConfirmados->piloto_id}}</td>
			    		<td>
			    			<a class="btn btn-sm btn-xs btn-primary" style="width: 100%" href="{{action('MovimentoController@edit', $naoConfirmados->id)}}">Resolver</a>
			    		</td>
			    	</tr>
				@endforeach
			    </tbody>
			</table>
		@endif
		</div>
	</div>
	<div class="row">
		@if(count($licencasConfirmar))
		<div class="col">
			<h5 class="text-center">Licenças por confirmar</h5>
			<table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
			    <thead class="thead-light">
			        <tr>
			            <th>NºSócio</th>
			            <th>Nome</th>
			            <th>NºLicença</th>
			            <th></th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($licencasConfirmar as $licenca)
			    	<tr>
			    		<td>{{$licenca->num_socio}}</td>
			    		<td>{{$licenca->nome_informal}}</td>
			    		<td>{{$licenca->num_licenca}}</td>
			    		<td>
			    			<a class="btn btn-sm btn-xs btn-primary" href="{{ action('SocioController@edit', $licenca->id) }}"><i class="fas fa-user-edit"></i> Resolver</a>
			    		</td>

			    	</tr>
				@endforeach
			    </tbody>
			</table>
		@endif
		</div>
		@if(count($certificadosConfirmar))
		<div class="col">
			<h5 class="text-center">Certificados por confirmar</h5>
			<table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
			    <thead class="thead-light">
			        <tr>
			            <th>NºSócio</th>
			            <th>Nome</th>
			            <th>NºCertificado</th>
			            <th></th>
			        </tr>
			    </thead>
			    <tbody>
			    @foreach($certificadosConfirmar as $certificado)
			    	<tr>
			    		<td>{{$certificado->num_socio}}</td>
			    		<td>{{$certificado->nome_informal}}</td>
			    		<td>{{$certificado->num_certificado}}</td>
			    		<td>
			    			<a class="btn btn-sm btn-xs btn-primary" style="width: 100%" href="{{ action('SocioController@edit', $certificado->id) }}"><i class="fas fa-user-edit"></i> Resolver</a>
			    		</td>

			    	</tr>
				@endforeach
			    </tbody>
			</table>
		@endif
		</div>
	</div>
</div>


@endsection
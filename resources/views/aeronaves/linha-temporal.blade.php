@extends('master')
@section('title', "Linhas Temporais")
@section('content')
<div class="container" style="text-align: center; padding-top: 10px">
	<h3>{{$title}}</h3>
	<br>
	<h5>Filtre por aeronave e pelo intervalo de data desejado</h5>
</div>
@if(session('unsuccess'))
    @include('partials.unsuccess')
@endif
<div class="col-md-4 container" >
    <div class="dropdown" style="padding-top: 10px" >
        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" style="width: 100%"><i class="fas fa-filter"></i>
            Filtros
        </button>
        <div class="dropdown-menu" style="width: 100%">
        <form  method="GET" action="{{action('AeronaveController@linhaTemporal')}}" id="pesquisarMovimento">
            <div class="form-group ">
                    {{ Form::select('matricula', $aeronaves, null, ['class' => 'form-control conta-horas', 'name' => 'matricula'])}}
            </div>
            <div class="form-group">
            	<label for="data_inf"> De:</label>
                <input type="date" class="form-control" name="data_inf">
            </div>
            <div class="form-group">
            	<label for="data_sup"> A:</label>
                <input type="date" class="form-control" name="data_sup">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-success mb-3" style="width: 100%">
                    <i class="fas fa-search"></i> Pesquisar
                </button>
            </div>
        </form>
        </div>
    </div>
</div>
<br>

@if(count($datas))
<div class="container" >
	<div class="container" style="text-align: center">
		<h5>{{$dataMaisRecente}}</h5>
	</div>
    <div class="row">
        <div class="col-md-12">
            <div class="main-timeline">
            	@for($i=0; $i<$diferenca+1;$i++)
                <div class="timeline" >
	                    <a class="timeline-content">
	                        <h3 class="title">@if(isset($datas[$i])){{$datas[$i]}}@else Sem registos @endif</h3>
	                        <p class="description">
	                        	@foreach($movimentosAeronave as $key => $movimento)
	                        		@if(isset($datas[$i]) && $movimento==$datas[$i])
	                        			Movimento {{$key}}
	                        			<br>
	                        		@endif
	                        	@endforeach
	                        </p>
	                    </a>
	                </div>
                @endfor
            </div>
        </div>
    </div>
    <div class="container" style="text-align: center">
		<h5>{{$dataMaisAntiga}}</h5>
	</div>
</div>
@else
 <h5>Nenhum movimento encontrado nessas datas.</h5>
@endif
@endsection
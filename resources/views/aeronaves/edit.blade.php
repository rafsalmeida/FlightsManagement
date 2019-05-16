@extends('master')
@section('title',"Editar Aeronave")
@section('content')

@include('aeronaves.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
<form action="{{ action('AeronaveController@update', $aeronave->matricula)}}" method="post" class="form-group">
	@method('put')
	@csrf
    <input type="hidden" name="matricula" value="{{ $aeronave->matricula }}" />
    <div class="container" style="padding-top: 15px">
    	@yield('form')
    </div>

     <div>
       @dump($valores)
       @foreach($valores as $valor)

{{$valor->unidade_conta_horas}} - {{$valor->minutos}} {{$valor->preco}} <br>
       @endforeach 

    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancelar</button>
    </div>
</form>
@endsection


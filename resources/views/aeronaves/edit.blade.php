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

    <div class="w-100 p-3  container" >
       <table class="table table-bordered  table table-sm shadow p-3 mb-5 bg-white rounded">
         <thead class="thead-light">
        <tr>
            <th>Unidade Conta Horas</th>
            <th>Preço</th>
            <th>Tempo</th>
        </tr>
        </thead>
    <tbody>
    @foreach($valores as $valor)
        <tr>
            <td>{{$valor->unidade_conta_horas}} </td>
            <td>{{$valor->minutos}} </td>
            <td>{{$valor->preco}}</td>
           
        </tr>

       @endforeach 
    </tbody>
    </table>

    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancelar</button>
    </div>
</form>
@endsection


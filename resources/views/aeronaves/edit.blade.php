@extends('master')
@section('title',"Editar Aeronave")
@section('content')

@include('aeronaves.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
<form  method="POST" action="{{ action('AeronaveController@update', $aeronave->matricula)}}"  class="form-group">
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
            <th>Minutos</th>
            <th>Preço</th>
        </tr>
        </thead>
    <tbody>
    @foreach($valores as $valor)
        <tr>
            <td>{{$valor->unidade_conta_horas}} </td>
            <td> <input type="text" class="form-control" name="minutos" id="inputMinutos"
            value="@if(isset($valor)){{ old('minutos', $valor->minutos) }}@endif" /> </td>
            <td><input type="text" class="form-control" name="preco" id="inputPreco"
            value="@if(isset($valor)){{ old('preco', $valor->preco) }}@endif" /> </td>
           
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


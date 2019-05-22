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
    @for ($i = 0; $i< 10; $i++)
        <tr>
            <td>{{$i+1}} </td>
            <td> <input type="text" class="form-control" name="tempos[]" id="inputTempo"
            value="{{ old('tempos.' .$i,$valores[$i]->minutos) }}" /> </td>
            <td><input type="text" class="form-control" name="precos[]" id="inputPreco"
            value="{{ old('precos.' .$i,$valores[$i]->preco) }}"  /> </td>
           
        </tr>

       @endfor
    </tbody>
    </table>

    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancelar</button>
    </div>
</form>
@endsection


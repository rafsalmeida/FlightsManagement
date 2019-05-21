@extends('master')
@section('title',"Adicionar Aeronave")
@section('content')
@include('aeronaves.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
<form method="POST" action="{{ action('AeronaveController@store')}}"  class="form-group">
	@csrf
    <div class="container" style="padding-top: 15px">
    	@yield('form')
    </div>
    <div class="w-100 p-3  container" >
       <table class="table table-bordered  table table-sm shadow p-3 mb-5 bg-white rounded">
         <thead class="thead-light">
        <tr>
            <th>Unidade Conta Horas</th>
            <th>Minutos</th>
            <th>Preco</th>
        </tr>
        </thead>
    <tbody>
  		@for ($i = 1; $i < 11; $i++)
	
        <tr>
            <td>{{$i}} </td>
            <td><div class="form-group">
    			<input type="text" class="form-control" name="tempos[]" id="minuto"
        				placeholder="Minutos"/>
   			             <!-- Verificar-->
   			             @if ($errors->has('minuto'))
        				<em>{{ $errors->first('minuto') }}</em>
   						 @endif
			</div> </td>

            <td>
            	<div class="form-group">
    			<input type="text" class="form-control" name="precos[]" id="preco_minuto"
        				placeholder="Precos"/>
   			             <!-- Verificar-->
   			             @if ($errors->has('preco_minuto'))
        				<em>{{ $errors->first('preco_minuto') }}</em>
   						 @endif
			</div> 
            </td>
           
        </tr>

       @endfor
    </tbody>
    </table>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Adicionar</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancelar</button>
    </div>
</form>
@endsection


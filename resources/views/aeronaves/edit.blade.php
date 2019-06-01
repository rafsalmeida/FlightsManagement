@extends('master')
@section('title',"Editar Aeronave")
@section('content')

@include('aeronaves.partials.add-edit')
@if (count($errors) > 0)
@include('partials.errors')
@endif

<form method="GET" action="{{ action('AeronavePilotosController@index',$aeronave->matricula)}}" class ="form-group" style="padding-left: 15px; padding-top: 10px">
    <button type="submit" class="btn btn-primary"><i class="fas fa-users"></i> Lista de Pilotos</button>
</form>

<form  method="POST" action="{{ action('AeronaveController@update', $aeronave->matricula)}}"  class="form-group">
    @method('PUT')
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
            @foreach ($valores as $valor)
            <tr>
                <td>{{$valor->unidade_conta_horas}} </td>
                <td> <input type="text" class="form-control" name="tempos[{{$valor->unidade_conta_horas}}]" id="inputTempo"
                            value="{{ old('tempos.' .$valor,$valor->minutos) }}" /> </td>
                <td><input type="text" class="form-control" name="precos[{{$valor->unidade_conta_horas}}]" id="inputPreco"
                           value="{{ old('precos.' .$valor,$valor->preco) }}"  /> </td>

            </tr>

            @endforeach

            </tbody>
        </table>
    </div>
    
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <a class="btn btn-default" href="{{action('AeronaveController@index')}}" name="cancel">Cancelar</a>
    </div>
</form>

<form method="GET" action="{{ action('AeronavePilotosController@index',$aeronave->matricula)}}" class ="form-group" style="padding-left: 15px">
    <button type="submit" class="btn btn-primary">Lista de Pilotos</button>
</form>
@endsection


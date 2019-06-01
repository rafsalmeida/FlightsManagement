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
            <td>
          <input type="text" class="form-control" name="tempos[{{$i}}]" 
                placeholder="Minutos"/>
                     <!-- Verificar-->
                     @if ($errors->has('tempos'))
                <em>{{ $errors->first('tempos') }}</em>
               @endif
            </td>

            <td>
             
          <input type="text" class="form-control" name="precos[{{$i}}]" 
                placeholder="Precos"/>
                     <!-- Verificar-->
                     @if ($errors->has('precos'))
                <em>{{ $errors->first('precos') }}</em>
               @endif
             
            </td>
           
        </tr>

       @endfor
    </tbody>
    </table>
  </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Adicionar</button>
        <a class="btn btn-default" href="{{action('AeronaveController@index')}}" name="cancel">Cancelar</a>
    </div>
</form>
@endsection


@extends('master')
@section('title', "Lista de Aeronaves")
@section('content')
@can('is-direcao', Auth::user())
<div style="padding-top: 10px"><a class="btn btn-primary" href="{{ route('aeronaves.create') }}"><i class="fas fa-plus"></i> Adicionar Aeronave</a></div>
@endcan
<div style="padding-top: 10px">
@if (count($aeronaves))

    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
    <thead class="thead-light">
        <tr>
            <th>Matricula</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Nº de Lugares</th>
            <th>Conta-horas</th>
            <th>Preço/hora</th>
             @can('is-direcao', Auth::user())
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach ($aeronaves as $aeronave)
        <tr>
            <td>{{ $aeronave->matricula }}</td>
            <td>{{ $aeronave->marca }}</td>
            <td>{{ $aeronave->modelo }}</td>
            <td>{{ $aeronave->num_lugares }}</td>
            <td>{{ $aeronave->conta_horas/10}} horas</td>
            <td>{{ $aeronave->preco_hora }}€</td>
            @can('is-direcao', Auth::user())
            <td>
              
                <div style="text-align: center; margin: auto">
                <a class="btn btn-sm btn-xs btn-primary rounded-pill" style="width: 100%" href="{{action('AeronaveController@edit', $aeronave->matricula)}}"><i class="fas fa-fighter-jet"></i> Editar</a>
                <form action="{{action('AeronaveController@destroy', $aeronave->matricula)}}" method="POST" role="form" class="inline">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="aeronave_matricula" value="{{ $aeronave->matricula }}">
                    {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Apagar', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-danger rounded-pill', 'style' => 'width: 100%', 'onclick' => "return confirm('Tem a certeza que quer apagar?')"]) !!}
                   
                </form>
            </div>
            </td>
             @endcan
        </tr>
    @endforeach
    </table>
</div>


@else
    <div class="col-md-12">    
        <h2>Nenhum aeronave encontrada </h2>
    </div>
@endif

@endsection

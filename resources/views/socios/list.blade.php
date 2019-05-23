@extends('master')
@section('title', "Lista de Sócios")
@section('content')
@can('is-direcao', Auth::user())
<div style="padding-top: 10px"><a class="btn btn-primary" href="{{ route('socios.create') }}">Adicionar Sócio</a>
</div>
@endcan
<div style="padding-top: 10px">
@if (count($socios))
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded" >
    <thead class="thead-light">
        <tr>
            <th>Foto</th>
            <th>Nome Informal</th>
            <th>Email</th>
            <th>Tipo de Sócio</th>
            <th>Direção</th>
            <th>Quotas</th>
            <th>Ativo</th>
            @can('is-direcao', Auth::user())
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach ($socios as $socio)
        <tr>
            <td><a href="{{url('/storage/fotos').'/'.$socio->foto_url}}">Foto</a></td>
            <td>{{ $socio->nome_informal }}</td>
            <td>{{ $socio->email }}</td>
            <td>
                @if($socio->tipo_socio == "P")
                    Piloto
                @elseif ($socio->tipo_socio == "NP")
                    Não-Piloto
                @else
                    Aeromodelista
                @endif
            </td>
            <td>@if ($socio->direcao == 1)
                    Pertence
                @else
                    Não pertence
                @endif
            </td>
            <td>
                @if ($socio->quota_paga == 1)
                    Pagas
                @else
                    Não pagas
                @endif
            </td>
            <td>
                @if ($socio->ativo == 1)
                    Ativo
                @else
                    Não-ativo
                @endif
            </td>
            @can('is-direcao', Auth::user())
            <td>                
                <div style="text-align: center; margin: auto">
                <a class="btn btn-sm btn-xs btn-primary rounded-pill" style="width: 100%" href="{{ action('SocioController@edit', $socio->id) }}"><i class="fas fa-user-edit"></i> Editar</a>
                <form method="POST" action="{{action('SocioController@destroy', $socio->id)}}"  role="form" class="inline">
                    @csrf
                    @method('delete')
                    <input type="hidden" name="socio_id" value="{{ $socio->id }}">
                    {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Apagar', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-danger rounded-pill', 'style' => 'width: 100%', 'onclick' => "return confirm('Tem a certeza que quer apagar?')"]) !!}
                </form>
                <form method="POST" action="{{url('/socios/'.$socio->id.'/ativo')}}"  role="form" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="_method" value="patch">
                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Ativar/Desativar', ['type' => 'submit', 'name' => 'ativo', 'class' => 'btn btn-sm btn-xs btn-success rounded-pill', 'style' => 'width: 100%', 'onclick' => "return confirm('Tem a certeza que quer alterar o estado?')"]) !!}
                </form>
                
            </div>
            </td>
            @endcan
        </tr>
    @endforeach
    </table>
</div>

@else
    <h2>Nenhum sócio encontrado </h2>
@endif

{{ $socios->links() }}

@endsection

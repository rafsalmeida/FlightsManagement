@extends('master')
@section('title', "Lista de Sócios")
@section('content')
<div style="padding: 2vh 0"><a class="btn btn-primary" href="{{ route('socios.create') }}">Adicionar Sócio</a></div>
@if (count($socios))
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
    <thead class="thead-light">
        <tr>
            <th>Foto</th>
            <th>Nome Informal</th>
            <th>Email</th>
            <th>Tipo de Sócio</th>
            <th>Direção</th>
            <th>Quotas</th>
            <th>Ativo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($socios as $socio)
        <tr>
            <td><a href="http://ainet.prj31.test/storage/fotos/{{$socio->foto_url}}">Foto</a></td>
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
            <td>
                <div style="text-align: center; margin: auto">
                <a class="btn btn-sm btn-xs btn-primary rounded-pill" style="width: 100%" href="{{action('SocioController@edit', $socio->id)}}">Editar</a>
                <form action="{{action('SocioController@destroy', $socio->id)}}" method="POST" role="form" class="inline">
                    @csrf
                    @method('delete')
                    @include('partials.deletemodal')
                    <input type="hidden" name="socio_id" value="{{ $socio->id }}">
                    <button type="button" class="btn btn-sm btn-xs btn-danger rounded-pill" data-target="#deleteconfirm" data-toggle="modal" style="width: 100%">Apagar</button>
                </form>
            </div>
            </td>
        </tr>
    @endforeach
    </table>


@else
    <h2>Nenhum sócio encontrado </h2>
@endif

{{ $socios->links() }}

@endsection

@extends('master')
@section('title', "Lista de Sócios")
@section('content')
@can('is-direcao', Auth::user())
<div class="col-md-2" style="padding-top: 10px; padding-bottom: 10px; position: relative; float: left"><a class="btn btn-primary" href="{{ route('socios.create') }}"><i class="fas fa-user-plus"></i> Adicionar Sócio</a>
</div>
<div class="col-md-2" style="padding-top: 10px; padding-bottom: 10px; position: relative; float: left">
<form method="POST" action="{{route('socios.resetQuotas')}}"  role="form" class="">
    @csrf
    @method('PATCH')
    <input type="hidden" name="_method" value="patch">
    {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Reset Quotas', ['type' => 'submit', 'name' => 'quota_paga', 'class' => 'btn btn-danger ', 'onclick' => "return confirm('Tem a certeza que quer fazer reset às quotas?')"]) !!}
</form>
</div>
@endcan
<div class="form-group" style="padding-top: 10px; float: right;">            
    <form  method="GET" action="{{action('SocioController@index')}}">
        <div class="form-row ">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Nome Informal" name="nome_informal">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Nºsócio" name="num_socio">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                {{ Form::select('tipo_socio', [null => 'Tipo (Selecione)'] +  array('P' => 'Piloto', 'NP' => 'Não Piloto', 'A' => 'Aeromodelista'), null, ['id' => 'idTipoSocio', 'class' => 'form-control', 'name' => 'tipo'])}}
            </div>
            <div class="form-group form-check-inline" style="padding-left: 10px">
                {{ Form::checkbox('direcao', '1', false, ['class' => 'form-check-input']) }}
                <label class="form-check-label">
                    Direção
                </label>
            </div>
            @can('is-direcao', Auth::user())
            <div class="form-group form-check-inline">
                {{ Form::checkbox('ativo', '1', false, ['class' => 'form-check-input']) }}
                <label class="form-check-label" for="ativo">
                    Ativo
                </label>
            </div>
            <div class="form-group form-check-inline">
                {{ Form::checkbox('quota_paga', '1', false, ['class' => 'form-check-input']) }}
                <label class="form-check-label" for="ativo">
                    Quotas Pagas
                </label>
            </div>
            @endcan
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-success mb-3" >
                    <i class="fas fa-search"></i> Pesquisar
                </button>
            </div>
        </div>
    </form>
</div>

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
            <th>NºSócio</th>
            @can('is-direcao', Auth::user())
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach ($socios as $socio)
        <tr>
            <td><div style="text-align: center"><img src="{{url('/storage/fotos').'/'.$socio->foto_url}}" height="65" width="65"></div></td>
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
                {{$socio->num_socio}}
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
                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Alterar Estado', ['type' => 'submit', 'name' => 'ativo', 'class' => 'btn btn-sm btn-xs btn-success rounded-pill', 'style' => 'width: 100%', 'onclick' => "return confirm('Tem a certeza que quer alterar o estado?')"]) !!}
                </form>
                <form method="POST" action="{{url('/socios/'.$socio->id.'/quota')}}"  role="form" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="_method" value="patch">
                    {!! Form::button('<i class="fas fa-pencil-alt"></i> Alterar Quotas', ['type' => 'submit', 'name' => 'quota_paga', 'class' => 'btn btn-sm btn-xs btn-warning rounded-pill', 'style' => 'width: 100%', 'onclick' => "return confirm('Tem a certeza que quer alterar o estado das quotas?')"]) !!}
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

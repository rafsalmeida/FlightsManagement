@extends('master')
@section('title', "Lista de Sócios")
@section('content')
@can('is-direcao', Auth::user())
<div class="col-md-3" style="padding-top: 10px; padding-bottom: 10px; position: relative; float: left">
    <a class="btn btn-primary" href="{{ route('socios.create') }}" style="width: 100%"><i class="fas fa-user-plus"></i> Adicionar Sócio</a>
    <button style="margin-top: 10px; width: 100%" class="btn btn-success" type="button" data-toggle="modal" data-target="#gerir-quotas"><i class="fas fa-euro-sign"></i> Gerir Quotas</button>
</div>
<div class="modal" id="gerir-quotas">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Gerir Quotas</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        <div class="modal-body">
        <form method="POST" action="{{route('socios.resetQuotas')}}"  role="form" >
            @csrf
            @method('PATCH')
            <input type="hidden" name="_method" value="patch">
            {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Reset todas a todas as quotas', ['type' => 'submit', 'name' => 'quota_paga','style' => 'width:100%' ,'class' => 'btn btn-danger ', 'onclick' => "return confirm('Tem a certeza que quer fazer reset às quotas?')"]) !!}
        </form>
        <form method="POST" action="{{route('socios.desativarSemQuotas')}}"  role="form" >
            @csrf
            @method('PATCH')
            <input type="hidden" name="_method" value="patch">
            {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Reset quotas dos sócios desativados', ['type' => 'submit','style' => 'width:100%', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Tem a certeza que quer fazer reset às quotas dos sócios desativados?')"]) !!}
        </form>
        </div>
<!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar    </button>
      </div>

    </div>
  </div>
</div>
@endcan
<div class="form-group " style="padding-top: 10px; float: right;">            
    <form  method="GET" action="{{action('SocioController@index')}}" id="pesquisarSocio">
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
                {{ Form::checkbox('quota_paga', '1', false, ['class' => 'form-check-input', 'name' => 'quotas_pagas']) }}
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
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded table-responsive" style="white-space: nowrap;">
    <thead class="thead-light">
        <tr>
            <th>Foto</th>
            <th>Nome Informal</th>
            <th>Email</th>
            <th>Telefone</th>
            <th>Tipo de Sócio</th>
            <th>Nº da Licença de Piloto</th>
            <th>Direção</th>
            <th>NºSócio</th>
            @can('is-direcao', Auth::user())
            <th>Quotas</th>
            <th>Ativo</th>
            <th></th>
            @endcan
        </tr>
    </thead>
    <tbody>
    @foreach ($socios as $socio)
        <tr>
            <td>
                @if(isset($socio->foto_url))
                <div style="text-align: center">
                    <img src="{{url('/storage/fotos').'/'.$socio->foto_url}}" height="65" width="65">
                </div>
                @endif
            </td>
            <td>{{ $socio->nome_informal }}</td>
            <td>{{ $socio->email }}</td>
            <td>{{ $socio->telefone }}</td>
            <td>
                @if($socio->tipo_socio == "P")
                    Piloto <br>
                @elseif ($socio->tipo_socio == "NP")
                    Não-Piloto
                @else
                    Aeromodelista
                @endif
            </td>
            <td>@if($socio->tipo_socio == "P")
                    {{$socio->num_licenca}}
                @else
                    Não tem licença de Piloto
                @endif</td>
            <td>@if ($socio->direcao == 1)
                    Pertence
                @else
                    Não pertence
                @endif
            </td>
            <td>
                {{$socio->num_socio}}
            </td>

            @can('is-direcao', Auth::user())
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

                <div class="dropdown navbar-nav ml-auto" style="text-align: center; margin: auto">
                  <button type="button" class="btn btn-outline-primary btn-block dropdown-toggle" data-toggle="dropdown">
                    Ações
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu ml-auto">
                    <li>
                        <a class="btn btn-sm btn-xs btn-primary" style="width: 100%" href="{{ action('SocioController@edit', $socio->id) }}"><i class="fas fa-user-edit"></i> Editar</a>
                    </li>
                    <li>
                        <form method="POST" action="{{action('SocioController@destroy', $socio->id)}}"  role="form" class="inline" style="margin:0">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="socio_id" value="{{ $socio->id }}">
                            {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Apagar', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-danger', 'style' => 'width: 100%; white-space: nowrap;', 'onclick' => "return confirm('Tem a certeza que quer apagar?')"]) !!}
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{route('socios.mudarEstado', $socio->id)}}"  role="form" class="inline" style="margin:0">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="_method" value="patch">
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Alterar Estado', ['type' => 'submit', 'name' => 'ativo', 'class' => 'btn btn-sm btn-xs btn-success ', 'style' => 'width: 100%; white-space: nowrap;', 'onclick' => "return confirm('Tem a certeza que quer alterar o estado?')"]) !!}
                        </form>
                    </li>
                    <li>
                        <form method="POST" action="{{route('socios.mudarEstadoQuota', $socio->id)}}"  role="form" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="_method" value="patch">
                            {!! Form::button('<i class="fas fa-pencil-alt"></i> Alterar Quotas', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-warning', 'style' => 'width: 100%; white-space: nowrap;', 'name' => 'quota_paga','onclick' => "return confirm('Tem a certeza que quer alterar o estado das quotas?')"]) !!}
                        </form>
                    </li>
                  </ul>
                
            </td>
            @endcan
        </tr>
    @endforeach
    </table>
</div>

@else
    <div class="col-md-12">    
        <h2>Nenhum sócio encontrado </h2>
    </div>

@endif

{{ $socios->appends(request()->except('page'))->links() }}

@endsection
<script  type="text/javascript">
    window.onload = function(){
  
  // Remove empty fields from GET forms
  // Author: Bill Erickson
  // URL: http://www.billerickson.net/code/hide-empty-fields-get-form/
  
    // Change 'form' to class or ID of your specific form
    $("#pesquisarSocio").submit(function() {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true; // ensure form still submits
    });
    
    // Un-disable form fields when page loads, in case they click back after submission
    $( "pesquisarSocio" ).find( ":input" ).prop( "disabled", false );
    
};
</script>
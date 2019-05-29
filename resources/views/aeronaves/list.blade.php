@extends('master')
@section('title', "Lista de Aeronaves")
@section('content')
@can('is-direcao', Auth::user())
<div style="padding-top: 10px; padding-bottom: 10px; position: relative; float: left"><a class="btn btn-primary" href="{{ route('aeronaves.create') }}"><i class="fas fa-plus"></i> Adicionar Aeronave</a></div>
@endcan
<div class="form-group" style="padding-top: 10px; padding-right: 10px; float: right;">            
        <form  method="GET" action="{{action('AeronaveController@index')}}" id="pesquisarAeronave">
            <div class="form-row ">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Matricula" name="matricula">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Marca" name="marca">
                </div>
            </div>    
            
            <div class="form-row">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Modelo" name="modelo">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Numero de lugares" name="num_lugares">
                </div>
            </div>
        
            
            <div class="form-row">
                
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-success mb-3" >
                        <i class="fas fa-search"></i> Pesquisar
                    </button>
                </div>
            </div>
        </form>
</div>
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
                <div class="dropdown navbar-nav ml-auto" style="text-align: center; margin: auto">
                  <button type="button" class="btn btn-outline-primary btn-block dropdown-toggle" data-toggle="dropdown">
                    Ações
                  <span class="caret"></span></button>
                  <div class="dropdown-menu ml-auto">
                    <li>
                        <a class="btn btn-sm btn-xs btn-primary" style="width: 100%" href="{{action('AeronaveController@edit', $aeronave->matricula)}}"><i class="fas fa-fighter-jet"></i> Editar</a></li>
                    <li>
                        <form action="{{action('AeronaveController@destroy', $aeronave->matricula)}}" method="POST" role="form" class="inline">
                        @csrf
                        @method('delete')
                        <input type="hidden" name="aeronave_matricula" value="{{ $aeronave->matricula }}">
                        {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Apagar', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-danger', 'style' => 'width: 100%', 'onclick' => "return confirm('Tem a certeza que quer apagar?')"]) !!}
                    </form>
                    </li>
                    <li>
                        <a href="{{route('aeronaves.json', $aeronave->matricula)}}" class="btn btn-sm btn-xs btn-secondary" style="width: 100%"><i class="fas fa-file-invoice"></i> Valores</a>
                    </li>
                  </div>
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

<script src="https://code.jquery.com/jquery-1.12.4.js" type="text/javascript"></script>
<script  type="text/javascript">
    $(document).ready(function () {
  
  // Remove empty fields from GET forms
  // Author: Bill Erickson
  // URL: http://www.billerickson.net/code/hide-empty-fields-get-form/
  
    // Change 'form' to class or ID of your specific form
    $("#pesquisarAeronave").submit(function() {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true; // ensure form still submits
    });
    
    // Un-disable form fields when page loads, in case they click back after submission
    $( "pesquisarAeronave" ).find( ":input" ).prop( "disabled", false );
    
});
</script>

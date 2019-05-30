@extends('master')
@section('title', "Lista de Movimentos")
@section('content')

<div class="row">
    <div class="col" style="padding-top: 55px; padding-left: 0px; position: relative; float: left"><a class="btn btn-primary" href="{{ route('movimentos.create') }}">Adicionar Movimento</a></div>
    <div class="col" style="padding-top: 55px; padding-left: 0px; position: relative; float: 
        left"><a class="btn btn-secondary" href="{{ route('movimentos.estatisticas') }}">Estatísticas</a></div>
    <div class="form-group" style="padding-top: 30px; padding-right: 10px; float: right;">            
        <form  method="GET" action="{{action('MovimentoController@index')}}" id="pesquisarMovimento">
            <div class="form-row ">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="ID do Movimento" name="id">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Aeronave" name="aeronave">
                </div>
                <div class="form-group">
                    {{ Form::select('natureza', [null => 'Tipo (Selecione)'] +  array('T' => 'Treino', 'I' => 'Instrução', 'E' => 'Especial'), null, ['id' => 'idNatureza', 'class' => 'form-control', 'name' => 'natureza'])}}
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Piloto" name="piloto">
                </div>
            </div>
            <div class="form-row">
                 <div class="form-group">
                    <input type="text" class="form-control" placeholder="Instrutor" name="instrutor">
                </div>
                <div class="form-group">
                    <input type="date" class="form-control" placeholder="inf" name="data_inf">
                </div>
                 <div class="form-group">
                    <input type="date" class="form-control" placeholder="sup" name="data_sup">
                </div>
                <div class="form-group form-check-inline" style="padding-left: 30px">
                    {{ Form::checkbox('confirmado', '1', false, ['class' => 'form-check-input']) }}
                    <label class="form-check-label">
                        Confirmado
                    </label>
                </div>
                //policie só para pilotos
                <div class="form-group form-check-inline" style="padding-left: 30px">
                    {{ Form::checkbox('meus_movimentos', '1', false, ['class' => 'form-check-input']) }}
                    <label class="form-check-label">
                        Meus Voos
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::select('ordenar', [null => 'Ordenar Por'] +  array('IDA' => 'ID Asc', 'IDD' => 'ID Desc', 'AA' => 'Aeronave Asc', 'AD' => 'Aeronave Desc', 'DA' => 'Data Asc', 'DD' => 'Data Desc', 'TA' => 'Tipo Asc', 'TD' => 'Tipo Desc'), null, ['id' => 'idOrdenar', 'class' => 'form-control', 'name' => 'ordenar'])}}
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm btn-success mb-3" >
                        <i class="fas fa-search"></i> Pesquisar
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
@if (count($movimentos))
 <form method="POST" action="{{action('MovimentoController@confirm')}}" id="confirmarMovimento">
    @csrf
    @method('PATCH')
    <div style="">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded table-responsive">
                <thead class="thead-light">
                <tr>
                    <th><input type="submit" name="confirmar_btn" class="btn btn-primary" id="btn-confirm" value="Confirmar Voos"></th>
                    <th>ID</th>
                    <th>Aeronave</th>
                    <th>Data</th>
                    <th>Hora Descolagem</th>
                    <th>Hora Aterragem</th>
                    <th>Tempo Voo</th>
                    <th>Natureza</th>
                    <th>Piloto</th>
                    <th>Cod. Aerodromo Partida</th>
                    <th>Cod. Aerodromo Chegada</th>
                    <th>Nº Aterreagens</th>
                    <th>Nº Descolagens</th>
                    <th>Nº Diario</th>
                    <th>Nº Serviço</th>
                    <th>Conta-Horas Inicial</th>
                    <th>Conta-Horas Final</th>
                    <th>Nº Pessoas a Bordo</th>
                    <th>Tipo de Instrução</th>
                    <th>Instrutor</th>
                    <th>Confirmado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimentos as $movimento)
                    <tr>
                        <td>
                            <input type="checkbox" name="confirmar[{{ $movimento->id }}]" value="{{ $movimento->id }}">
                        </td>
                        <td>{{ $movimento->id }}</td>
                        <td>{{ $movimento->aeronave }}</td>
                        <td>{{ $movimento->data }}</td>
                        <td>{{ date("H:i",strtotime($movimento->hora_descolagem)) }}</td>
                        <td>{{ date("H:i",strtotime($movimento->hora_aterragem)) }}</td>
                        <td>{{ $movimento->tempo_voo }}</td>
                        <td>@if($movimento->natureza == "T")
                                Treino
                            @elseif($movimento->natureza == "I")
                                Instrução
                            @else
                                Especial
                            @endif</td>
                        <td>@if(isset($movimento->piloto)){{ $movimento->piloto->nome_informal }}@endif</td>
                        <td>{{ $movimento->aerodromo_partida }}</td>
                        <td>{{ $movimento->aerodromo_chegada }}</td>
                        <td>{{ $movimento->num_aterragens }}</td>
                        <td>{{ $movimento->num_descolagens }}</td>
                        <td>{{ $movimento->num_diario }}</td>
                        <td>{{ $movimento->num_servico }}</td>
                        <td>{{ $movimento->conta_horas_inicio }}</td>
                        <td>{{ $movimento->conta_horas_fim }}</td>
                        <td>{{ $movimento->num_pessoas }}</td>
                        <td>@if(isset($movimento->tipo_instrucao))
                                @if($movimento->tipo_instrucao == "D")
                                    Duplo Comando
                                @else
                                    Solo
                                @endif
                            @else
                                Não é um voo de instrução
                            @endif</td>
                        <td>@if(isset($movimento->instrutor_id))
                                @if(isset($movimento->instrutor)){{ $movimento->instrutor->nome_informal }}@endif
                            @else
                                Não tem Instrutor
                            @endif</td>
                        <td>@if($movimento->confirmado == 1)
                                Sim
                            @else
                                Não
                            @endif</td>
                        <td>
                            <div style="text-align: center; margin: auto">
                            <a class="btn btn-sm btn-xs btn-primary rounded-pill" style="width: 100%" href="{{action('MovimentoController@edit', $movimento->id)}}">Editar</a>
                            </div>
                       </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
        </form>
    @else
    <div class="col-md-12">    
        <h2>Nenhum movimento encontrado </h2>
    </div>
@endif
</div>

{{ $movimentos->appends(request()->except('page'))->links() }}

@endsection
<script  type="text/javascript">
    window.onload = function(){
  
  // Remove empty fields from GET forms
  // Author: Bill Erickson
  // URL: http://www.billerickson.net/code/hide-empty-fields-get-form/
  
    // Change 'form' to class or ID of your specific form
    $("#pesquisarMovimento").submit(function() {
        $(this).find(":input").filter(function(){ return !this.value; }).attr("disabled", "disabled");
        return true; // ensure form still submits
    });
    
    // Un-disable form fields when page loads, in case they click back after submission
    $( "pesquisarMovimento" ).find( ":input" ).prop( "disabled", false );
    
};
</script>
<script type="text/javascript">
  $("#btn-confirm").change(function () {
    $("input:confirmar").prop('checked', $(this).prop("checked"));
});
</script>
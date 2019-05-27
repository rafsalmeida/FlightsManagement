@extends('master')
@section('title', "Lista de Movimentos")
@section('content')

<div class="row">
    <div class="col" style="padding-top: 55px; padding-left: 0px; position: relative; float: left"><a class="btn btn-primary" href="{{ route('movimentos.create') }}">Adicionar Movimento</a></div>
    <div class="form-group" style="padding-top: 30px; padding-right: 10px; float: right;">            
        <form  method="GET" action="{{action('MovimentoController@index')}}" id="pesquisarSocio">
            <div class="form-row ">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="ID do Movimento" name="id">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Aeronave" name="aeronave">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Piloto" name="nome_informal_piloto">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="Instrutor" name="nome_informal_instrutor">
                </div>
                <div class="form-group">
                    {{ Form::select('natureza', [null => 'Tipo (Selecione)'] +  array('T' => 'Treino', 'I' => 'Instrução', 'E' => 'Especial'), null, ['id' => 'idNatureza', 'class' => 'form-control', 'name' => 'natureza'])}}
                </div>
                <div class="form-group form-check-inline" style="padding-left: 30px">
                    {{ Form::checkbox('confirmado', '1', false, ['class' => 'form-check-input']) }}
                    <label class="form-check-label">
                        Confirmado
                    </label>
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
    <div style="overflow-x: auto; overflow-y: hidden;">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
                <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Aeronave</th>
                    <th>&emsp;Data&emsp;&emsp;&emsp;</th>
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
                    <th>Observações</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimentos as $movimento)
                    <tr>
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
                        <td>{{ \app\User::find($movimento->piloto_id)->nome_informal }}</td>
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
                                {{ \app\User::find($movimento->instrutor_id)->nome_informal }}
                            @else
                                Não tem Instrutor
                            @endif</td>
                        <td>@if($movimento->confirmado == 1)
                                Sim
                            @else
                                Não
                            @endif</td>
                        <td>{{ $movimento->observacoes }}</td>
                        <td>
                            <div style="text-align: center; margin: auto">
                            <a class="btn btn-sm btn-xs btn-primary rounded-pill" style="width: 100%" href="{{action('MovimentoController@edit', $movimento->id)}}">Editar</a>
                            <form method="POST" action="#" role="form" class="inline">
                                @csrf
                                @method('delete')
                                @include('partials.deletemodal')
                                <input type="hidden" name="aeronave_matricula" value="{{ $movimento->id }}">
                                <button type="button" class="btn btn-sm btn-xs btn-danger rounded-pill" data-target="#deleteconfirm" data-toggle="modal" style="width: 100%">Apagar</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    @else
    <h2>Nenhum movimento encontrado </h2>
@endif
</div>

{{ $movimentos->links() }}

@endsection



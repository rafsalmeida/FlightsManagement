@extends('master')
@section('title', "Lista de Movimentos")
@section('content')

<div style="padding: 2vh 0"><a class="btn btn-primary" href="{{ route('movimentos.create') }}">Adicionar Movimento</a></div>
@if (count($movimentos))
    <div style="overflow-x: auto;">
        <table class="table table-bordered shadow p-3 mb-5 bg-white rounded" >
                <thead class="thead-light">
                <tr>
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
                        <td>{{ $movimento->id }}</td>
                        <td>{{ $movimento->aeronave }}</td>
                        <td>{{ $movimento->data }}</td>
                        <td>{{ $movimento->hora_descolagem }}</td>
                        <td>{{ $movimento->hora_aterragem }}</td>
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
                                {{ $movimento->instrutor_id }}
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

{{ $movimentos->links() }}

@endsection



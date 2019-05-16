@extends('master')
@section('title', "Lista de Movimentos")
@section('content')
<div style="padding: 2vh 0"><a class="btn btn-primary" href="{{ route('movimentos.create') }}">Adicionar Movimento</a></div>
@if (count($movimentos))
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
    <thead class="thead-light">
        <tr>
            <th>ID</th>
            <th>Aeronave</th>
            <th>Data</th>
            <th>Natureza</th>
            <th>Confirmado</th>
            <th>Piloto</th>
            <th>Instrutor</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($movimentos as $movimento)
        <tr>
            <td>{{ $movimento->id }}</td>
            <td>{{ $movimento->aeronave }}</td>
            <td>{{ $movimento->data }}</td>
            <td>@if($movimento->natureza == "T")
                    Treino
                @elseif ($movimento->natureza == "I")
                    Instrução
                @else
                    Especial
                @endif</td>
            <td>@if($movimento->confirmado == 1)
                    Sim
                @else
                    Não
                @endif</td>
            <td>{{ $movimento->piloto_id }}</td>
            <td>@if(isset($movimento->instrutor_id))
                    {{ $movimento->instrutor_id }}
                @else
                    Não tem Instrutor
                @endif</td>
            <td>
                <div style="text-align: center; margin: auto">
                <a class="btn btn-sm btn-xs btn-primary rounded-pill" style="width: 100%" href="#">Editar</a>
                <form action="#" method="POST" role="form" class="inline">
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
    </table>
    @else
    <h2>Nenhum movimento encontrado </h2>
@endif

{{ $movimentos->links() }}

@endsection



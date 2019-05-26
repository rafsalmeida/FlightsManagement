@extends('master')
@section('title', "Lista de Pilotos")
@section('content')
<div style="padding-top: 10px">
@if (count($pilotos))
    <br>
    <h4>{{$title}}</h4>
    <br>
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Nome Informal</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($pilotos as $piloto)
        <tr>
            <td>{{ $piloto->id }}</td>
            <td>{{ $piloto->nome_informal }}</td>


        </tr>
    @endforeach
    </table>
</div>


@else
    <h2>Nenhum piloto encontrado </h2>
@endif


{{ $pilotos->links() }}

@endsection

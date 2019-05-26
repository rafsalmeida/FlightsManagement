@extends('master')
@section('title', "Lista de Pilotos")
@section('content')
<div style="padding-top: 10px">
@if (count($pilotos))
    <br>
    <h3>{{$title}}</h3>
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
    <thead class="thead-light">
        <tr>
            <th>Id</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($pilotos as $piloto)
        <tr>
            <td>{{ $piloto->piloto_id }}</td>


        </tr>
    @endforeach
    </table>
</div>


@else
    <h2>Nenhum piloto encontrad </h2>
@endif


{{ $pilotos->links() }}

@endsection

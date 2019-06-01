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
            <th style="max-width: 2vw"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pilotos as $piloto)
        <tr>
            <td>{{ $piloto->id }}</td>
            <td>{{ $piloto->nome_informal }}</td>
            <td style="max-width: 2vw">
                <form method="POST" action="{{route('pilotos.delete',['aeronave' => $aeronave->matricula,'piloto' => $piloto->id])}}"  role="form" class="inline">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="_method" value="delete">
                    {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Remover', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-danger rounded-pill', 'onclick' => "return confirm('Tem a certeza que quer remover este piloto da lista de pilotos autorizados?')"]) !!}
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>
@else
<div class="col-md-12">
    <h2>Nenhum piloto encontrado </h2>
</div>
@endif

{{ $pilotos->appends(request()->except('autorizados'))->links() }}

<div style="padding-top: 10px">
    @if (count($pilotosNaoAutorizados))
    <br>
    <h4>Pilotos não autorizados </h4>
    <br>
    <table class="table table-bordered shadow p-3 mb-5 bg-white rounded">
        <thead class="thead-light">
        <tr>
            <th>Id</th>
            <th>Nome Informal</th>
            <th style="max-width: 2vw"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($pilotosNaoAutorizados as $pilotoNaoAutorizado)
        <tr>
            <td>{{ $pilotoNaoAutorizado->id }}</td>
            <td>{{ $pilotoNaoAutorizado->nome_informal }}</td>
            <td style="max-width: 2vw">
                <form method="POST" action="{{route('pilotos.add',['aeronave' => $aeronave->matricula,'piloto' => $pilotoNaoAutorizado->id])}}"  role="form" class="inline">
                    @csrf
                    <input type="hidden" name="_method" value="post">
                    {!! Form::button('<i class="fas fa-user-plus"></i> Adicionar', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-primary rounded-pill', 'onclick' => "return confirm('Tem a certeza que quer adicionar este piloto à lista de pilotos autorizados?')"]) !!}
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</div>


@else
<div class="col-md-12">
    <h2>Nenhum piloto encontrado </h2>
</div>
@endif


{{ $pilotosNaoAutorizados->appends(request()->except('naoAutorizados'))->links() }}

@endsection

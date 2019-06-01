@extends('master')
@section('title',"Editar movimento")
@section('content')

@include('movimentos.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
@if(session('unsuccess'))
    @include('partials.unsuccess')
@endif
@if(session('danger'))
    @include('partials.errors')
@endif

<form method="POST" action="{{ action('MovimentoController@update', $movimento->id)}}" class="form-group">
	@method('PUT')
	@csrf
    <input type="hidden" name="id" value="{{ $movimento->id }}" />
    <div class="container" >
    	@yield('form')
    </div>
    <div class="form-group">
        @can('is-direcao', Auth::user())
        <button type="submit" class="btn btn-primary" name="confirmar"><i class="fas fa-check-double"></i> Confirmar Voo</button>
        @endcan
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <a class="btn btn-default" href="{{action('MovimentoController@index')}}" name="cancel">Cancelar</a>
    </div>
</form>
@can('is-direcao-piloto', Auth::user())
<form method="POST" action="{{action('MovimentoController@destroy', $movimento->id)}}" role="form" class="inline">
    @csrf
    @method('delete')
    <input type="hidden" name="movimento_id" value="{{ $movimento->id }}">
    {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Apagar', ['type' => 'submit', 'class' => 'btn btn-danger', 'onclick' => "return confirm('Tem a certeza que quer apagar?')"]) !!}
</form>
@endcan
@endsection

@extends('master')
@section('title',"Editar movimento")
@section('content')

@include('movimentos.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
<form method="POST" action="{{ action('MovimentoController@update', $movimento->id)}}" class="form-group">
	@method('PUT')
	@csrf
    <input type="hidden" name="id" value="{{ $movimento->id }}" />
    <div class="container" style="padding-top: 15px">
    	@yield('form')
    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="confirmar">Confirmar Voo</button>
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancelar</button>
    </div>
</form>
<form method="POST" action="{{action('MovimentoController@destroy', $movimento->id)}}" role="form" class="inline">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="movimento_id" value="{{ $movimento->id }}">
                                {!! Form::button('<i class="fas fa-exclamation-triangle"></i> Apagar', ['type' => 'submit', 'class' => 'btn btn-sm btn-xs btn-danger', 'onclick' => "return confirm('Tem a certeza que quer apagar?')"]) !!}
                            </form>
@endsection
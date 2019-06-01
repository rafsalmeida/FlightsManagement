@extends('master')
@section('title',"Editar Sócio")
@section('content')

@include('socios.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
@if(session('unsuccess'))
    @include('partials.unsuccess')
@endif

<form  method="POST" action="{{ action('SocioController@update', $socio->id)}}"  class="form-group" enctype="multipart/form-data">
	@method('PUT')
	@csrf
    <input type="hidden" name="id" value="{{ $socio->id }}" />
    <div class="container" style="padding-top: 15px">
    	@yield('form')
    </div>
    <div>
    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Submeter</button>
        <a class="btn btn-default" href="{{action('SocioController@index')}}" name="cancel">Cancelar</a>
        @if(!$socio->hasVerifiedEmail())
            <a href="{{ action('SocioController@enviarEmailConfirmacao',$socio->id) }} " class="btn btn-primary">Reeviar Email de Verficação</a>
        @endif
    </div>
</form>
@endsection
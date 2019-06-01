@extends('master')
@section('title',"Adicionar Sócio")
@section('content')
@include('socios.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
<form action="{{ action('SocioController@store')}}" method="post" class="form-group" enctype="multipart/form-data">
	@csrf
    <div class="container" style="padding-top: 15px">
    	@yield('form')
    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Adicionar</button>
        <a class="btn btn-default" href="{{action('SocioController@index')}}" name="cancel">Cancelar</a>
    </div>
</form>
@endsection
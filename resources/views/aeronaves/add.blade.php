@extends('master')
@section('title',"Adicionar Aeronave")
@section('content')
@include('aeronaves.partials.add-edit')
@if (count($errors) > 0)
    @include('partials.errors')
@endif
<form action="{{ action('AeronaveController@store')}}" method="post" class="form-group">
	@csrf
    <div class="container" style="padding-top: 15px">
    	@yield('form')
    </div>
    <div class="form-group" style="padding-left: 15px;">
        <button type="submit" class="btn btn-success" name="ok">Adicionar</button>
        <button type="submit" class="btn btn-default" name="cancel">Cancelar</button>
    </div>
</form>
@endsection

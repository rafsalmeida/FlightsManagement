@section('form')
<div class="form-group">
    <label for="inputMatricula">Matrícula</label>
    <input
        type="text" class="form-control"
        name="matricula" id="inputMatricula"
        placeholder="Matricula" value="@if(isset($aeronave)){{old('matricula', $aeronave->matricula)}}@endif" />
    @if ($errors->has('matricula'))
    <em>{{ $errors->first('matricula') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputMarca">Marca</label>
    <input
        type="text" class="form-control"
        name="marca" id="inputMarca"
        placeholder="Marca" value="@if(isset($aeronave)){{ old('marca', $aeronave->marca) }}@endif" />
    @if ($errors->has('marca'))
    <em>{{ $errors->first('marca') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputModelo">Modelo</label>
    <input
        type="text" class="form-control"
        name="modelo" id="inputModelo"
        placeholder="Modelo" value="@if(isset($aeronave)){{ old('modelo', $aeronave->modelo) }}@endif" />
    @if ($errors->has('modelo'))
    <em>{{ $errors->first('modelo') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputLugares">Número de Lugares</label>
    <input
        type="text" class="form-control"
        name="num_lugares" id="inputLugares"
        placeholder="NumLugares" value="@if(isset($aeronave)){{ old('num_lugares', $aeronave->num_lugares) }}@endif" />
    @if ($errors->has('num_lugares'))
    <em>{{ $errors->first('num_lugares') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputContaHoras">Conta-Horas</label>
    <input
        type="text" class="form-control"
        name="conta_horas" id="inputContaHoras"
        placeholder="ContaHoras" value="@if(isset($aeronave)){{ old('conta_horas', $aeronave->conta_horas) }}@endif" />
    @if ($errors->has('conta_horas'))
    <em>{{ $errors->first('conta_horas') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputPrecoHora">Preço/Hora</label>
    <input
        type="text" class="form-control"
        name="preco_hora" id="inputPrecoHora"
        placeholder="PrecoHora" value="@if(isset($aeronave)){{ old('preco_hora', $aeronave->preco_hora) }}@endif" />
    @if ($errors->has('preco_hora'))
    <em>{{ $errors->first('preco_hora') }}</em>
    @endif
</div>
@endsection
@section('form')
<div class="form-group">
    <label for="inputData">Data</label>
    <input
        type="date" class="form-control"
        name="data" id="inputData"
        placeholder="Data" value="@if(isset($movimento )){{old('data', $movimento->data)}}@endif" />
    @if ($errors->has('data'))
        <em>{{ $errors->first('data') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputHoraDescolagem">Hora Descolagem</label>
    <input
        type="datetime-local" class="form-control"
        name="hora_descolagem" id="inputHoraDescolagem"
        placeholder="HoraDescolagem" value="@if(isset($movimento)){{ old('hora_descolagem', $movimento->hora_descolagem) }}@endif" />
    @if ($errors->has('marca'))
        <em>{{ $errors->first('marca') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputHoraAterragem">Hora Aterragem</label>
    <input
        type="datetime-local" class="form-control"
        name="hora_aterragem" id="inputHoraAterragem"
        placeholder="HoraAterragem" value="@if(isset($movimento)){{ old('hora_aterragem', $movimento->hora_aterragem) }}@endif" />
    @if ($errors->has('hora_aterragem'))
        <em>{{ $errors->first('hora_aterragem') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputAeronave">Matricula Aeronave</label>
    <input
        type="text" class="form-control"
        name="aeronave" id="inputAeronave"
        placeholder="Aeronave" value="@if(isset($movimento)){{ old('aeronave', $movimento->aeronave) }}@endif" />
    @if ($errors->has('aeronave'))
        <em>{{ $errors->first('aeronave') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNDiario">Nº de Diario</label>
    <input
        type="number" class="form-control"
        name="num_diario" id="inputNDiario"
        placeholder="NDiario" value="@if(isset($movimento)){{ old('num_diario', $movimento->num_diario) }}@endif" />
    @if ($errors->has('num_diario'))
        <em>{{ $errors->first('num_diario') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNServico">Nº de Serviço</label>
    <input
        type="number" class="form-control"
        name="num_servico" id="inputNServico"
        placeholder="NServico" value="@if(isset($movimento)){{ old('num_servico', $movimento->num_servico) }}@endif" />
    @if ($errors->has('num_servico'))
        <em>{{ $errors->first('num_servico') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputPiloto">Nº do Piloto</label>
    <input
        type="number" class="form-control"
        name="piloto_id" id="inputPiloto"
        placeholder="Piloto" value="@if(isset($movimento)){{ old('piloto_id', $movimento->piloto_id) }}@endif" />
    @if ($errors->has('piloto_id'))
        <em>{{ $errors->first('piloto_id') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNVoo">Natureza do Voo</label>
    <input
        type="text" class="form-control"
        name="natureza" id="inputNVoo"
        placeholder="NVoo" value="@if(isset($movimento)){{ old('natureza', $movimento->natureza) }}@endif" />
    @if ($errors->has('natureza'))
        <em>{{ $errors->first('natureza') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputAerPartida">Aerodromo de Partida</label>
    <input
        type="text" class="form-control"
        name="aerodromo_partida" id="inputAerPartida"
        placeholder="AerPartida" value="@if(isset($movimento)){{ old('aerodromo_partida', $movimento->aerodromo_partida) }}@endif" />
    @if ($errors->has('aerodromo_partida'))
        <em>{{ $errors->first('aerodromo_partida') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputAerChegada">Aerodromo de Chegada</label>
    <input
        type="text" class="form-control"
        name="aerodromo_chegada" id="inputAerChegada"
        placeholder="AerChegada" value="@if(isset($movimento)){{ old('aerodromo_chegada', $movimento->aerodromo_chegada) }}@endif" />
    @if ($errors->has('aerodromo_chegada'))
        <em>{{ $errors->first('aerodromo_chegada') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNAterragens">Nº de Aterragens</label>
    <input
        type="number" class="form-control"
        name="num_aterragens" id="inputNAterragens"
        placeholder="NAterragens" value="@if(isset($movimento)){{ old('num_aterragens', $movimento->num_aterragens) }}@endif" />
    @if ($errors->has('num_aterragens'))
        <em>{{ $errors->first('num_aterragens') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNDescolagens">Nº de Descolagens</label>
    <input
        type="number" class="form-control"
        name="num_descolagens" id="inputNDescolagens"
        placeholder="NDescolagens" value="@if(isset($movimento)){{ old('num_descolagens', $movimento->num_descolagens) }}@endif" />
    @if ($errors->has('num_descolagens'))
        <em>{{ $errors->first('num_descolagens') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNPessoas">Nº de Pessoas a Bordo</label>
    <input
        type="number" class="form-control"
        name="num_pessoas" id="inputNPessoas"
        placeholder="NPessoas" value="@if(isset($movimento)){{ old('num_pessoas', $movimento->num_pessoas) }}@endif" />
    @if ($errors->has('num_pessoas'))
        <em>{{ $errors->first('num_pessoas') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputCHInicial">Conta-horas Inicial</label>
    <input
        type="number" class="form-control"
        name="conta_horas_inicio" id="inputCHInicial"
        placeholder="CHInicial" value="@if(isset($movimento)){{ old('conta_horas_inicio', $movimento->conta_horas_inicio) }}@endif" />
    @if ($errors->has('conta_horas_inicio'))
        <em>{{ $errors->first('conta_horas_inicio') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputCHFinal">Conta-horas Final</label>
    <input
        type="number" class="form-control"
        name="conta_horas_fim" id="inputCHFinal"
        placeholder="CHFinal" value="@if(isset($movimento)){{ old('conta_horas_fim', $movimento->conta_horas_fim) }}@endif" />
    @if ($errors->has('conta_horas_fim'))
        <em>{{ $errors->first('conta_horas_fim') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputTempVoo">Tempo de Voo</label>
    <input
        type="number" class="form-control"
        name="tempo_voo" id="inputTempVoo"
        placeholder="TempVoo" value="@if(isset($movimento)){{ old('tempo_voo', $movimento->tempo_voo) }}@endif" />
    @if ($errors->has('tempo_voo'))
        <em>{{ $errors->first('tempo_voo') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputPreVoo">Preço do Voo</label>
    <input
        type="number" class="form-control"
        name="preco_voo" id="inputPreVoo"
        placeholder="PreVoo" value="@if(isset($movimento)){{ old('preco_voo', $movimento->preco_voo) }}@endif" />
    @if ($errors->has('preco_voo'))
        <em>{{ $errors->first('preco_voo') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputMPagamento">Modo de Pagamento</label>
    <input
        type="text" class="form-control"
        name="modo_pagamento" id="inputMPagamento"
        placeholder="MPagamento" value="@if(isset($movimento)){{ old('modo_pagamento', $movimento->modo_pagamento) }}@endif" />
    @if ($errors->has('modo_pagamento'))
        <em>{{ $errors->first('modo_pagamento') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNRecibo">Nº do Recibo</label>
    <input
        type="number" class="form-control"
        name="num_recibo" id="inputNRecibo"
        placeholder="NRecibo" value="@if(isset($movimento)){{ old('num_recibo', $movimento->num_recibo) }}@endif" />
    @if ($errors->has('num_recibo'))
        <em>{{ $errors->first('num_recibo') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputObs">Observações</label>
    <input
        type="text" class="form-control"
        name="observacoes" id="inputObs"
        placeholder="Obs" value="@if(isset($movimento)){{ old('observacoes', $movimento->observacoes) }}@endif" />
    @if ($errors->has('observacoes'))
        <em>{{ $errors->first('observacoes') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputTInstrucao">Tipo de Instrução</label>
    <input
        type="text" class="form-control"
        name="tipo_instrucao" id="inputRInstrucao"
        placeholder="TInstrucao" value="@if(isset($movimento)){{ old('tipo_instrucao', $movimento->tipo_instrucao) }}@endif" />
    @if ($errors->has('tipo_instrucao'))
        <em>{{ $errors->first('tipo_instrucao') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputInstrutor">Instrutor Id</label>
    <input
        type="number" class="form-control"
        name="instrutor_id" id="inputInstrutor"
        placeholder="Instrutor" value="@if(isset($movimento)){{ old('instrutor_id', $movimento->instrutor_id) }}@endif" />
    @if ($errors->has('instrutor_id'))
        <em>{{ $errors->first('instrutor_id') }}</em>
    @endif
</div>
@endsection
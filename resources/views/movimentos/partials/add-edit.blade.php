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
        type="time" class="form-control"
        name="hora_descolagem" id="inputHoraDescolagem"
        placeholder="aaaa-mm-dd hh:mm:ss" value="@if(isset($movimento)){{ old('hora_descolagem', date('H:i',strtotime($movimento->hora_descolagem))) }}@endif" />
    @if ($errors->has('hora_descolagem'))
        <em>{{ $errors->first('hora_descolagem') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputHoraAterragem">Hora Aterragem</label>
    <input
        type="time" class="form-control"
        name="hora_aterragem" id="inputHoraAterragem"
        placeholder="aaaa-mm-dd hh:mm:ss" value="@if(isset($movimento)){{ old('hora_aterragem', date('H:i',strtotime($movimento->hora_aterragem))) }}@endif" />
    @if ($errors->has('hora_aterragem'))
        <em>{{ $errors->first('hora_aterragem') }}</em>
    @endif
</div>
<div class="form-group">
    <form id="getMatricula">
        <label >Matrícula Aeronave</label>
        @if(isset($movimento->aeronave))
            {!! Form::select('aeronave', $aeronaves, $movimento->aeronave, ['class' => 'form-control', 'id' => 'matricula']) !!}
        @else
            {!! Form::select('aeronave', $aeronaves, null, ['class' => 'form-control', 'id' => 'matricula'])!!}
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
        placeholder="Piloto" value="@if(isset($movimento)){{ old('piloto_id', $movimento->piloto_id) }}@else{{ Auth::user()->id }}@endif" />
    @if ($errors->has('piloto_id'))
        <em>{{ $errors->first('piloto_id') }}</em>
    @endif
</div>

<div class="form-group">
    <label for="inputType">Natureza do Voo</label>
    <div>
        @if(isset($movimento))
            {{ Form::select('natureza', [null => 'Natureza (Selecione)'] + array('T' => 'Treino', 'I' => 'Instrução', 'E' => 'Especial'), $movimento->natureza, ['id' => 'natureza', 'class' => 'form-control']) }}
        @else
            {{ Form::select('natureza', [null => 'Natureza (Selecione)'] +  array('T' => 'Treino', 'I' => 'Instrução', 'E' => 'Especial'), null, ['id' => 'natureza', 'class' => 'form-control'])}}
        @endif
    </div>
</div>

<div class="form-group">
    <label >Aerodromo de Partida</label>
        @if(isset($movimento->aerodromo_partida))
            {!! Form::select('aerodromo_partida', $aerodromos, $movimento->aerodromo_partida, ['class' => 'form-control']) !!}
        @else
            {!! Form::select('aerodromo_partida', $aerodromos, null, ['class' => 'form-control'])!!}
        @endif
</div>

<div class="form-group">
    <label >Aerodromo de Chegada</label>
        @if(isset($movimento->aerodromo_chegada))
            {!! Form::select('aerodromo_chegada', $aerodromos, $movimento->aerodromo_chegada, ['class' => 'form-control']) !!}
        @else
            {!! Form::select('aerodromo_chegada', $aerodromos, null, ['class' => 'form-control'])!!}
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
        type="number" class="form-control conta-horas"
        name="conta_horas_inicio" id="conta_horas_inicio"
        placeholder="CHInicial" value="@if(isset($movimento)){{ old('conta_horas_inicio', $movimento->conta_horas_inicio) }}@endif" />
    @if ($errors->has('conta_horas_inicio'))
        <em>{{ $errors->first('conta_horas_inicio') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputCHFinal">Conta-horas Final</label>
    <input
        type="number" class="form-control conta-horas"
        name="conta_horas_fim" id="conta_horas_fim"
        placeholder="CHFinal" value="@if(isset($movimento)){{ old('conta_horas_fim', $movimento->conta_horas_fim) }}@endif" />
    @if ($errors->has('conta_horas_fim'))
        <em>{{ $errors->first('conta_horas_fim') }}</em>
    @endif
</div>
<div class="form-group">
    <label>Tempo de voo:</label>
    <p id="show_tempo"></p>
    <input type="hidden" name="tempo_voo" id="tempo_voo" />
</div>
<div class="form-group">
    <label>Preço de voo:</label>
    <p id="show_preco"></p>
    <input type="hidden" name="preco_voo" id="preco_voo" />
</div>
<div class="form-group">
    <label for="inputTPagamento">Modo de Pagamento</label>
    <div class='radio' name='modo_pagamento'>
        @if(isset($movimento))
        <div>
            {!! Form::radio('modo_pagamento','N', $movimento->modo_pagamento == 'N')  !!}
            <label class="form-check-label">Numerário</label>
        </div>
        <div>
            {!! Form::radio('modo_pagamento','M',$movimento->modo_pagamento == 'M')  !!}
            <label class="form-check-label">Multibanco</label>
        </div>
        <div>
            {!! Form::radio('modo_pagamento','T',$movimento->modo_pagamento == 'T')  !!}
            <label class="form-check-label">Transferência</label>
        </div>
        <div>
            {!! Form::radio('modo_pagamento','P',$movimento->modo_pagamento == 'P')  !!}
            <label class="form-check-label">Pacote de horas</label>
        </div>
        @else
        <div>
            {!! Form::radio('modo_pagamento','N')  !!}
            <label class="form-check-label">Numerário</label>
        </div>
        <div>
            {!! Form::radio('modo_pagamento','M')  !!}
            <label class="form-check-label">Multibanco</label>
        </div>
        <div>
            {!! Form::radio('modo_pagamento','T')  !!}
            <label class="form-check-label">Transferência</label>
        </div>
        <div>
            {!! Form::radio('modo_pagamento','P')  !!}
            <label class="form-check-label">Pacote de horas</label>
        </div>
        @endif
    </div>
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
    <textarea class="form-control"
        name="observacoes">
         @if(isset($movimento)){{ old('observacoes', $movimento->observacoes) }}@endif </textarea>
    @if ($errors->has('observacoes'))
        <em>{{ $errors->first('observacoes') }}</em>
    @endif
</div>
<div id="instrucao_form">
<div class="form-group">
    <label for="inputTInstrucao">Tipo de Instrução</label>
    <div class='radio' name='tipo_instrucao'>
        @if(isset($movimento))
        <div>
            {!! Form::radio('tipo_instrucao','D', $movimento->tipo_instrucao == 'D')  !!}
            <label class="form-check-label">Duplo Comando</label>
        </div>
        <div>
            {!! Form::radio('tipo_instrucao','S',$movimento->tipo_instrucao == 'S')  !!}
            <label class="form-check-label">Solo</label>
        </div>
        @else
        <div>
            {!! Form::radio('tipo_instrucao','D')  !!}
            <label class="form-check-label">Duplo Comando</label>
        </div>
        <div>
            {!! Form::radio('tipo_instrucao','S')  !!}
            <label class="form-check-label">Solo</label>
        </div>
        @endif
    </div>
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
</div>
<div id="form-conflito" style="display: none;">
    <div class="form-group">
        <label for="justificacao_conflito">Justificação</label>
        <textarea class="form-control"
        name="justificacao_conflito">
            @if(isset($movimento)){{ old('justficacao_conflito', $movimento->justificacao_conflito) }}@endif </textarea>
    </div>
</div>
<input type="hidden" name="hasConflito" value="0{{ old('hasConflito')}}" id="conflito"/>
<input type="hidden" name="conflitoConfirmed" value="0" id="conflitoConfirmed"/>
<p id="demo"></p>
<script type="text/javascript">
    
    $(function() {

      $("#natureza").change(function() {
        var val = $(this).val();
        if (val === "I") {
          $("#instrucao_form").show();
        } else {
          $("#instrucao_form").hide();
        }
      }).trigger('change');
    
        var val = $("#conflito").val();
        if (val == 1) {
          let confirmation = confirm("Os valores dos conta-horas estão com conflitos. Deseja continuar?");
          if(confirmation){
            $("#form-conflito").show();
        } else {
            $("#form-conflito").hide();
            $("#conta_horas_inicio").val("");
            

        }
        }

    });





    $(function() {
      $("#matricula").change(function() {
        $.ajax({
          type    :"GET",
          url     :"http://ainet.prj31.test/aeronaves/"+document.getElementById("matricula").value+"/precos_tempos",
          dataType:"json",
          success :function(response) {
            $(".conta-horas").on("change", function(){

                var conta_horas_inicio = document.getElementById("conta_horas_inicio").value;
                var conta_horas_fim = document.getElementById("conta_horas_fim").value;    
                var diferenca = conta_horas_fim - conta_horas_inicio;
                var resto = diferenca % 10;
                var decima = Math.floor(diferenca/10);
                var tempo_voo = response[resto-1].minutos;
                var conta_horas_10 = response[9].minutos;
                tempo_voo +=(conta_horas_10*decima);
                document.getElementById("show_tempo").innerHTML = tempo_voo;
                document.getElementById("tempo_voo").value = tempo_voo;

                var preco_voo = response[resto-1].preco;
                var conta_horas_10 = response[9].preco;
                preco_voo +=(conta_horas_10*decima);
                document.getElementById("show_preco").innerHTML = preco_voo;
                document.getElementById("preco_voo").value = preco_voo;
     
            });
            
          },
          error: function(e) {
            console.log(e.responseText);
          }
        });
    }).trigger('change');
});


</script>

@endsection
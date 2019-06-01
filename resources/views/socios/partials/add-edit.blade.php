@section('form')

<div class="form-group">
    <label for="inputNumSocio">Nº de sócio</label>
    <input
        type="text" class="form-control"
        name="num_socio" id="inputNumSocio"
        placeholder="Numero de Sócio" value="@if(isset($socio)){{old('num_socio', $socio->num_socio)}}@else {{old('num_socio')}} @endif" @cannot('is-direcao', Auth::user()){{ "readonly" }}@endcannot/>
    @if ($errors->has('num_socio'))
    <em>{{ $errors->first('num_socio') }}</em>
    @endif

</div>
<div class="form-group">
    <label for="inputNome">Nome</label>
    <input
        type="text" class="form-control"
        name="name" id="inputNome"
        placeholder="Nome" value="@if(isset($socio)){{ old('name', $socio->name) }}@else {{old('name')}}@endif" />
    @if ($errors->has('name'))
    <em>{{ $errors->first('name') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNomeInformal">Nome Informal</label>
    <input
        type="text" class="form-control"
        name="nome_informal" id="inputNomeInformal"
        placeholder="Nome Informal" value="@if(isset($socio)){{ old('nome_informal', $socio->nome_informal) }}@else {{old('nome_informal')}}@endif" />
    @if ($errors->has('nome_informal'))
    <em>{{ $errors->first('nome_informal') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputSexo">Sexo</label>
    <div class='radio'>
        @if(isset($socio))
        <div>
            {!! Form::radio('sexo','F', $socio->sexo == 'F', [Auth::user()->direcao == 1 ? null : 'readonly'])  !!}
            <label class="form-check-label">Feminino</label>
        </div>
        <div>
            {!! Form::radio('sexo','M',$socio->sexo == 'M', [Auth::user()->direcao == 1 ? null : 'readonly'])  !!}
            <label class="form-check-label">Masculino</label>
        </div>
        @else
        <div>
            {!! Form::radio('sexo','F')  !!}
            <label class="form-check-label">Feminino</label>
        </div>
        <div>
            {!! Form::radio('sexo','M')  !!}
            <label class="form-check-label">Masculino</label>
        </div>
        @endif
    </div>


</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email" value="@if(isset($socio)){{ old('email', $socio->email) }}@else {{old('email')}}@endif" />
    @if ($errors->has('email'))
    <em>{{ $errors->first('email') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNif">NIF</label>
    <input
        type="text" class="form-control"
        name="nif" id="inputNif"
        placeholder="Nif" value="@if(isset($socio)){{ old('nif', $socio->nif) }}@else {{old('nif')}}@endif" />
    @if ($errors->has('nif'))
    <em>{{ $errors->first('nif') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputDataNascimento">Data de Nascimento</label>
    <input
        type="date" class="form-control"
        name="data_nascimento" id="inputDataNascimento"
        placeholder="Data de Nascimento" value="@if(isset($socio)){{ old('data_nascimento', $socio->data_nascimento) }}@else {{old('data_nascimento')}}@endif" />
    @if ($errors->has('data_nascimento'))
    <em>{{ $errors->first('data_nascimento') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputTelefone">Telefone</label>
    <input
        type="text" class="form-control"
        name="telefone" id="inputTelefone"
        placeholder="Telefone" value="@if(isset($socio)){{ old('telefone', $socio->telefone) }}@else {{old('telefone')}}@endif" />
    @if ($errors->has('telefone'))
    <em>{{ $errors->first('telefone') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputEndereco">Endereco</label>
    <div>
        <textarea name="endereco" rows="4" cols="50">
        @if(isset($socio))
            {{ old('endereco', $socio->endereco) }}
        @endif
        </textarea>
    </div>

    @if ($errors->has('endereco'))
    <em>{{ $errors->first('endereco') }}</em>
    @endif
</div>

<div class="form-group">
    <label for="inputQuotas">Quotas</label>
    <div class='radio'>
        @if(isset($socio))
        <div>
            {!! Form::radio('quota_paga','1',$socio->quota_paga == '1', [Auth::user()->direcao == 1 ? null : 'readonly'])  !!}
            <label class="form-check-label">Pagas</label>
        </div>
        <div>
            {!! Form::radio('quota_paga','0',$socio->quota_paga == '0', [Auth::user()->direcao == 1 ? null : 'readonly'])  !!}
            <label class="form-check-label">Não pagas</label>
        </div>
        @else
        <div>
            {!! Form::radio('quota_paga','1')  !!}
            <label class="form-check-label">Pagas</label>
        </div>
        <div>
            {!! Form::radio('quota_paga','0')  !!}
            <label class="form-check-label">Não pagas</label>
        </div>
        @endif
    </div>
</div>
@if(isset($socio))
<div class="form-group">
    <label for="inputAtivo">Ativo</label>
    <div>
        {!! Form::radio('ativo','1',$socio->ativo == '1', [Auth::user()->direcao == 1 ? null : 'readonly'])  !!}
        <label class="form-check-label">Ativo</label>
    </div>
    <div>
        {!! Form::radio('ativo','0',$socio->ativo == '0', [Auth::user()->direcao == 1 ? null : 'readonly'])  !!}
        <label class="form-check-label">Não ativo</label>
    </div>
</div>
@else
<input type="hidden" name="ativo" value="0" />
@endif


<div class="form-group">
    <label for="inputDirecao">Direção</label>
    @if(isset($socio))
    <div>
        {!! Form::radio('direcao','1',$socio->direcao == '1')  !!}
        <label class="form-check-label">Pertence</label>
    </div>
    <div>
        {!! Form::radio('direcao','0',$socio->direcao == '0')  !!}
        <label class="form-check-label">Não pertence</label>
    </div>
    @else
    <div>
        {!! Form::radio('direcao','1')  !!}
        <label class="form-check-label">Pertence</label>
    </div>
    <div>
        {!! Form::radio('direcao','0')  !!}
        <label class="form-check-label">Não pertence</label>
    </div>
    @endif


</div>

<div class="form-group">
    <label for="inputType">Tipo de Sócio</label>
    <div>
        @if(isset($socio))
        {{ Form::select('tipo_socio', [null => 'Tipo (Selecione)'] + array('P' => 'Piloto', 'NP' => 'Não Piloto', 'A' => 'Aeromodelista'), $socio->tipo_socio, [Auth::user()->direcao == 1 ? null : 'readonly', 'id' => 'idTipoSocio', 'class' => 'form-control']) }}
        @else
        {{ Form::select('tipo_socio', [null => 'Tipo (Selecione)'] +  array('P' => 'Piloto', 'NP' => 'Não Piloto', 'A' => 'Aeromodelista'), null, ['id' => 'idTipoSocio', 'class' => 'form-control'])}}
        @endif

    </div>
</div>
<div class="form-group">
    <label for="inputFoto">Foto</label>
    <div>
        @if(isset($socio->foto_url))
        <img src="{{url('/storage/fotos').'/'.$socio->foto_url}}" style="padding-bottom: 5px">
        <br>
        @endif
        <input type="file" name="file_foto" id="inputFoto"/>

    </div>

</div>

@can('is-piloto', Auth::user())
<div id="pilot_form">
    <div class="form-group">
        <label for="inputAluno">Aluno</label>
        @if(isset($socio))
        <div>
            {!! Form::radio('aluno','1',$socio->aluno == '1')  !!}
            <label class="form-check-label">Sim</label>
        </div>
        <div>
            {!! Form::radio('aluno','0',$socio->aluno == '0')  !!}
            <label class="form-check-label">Não</label>
        </div>
        @else
        <div>
            {!! Form::radio('aluno','1')  !!}
            <label class="form-check-label">Sim</label>
        </div>
        <div>
            {!! Form::radio('aluno','0')  !!}
            <label class="form-check-label">Não</label>
        </div>
        @endif
    </div>
    <div class="form-group">
        <label for="inputInstrutor">Instrutor</label>
        @if(isset($socio))
        <div>
            {!! Form::radio('instrutor','1',$socio->instrutor == '1')  !!}
            <label class="form-check-label">Sim</label>
        </div>
        <div>
            {!! Form::radio('instrutor','0',$socio->instrutor == '0')  !!}
            <label class="form-check-label">Não</label>
        </div>
        @else
        <div>
            {!! Form::radio('instrutor','1')  !!}
            <label class="form-check-label">Sim</label>
        </div>
        <div>
            {!! Form::radio('instrutor','0')  !!}
            <label class="form-check-label">Não</label>
        </div>
        @endif
    </div>
    <div class="form-group">
        <label for="inputLicenca">Nº Licenca</label>
        <input
            type="text" class="form-control"
            name="num_licenca" id="inputLicenca"
            placeholder="NumLicenca" value="@if(isset($socio)){{ old('num_licenca', $socio->num_licenca) }}@else {{old('num_licenca')}}@endif" />
        @if ($errors->has('num_licenca'))
        <em>{{ $errors->first('num_licenca') }}</em>
        @endif
    </div>
    <div class="form-group">
        <label for="inputTipoLicenca">Tipo de Licença</label>
        <div>
            @if(isset($socio->tipo_licenca))
            {!! Form::select('tipo_licenca', $tipos_licenca, $socio->tipoLicenca->code, ['class' => 'form-control']) !!}
            @else
            {!! Form::select('tipo_licenca', $tipos_licenca, null, ['class' => 'form-control']) !!}
            @endif
        </div>
    </div>
    <div class="form-group">
        <label for="inputValidadeLicenca">Validade da Licenca</label>
        <input
            type="date" class="form-control"
            name="validade_licenca" id="inputValidadeLicenca"
            placeholder="ValidadeLicenca" value="@if(isset($socio)){{ old('validade_licenca', $socio->validade_licenca) }}@else {{old('validade_licenca')}}@endif" />
        @if ($errors->has('validade_licenca'))
        <em>{{ $errors->first('validade_licenca') }}</em>
        @endif
    </div>
    <div class="form-group">
        <label for="inputLicencaConfirmada">Licença</label>
        @if(isset($socio))
        <div>
            {!! Form::radio('licenca_confirmada','1',$socio->licenca_confirmada == '1')  !!}
            <label class="form-check-label">Confirmada</label>
        </div>
        <div>
            {!! Form::radio('licenca_confirmada','0',$socio->licenca_confirmada == '0')  !!}
            <label class="form-check-label">Não confirmada</label>
        </div>
        @else
        <div>
            {!! Form::radio('licenca_confirmada','1')  !!}
            <label class="form-check-label">Confirmada</label>
        </div>
        <div>
            {!! Form::radio('licenca_confirmada','0')  !!}
            <label class="form-check-label">Não confirmada</label>
        </div>
        @endif
    </div>
    <div class="form-group">
        <label for="inputCertificado">Nº Certificado</label>
        <input
            type="text" class="form-control"
            name="num_certificado" id="inputCertificado"
            placeholder="NumCertificado" value="@if(isset($socio)){{ old('num_certificado', $socio->num_certificado) }}@else {{old('num_certificado')}}@endif" />
        @if ($errors->has('num_certificado'))
        <em>{{ $errors->first('num_certificado') }}</em>
        @endif
    </div>
    <div class="form-group">
        <label for="inputClasseCertificado">Classe Certificado</label>
        <div>
            @if(isset($socio->classe_certificado))
            {!! Form::select('classe_certificado', $classes_certificado, $socio->classeCertificado->code, ['class' => 'form-control']) !!}
            @else
            {!! Form::select('classe_certificado', $classes_certificado, null, ['class' => 'form-control'])!!}
            @endif

        </div>
    </div>
    <div class="form-group">
        <label for="inputValidadeCertificado">Validade do Certificado</label>
        <input
            type="date" class="form-control"
            name="validade_certificado" id="inputValidadeCertificado"
            placeholder="ValidadeCertificado" value="@if(isset($socio)){{ old('validade_certificado', $socio->validade_certificado) }}@else {{old('validade_certificado')}}@endif" />
        @if ($errors->has('validade_certificado'))
        <em>{{ $errors->first('validade_certificado') }}</em>
        @endif
    </div>
    <div class="form-group">
        <label for="inputCertificadoConfirmado">Certificado</label>
        @if(isset($socio))
        <div>
            {!! Form::radio('certificado_confirmado','1',$socio->certificado_confirmado == '1')  !!}
            <label class="form-check-label">Confirmado</label>
        </div>
        <div>
            {!! Form::radio('certificado_confirmado','0',$socio->certificado_confirmado == '0')  !!}
            <label class="form-check-label">Não confirmado</label>
        </div>
        @else
        <div>
            {!! Form::radio('certificado_confirmado','1')  !!}
            <label class="form-check-label">Confirmado</label>
        </div>
        <div>
            {!! Form::radio('certificado_confirmado','0')  !!}
            <label class="form-check-label">Não confirmado</label>
        </div>
        @endif
    </div>


    <div class="form-group">
        <label for="inputFoto">Licença</label>
        <div>
            @if(isset($socio))
            <a href="{{ route('pilotos.mostrarFicheiroLicenca', $socio->id)}}">Licença atual</a>
            <br>
            @endif
            <input type="file" name="file_licenca" id="inputLicenca"/>

        </div>

    </div>

    <div class="form-group">
        <label for="inputFoto">Certificado</label>
        <div>
            @if(isset($socio))
            <a href="{{ route('pilotos.mostrarFicheiroCertificado', $socio->id)}}">Certificado atual</a>
            <br>
            @endif
            <input type="file" name="file_certificado" id="idInputCertificado"/>
        </div>

    </div>
</div>

@endcan

<script type="text/javascript">

    $(function() {
        $("#idTipoSocio").change(function() {
            var val = $(this).val();
            if (val === "P") {
                $("#pilot_form").show();
            } else {
                $("#pilot_form").hide();
            }
        }).trigger('change');
    });
</script>

@endsection

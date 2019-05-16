@section('form')
<div class="form-group">
    <label for="inputNumSocio">Nº de sócio</label>
    <input
        type="text" class="form-control"
        name="num_socio" id="inputNumSocio"
        placeholder="Numero de Sócio" value="@if(isset($socio)){{old('num_socio', $socio->num_socio)}}@endif" />
    @if ($errors->has('num_socio'))
        <em>{{ $errors->first('num_socio') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNome">Nome</label>
    <input
        type="text" class="form-control"
        name="name" id="inputNome"
        placeholder="Nome" value="@if(isset($socio)){{ old('name', $socio->name) }}@endif" />
    @if ($errors->has('name'))
        <em>{{ $errors->first('name') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNomeInformal">Nome Informal</label>
    <input
        type="text" class="form-control"
        name="nome_informal" id="inputNomeInformal"
        placeholder="Nome Informal" value="@if(isset($socio)){{ old('nome_informal', $socio->nome_informal) }}@endif" />
    @if ($errors->has('nome_informal'))
        <em>{{ $errors->first('nome_informal') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputSexo">Sexo</label>
    <div class='radio'>
        <div>
            {!! Form::radio('sexo','F', $socio->sexo == 'F')  !!}
            <label class="form-check-label">Feminino</label>
        </div>
        <div>
            {!! Form::radio('sexo','M',$socio->sexo == 'M')  !!}
            <label class="form-check-label">Masculino</label>
        </div>

    </div>


</div>
<div class="form-group">
    <label for="inputEmail">Email</label>
    <input
        type="email" class="form-control"
        name="email" id="inputEmail"
        placeholder="Email" value="@if(isset($socio)){{ old('email', $socio->email) }}@endif" />
    @if ($errors->has('email'))
        <em>{{ $errors->first('email') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputNif">NIF</label>
    <input
        type="text" class="form-control"
        name="nif" id="inputNif"
        placeholder="Nif" value="@if(isset($socio)){{ old('nif', $socio->nif) }}@endif" />
    @if ($errors->has('nif'))
        <em>{{ $errors->first('nif') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputDataNascimento">Data de Nascimento</label>
    <input
        type="date" class="form-control"
        name="data_nascimento" id="inputDataNascimento"
        placeholder="Data de Nascimento" value="@if(isset($socio)){{ old('data_nascimento', $socio->data_nascimento) }}@endif" />
    @if ($errors->has('data_nascimento'))
        <em>{{ $errors->first('data_nascimento') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputTelefone">Telefone</label>
    <input
        type="text" class="form-control"
        name="telefone" id="inputTelefone"
        placeholder="Telefone" value="@if(isset($socio)){{ old('telefone', $socio->telefone) }}@endif" />
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
    <label for="inputType">Tipo de Sócio</label>
    <div>
        {{ Form::select('tipo_socio', array('P' => 'Piloto', 'NP' => 'Não Piloto', 'A' => 'Aeromodelista'), $socio->tipo_socio) }}
    </div>
</div>
<div class="form-group">
    <label for="inputQuotas">Quotas</label>
    <div class='radio'>
        <div>
            {!! Form::radio('quota_paga','1',$socio->quota_paga == '1')  !!}
            <label class="form-check-label">Pagas</label>
        </div>
        <div>
            {!! Form::radio('quota_paga','0',$socio->quota_paga == '0')  !!}
            <label class="form-check-label">Não pagas</label>
        </div>

    </div>
</div>
<div class="form-group">
    <label for="inputAtivo">Ativo</label>
    <div>
        {!! Form::radio('ativo','1',$socio->ativo == '1')  !!}
        <label class="form-check-label">Ativo</label>
    </div>
    <div>
        {!! Form::radio('ativo','0',$socio->ativo == '0')  !!}
        <label class="form-check-label">Não ativo</label>
    </div>

</div>
<div class="form-group">
    <label for="inputDirecao">Direção</label>
    <div>
        {!! Form::radio('direcao','1',$socio->direcao == '1')  !!}
        <label class="form-check-label">Pertence</label>
    </div>
    <div>
        {!! Form::radio('direcao','0',$socio->direcao == '0')  !!}
        <label class="form-check-label">Não pertence</label>
    </div>
</div>
<div class="form-group">
    <label for="inputAluno">Aluno</label>
    <div>
        {!! Form::radio('aluno','1',$socio->aluno == '1')  !!}
        <label class="form-check-label">Sim</label>
    </div>
    <div>
        {!! Form::radio('aluno','0',$socio->aluno == '0')  !!}
        <label class="form-check-label">Não</label>
    </div>
</div>
<div class="form-group">
    <label for="inputInstrutor">Instrutor</label>
    <div>
        {!! Form::radio('instrutor','1',$socio->instrutor == '1')  !!}
        <label class="form-check-label">Sim</label>
    </div>
    <div>
        {!! Form::radio('instrutor','0',$socio->instrutor == '0')  !!}
        <label class="form-check-label">Não</label>
    </div>
</div>
<div class="form-group">
    <label for="inputLicenca">Nº Licenca</label>
    <input
        type="text" class="form-control"
        name="num_licenca" id="inputLicenca"
        placeholder="NumLicenca" value="@if(isset($socio)){{ old('num_licenca', $socio->num_licenca) }}@endif" />
    @if ($errors->has('num_licenca'))
        <em>{{ $errors->first('num_licenca') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputTipoLicenca">Tipo de Licença</label>
    <div>
        {{ Form::select('tipo_licenca', array('ALUNO-PPL(A)' => 'Aluno - Private Pilot License Airplane', 'ALUNO-PU' => 'Aluno - Piloto de Ultraleve', 'ATPL' => 'Airline Transport Pilot License', 'CPL(A)' => 'Comercial Pilot License Airplane', 'PPL(A)' => 'Private Pilot License Airplane' ,'PU' => 'Piloto de Ultraleve'), $socio->tipo_licenca) }}
    </div>
</div>
<div class="form-group">
    <label for="inputValidadeLicenca">Validade da Licenca</label>
    <input
        type="date" class="form-control"
        name="validade_licenca" id="inputValidadeLicenca"
        placeholder="ValidadeLicenca" value="@if(isset($socio)){{ old('validade_licenca', $socio->validade_licenca) }}@endif" />
    @if ($errors->has('validade_licenca'))
        <em>{{ $errors->first('validade_licenca') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputLicencaConfirmada">Licença</label>
        <div>
            {!! Form::radio('licenca_confirmada','1',$socio->licenca_confirmada == '1')  !!}
            <label class="form-check-label">Confirmada</label>
        </div>
        <div>
            {!! Form::radio('licenca_confirmada','NULL',$socio->licenca_confirmada == 'NULL')  !!}
            <label class="form-check-label">Não confirmada</label>
        </div>
</div>
<div class="form-group">
    <label for="inputCertificado">Nº Certificado</label>
    <input
        type="text" class="form-control"
        name="num_certificado" id="inputCertificado"
        placeholder="NumCertificado" value="@if(isset($socio)){{ old('num_certificado', $socio->num_certificado) }}@endif" />
    @if ($errors->has('num_certificado'))
        <em>{{ $errors->first('num_certificado') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputClasseCertificado">Classe Certificado</label>
    <div>
        {{ Form::select('classe_certificado', array('Class 1' => 'Class 1 medical certificate', 'Class 2' => 'Class 2 medical certificate', 'LAPL' => 'Light Aircraft Pilot Licence Medical'), $socio->classe_certificado) }}
    </div>
</div>
<div class="form-group">
    <label for="inputValidadeCertificado">Validade do Certificado</label>
    <input
        type="date" class="form-control"
        name="validade_certificado" id="inputValidadeCertificado"
        placeholder="ValidadeCertificado" value="@if(isset($socio)){{ old('validade_certificado', $socio->validade_certificado) }}@endif" />
    @if ($errors->has('validade_certificado'))
        <em>{{ $errors->first('validade_certificado') }}</em>
    @endif
</div>
<div class="form-group">
    <label for="inputCertificadoConfirmado">Certificado</label>
    <div>
        {!! Form::radio('certificado_confirmado','1',$socio->certificado_confirmado == '1')  !!}
        <label class="form-check-label">Confirmado</label>
    </div>
    <div>
        {!! Form::radio('certificado_confirmado','0',$socio->certificado_confirmado == '0')  !!}
        <label class="form-check-label">Não confirmado</label>
    </div>
</div>
<!-- fazer os uploads de ficheiros (tem de se adicionar os campos a bd???) -->
<!-- fazer as relacoes das bds para os tipos de certificados e licencas-->
<!-- ver algumas confirmacoes que estão null-->


@endsection
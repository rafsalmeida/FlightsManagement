<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimento extends Model
{
    protected $table = 'movimentos';
    protected $fillable = ['data','hora_descolagem', 'hora_aterragem', 'aeronave', 'num_diario', 'num_servico', 'piloto_id','aerodromo_partida','aerodromo_chegada','num_aterragens','num_descolagens','num_pessoas','conta_horas_inicio','conta_horas_fim','num_recibo','num_licenca_piloto', 'validade_licenca_piloto', 'tipo_licenca_piloto','num_certificado_piloto','validade_certificado_piloto', 'classe_certificado_piloto','num_licenca_instrutor','validade_licenca_instrutor','tipo_licenca_instrutor','num_licenca_instrutor','validade_licenca_instrutor','classe_certificado_instrutor','natureza','tempo_voo','preco_voo','modo_pagamento','observacoes','confirmado','tipo_instrucao','instrutor_id','tipo_conflito','justificacao_conflito'];

    public function piloto(){
    	return $this->belongsTo('App\User', 'piloto_id', 'id');
    }

    public function instrutor(){
    	return $this->belongsTo('App\User', 'instrutor_id', 'id');
    }

    public function getAeronave(){
    	return $this->belongsTo('App\Aeronave', 'aeronave', 'matricula');
    }

    public function aerodromoPartida(){
        return $this->belongsTo('App\Aerodromo', 'code', 'aerodromo_partida');
    }

    public function aerodromoChegada(){
        return $this->belongsTo('App\Aerodromo', 'code', 'aerodromo_chegada');
    }


}

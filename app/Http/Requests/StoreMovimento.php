<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreMovimento extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * exists:aeronaves_pilotos,piloto_id,matricula,'.$this->aeronave.'',
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
        'data' => 'required|date_format:"Y-m-d"|before_or_equal:today',
        'hora_descolagem' => 'required|date_format:H:i',
        'hora_aterragem' => 'required|after:hora_descolagem|date_format:H:i',
        'aeronave' => 'required|string|exists:aeronaves,matricula',
        'natureza' => 'required|in:I,T,E',
        'num_diario' => 'required|integer|min:0',
        'num_servico' => 'required|integer|min:0',
        'piloto_id' => 'required|integer|'.Rule::exists('aeronaves_pilotos','piloto_id','matricula',$this->aeronave),
        'aerodromo_partida' => 'required|string|exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|exists:aerodromos,code',
        'num_aterragens' => 'required|integer|min:0',
        'num_descolagens' => 'required|integer|min:0',
        'num_pessoas' => 'required|integer|min:1',
        'conta_horas_inicio' => 'required|integer|min:0',
        'conta_horas_fim' => 'required|integer|min:'.$this->conta_horas_inicio,
        'num_recibo' => 'required|digits_between:1,20',
        'instrutor_id' => 'nullable|required_if:natureza,I|exists:users,id,instrutor,1|'.Rule::exists('aeronaves_pilotos','piloto_id','matricula',$this->aeronave),
        'tipo_instrucao' => 'nullable|required_if:natureza,I|in:S,D',
        'modo_pagamento' => 'required|in:N,T,M,P',
        'tempo_voo' => 'required|integer|min:0',
        'preco_voo' => 'required|numeric|min:0'
        ];

        if ($this->get('piloto_id')!=Auth::user()->id && $this->get('instrutor_id')!=Auth::user()->id && Auth::user()->direcao == '0') {
            $rules['piloto_instrutor'] = 'required';  
        }

        return $rules;

        // fazer a verificação ainda 

        /*public function calcTempoVoo($partida, $chegada){
        
        $diferenca = (integer) $movimento->conta_horas_fim - (integer) $movimento->conta_horas_inicio;
        $resto = $diferenca % 10;
        $decima = intdiv($diferenca, 10);
        $tempo_voo = $movimento->getAeronave->getMinutos($resto)->minutos;
        $min_dez = $movimento->getAeronave->getMinutos(10)->minutos;

        $tempo_voo += ($min_dez * $decima);
    }*/
    }

    public function messages(){
        return [
            'piloto_id.exists' => 'O piloto selecionado nao pode voar a aeronave',
            'instrutor_id.exists' => 'O user selecionado não é instrutor',
            'instrutor_id.Rule::exists' => 'O instrutor selecionado nao pode voar a aeronave',
            'piloto_instrutor.required' => 'Tem de ser um dos intervenientes no movimento para adicionar'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;

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
        return [
        'data' => 'required|date_format:"Y-m-d"|before_or_equal:today',
        'hora_descolagem' => 'required|date_format:"H:i"',
        'hora_aterragem' => 'required|date_format:"H:i"|after:hora_descolagem',
        'aeronave' => 'required|string|exists:aeronaves,matricula',
        'natureza' => 'required|in:I,T,E',
        'num_diario' => 'required|integer',
        'num_servico' => 'required|integer',
        'piloto_id' => 'required|integer|'.Rule::exists('aeronaves_pilotos','piloto_id','matricula',$this->aeronave),
        'aerodromo_partida' => 'required|string|exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|exists:aerodromos,code',
        'num_aterragens' => 'required|integer|min:0',
        'num_descolagens' => 'required|integer|min:0',
        'num_pessoas' => 'required|integer|min:0',
        'conta_horas_inicio' => 'required|integer|min:0',
        'conta_horas_fim' => 'required|integer|min:'.$this->conta_horas_inicio,
        'num_recibo' => 'required|integer|min:0',
        'instrutor_id' => 'nullable|required_if:natureza,I|'.Rule::exists('aeronaves_pilotos','piloto_id','matricula',$this->aeronave),
        'tipo_instrucao' => 'required_if:natureza,I',
        'modo_pagamento' => 'required|in:N,T,M,P',
        ];
    }
}

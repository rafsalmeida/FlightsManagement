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
     *
     * @return array
     */
    public function rules()
    {
        return [
        'data' => 'required',
        'hora_descolagem' => 'required',
        'hora_aterragem' => 'required',
        'aeronave' => 'required|string|exists:aeronaves,matricula',
        'natureza' => 'required',
        'num_diario' => 'required|integer',
        'num_servico' => 'required|integer',
        'piloto_id' => 'required|integer|exists:aeronaves_pilotos,piloto_id,matricula,'.$request->aeronave.'',
        'aerodromo_partida' => 'required|string|exists:aerodromos,code',
        'aerodromo_chegada' => 'required|string|exists:aerodromos,code',
        'num_aterragens' => 'required|integer',
        'num_descolagens' => 'required|integer',
        'num_pessoas' => 'required|integer',
        'conta_horas_inicio' => 'required|integer',
        'conta_horas_fim' => 'required|integer|min:'.$request->conta_horas_inicio.'+1',
        'num_recibo' => 'required|integer',
        'instrutor_id' => 'nullable|required_if:natureza,I|exists:aeronaves_pilotos,piloto_id,matricula,'.$request->aeronave.'',
        'tipo_instrucao' => 'required_if:natureza,I',
        'modo_pagamento' => 'required',
        'observacoes' => 'nullable'
        ];
    }
}

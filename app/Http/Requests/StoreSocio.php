<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;

class StoreSocio extends FormRequest
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
        $rules =  [
            "num_socio" => "required|integer|regex:/^\d{1,11}$/|".Rule::unique('users')->ignore($this->id),
            "name" => "required|string|max:255|regex:/^[\pL\s]+$/u",
            "nome_informal" => "required|string|max:40",
            "sexo" => "required|string|in:F,M", 
            "tipo_socio" => "required|string|in:P,NP,A",
            "email" => "required|email|max:255|".Rule::unique('users')->ignore($this->id),
            "nif" => "digits:9|nullable",
            //.Rule::unique('users')->ignore($this->id), ^
            "data_nascimento" => "required|date|before:today",
            "telefone" => "string|max:20|nullable",
            "quota_paga" => "required|in:0,1",
            "ativo" => "required|in:0,1",
            "direcao" => "required|in:0,1",
            "aluno" => "in:0,1|nullable",
            "instrutor" => "in:0,1|nullable",
            "licenca_confirmada" => "in:0,1|nullable",
            "certificado_confirmado" => "in:0,1|nullable",
            "endereco" => "string|nullable",
            "num_licenca" => "string|max:30|nullable",
            "validade_licenca" => "date|nullable",
            "num_certificado" => "string|max:30|nullable",
            "validade_certificado" => "date|nullable",
            "file_foto" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
            "file_licenca" => "file|mimes:pdf|max:2048|nullable",
            "file_certificado" => "file|mimes:pdf|max:2048|nullable",
            "foto_url" => "string",
        ];


        if($this->has('aluno') && $this->get('aluno') == '1' && $this->has('instrutor') && $this->get('instrutor') == '1'){
            $rules['instrutor'] = 'different:aluno';
            $rules['aluno'] = 'different:instrutor';
        }

        return $rules;
    }
}

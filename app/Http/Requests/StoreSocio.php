<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocio extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "num_socio" => "required|integer",
            "name" => "required|string|alpha|max:255",
            "nome_informal" => "required|string|alpha_dash|max:40",
            "email" => "required|email|max:255",
            "nif" => "digits:9|nullable",
            "data_nascimento" => "required|date",
            "telefone" => "string|nullable",
            "endereco" => "string|nullable",
            "num_licenca" => "string|nullable",
            "validade_licenca" => "date|nullable",
            "num_certificado" => "string|nullable",
            "validade_certificado" => "date|nullable",
            "foto_url" => "file|image|nullable",
        ];
    }
}

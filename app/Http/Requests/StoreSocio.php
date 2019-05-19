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
        return [
            "num_socio" => "required|integer|regex:/^\d{1,11}$/|".Rule::unique('users')->ignore($this->id),
            "name" => "required|string|max:255|regex:/^[\pL\s]+$/u",
            "nome_informal" => "required|alpha_dash|max:40",
            "email" => "required|email|max:255|".Rule::unique('users')->ignore($this->id),
            "nif" => "digits:9|nullable|".Rule::unique('users')->ignore($this->id),
            "data_nascimento" => "required|date",
            "telefone" => "string|max:20|nullable",
            "endereco" => "string|nullable",
            "num_licenca" => "string|nullable",
            "validade_licenca" => "date|nullable",
            "num_certificado" => "string|nullable",
            "validade_certificado" => "date|nullable",
            "foto_url" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable",
        ];
    }
}

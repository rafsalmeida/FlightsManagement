<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\validation\Rule;

class StoreAeronave extends FormRequest
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
        //dump($this->matricula);
        return [
        'matricula' => 'required|string|max:8'.Rule::unique('aeronaves')->ignore($this->matricula),
        'marca' => 'required|string|max:40',
        'modelo' => 'required|string|max:40',
        'num_lugares' => 'required|integer|min:1',
        'conta_horas' => 'required|integer|min:1',
        'preco_hora' => 'required|regex:/^[0-9]{1,3}(,[0-9]{3})*(\.[0-9]+)*$/',        
        //'minuto' => 'required|integer|max:60',///acrescente
        'tempos' => 'required|array|min:10|max:10',
        'tempos.*' => 'required|integer|min:0',
        'precos' => 'required|array|min:10|max:10',
        'precos.*' => 'required|numeric|min:0.00',
    
    
        ];
    }
/*
    public function messages(){

        return[

        'preco_hora.regex' => 'Formato preço/hora: ex - xxx.xx (número inteiro até 13 digitos)',
        'marca' => 'Marca deve ser obrigatória e inferior 40 carateres', // Custom Messages
        ];
    }*/
}

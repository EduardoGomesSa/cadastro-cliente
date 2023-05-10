<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'nome' => 'string|max:255',
            'cpf' => 'string',
            'data_nascimento'=>'date_format:Y-m-d',
            'email'=>'required|email|max:255',
            'telefone'=>'string',
            'celular'=>'required|string',
            'logradouro'=>'required|string|max:255',
            'cidade'=>'required|string|max:255',
            'estado'=>'required|string|max:2',
            'cep'=>'required|string|max:9'
        ];
    }
}

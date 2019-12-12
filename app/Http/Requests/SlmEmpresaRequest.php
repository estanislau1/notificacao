<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlmEmpresaRequest extends FormRequest
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
            'id_coordenacao' => 'required',
            'bit_aceito_terceiro' => 'required',
            'ds_terceiro' => 'required'
        ];
    }
    
    public function messages() {
        return [
            
            'id_coordenacao.required' => 'O campo coordenação é obrigatório!',
            'bit_aceito_terceiro.required' => 'O campo justificativa é obrigatório!',
            'ds_terceiro.required' => 'O campo descrição da justificativa é obrigatório!',
        ];
    }
}

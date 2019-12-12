<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlmCaixaRequest extends FormRequest
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
            'bit_aceito_caixa' => 'required',
            'ds_caixa' => 'required'
        ];
    }
    
    public function messages() {
        return [            
            'bit_aceito_caixa.required' => 'O campo parecer é obrigatório!',
            'ds_caixa.required' => 'O campo descrição da justificativa é obrigatório!',
        ];
    }
}

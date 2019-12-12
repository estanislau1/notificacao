<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescumprimentoMinutaRequest extends FormRequest
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
            'nome_anexo_rh' => 'required',
            'tipo' => 'required'
        ];
    }
    
    public function messages() {
        return [
            
            'nome_anexo_rh.required' => 'O campo anexo é obrigatório! Favor anexar minuta!',
            'tipo.required' => 'O campo tipo é obrigatório! Favor marcar alguma opção!'
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescumprimentoOficioRequest extends FormRequest
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
            'nome_anexo_rh_oficio' => 'required'
        ];
    }
    
    public function messages() {
        return [
            
            'nome_anexo_rh_oficio.required' => 'O campo anexo é obrigatório! Favor anexar o ofício!'
        ];
    }
}

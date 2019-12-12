<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DescumprimentoEmpresaRequest extends FormRequest
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
            'nome_anexo_empresa' => 'required'
        ];
    }
    
    public function messages() {
        return [
            
            'nome_anexo_empresa.required' => 'O campo Anexo é obrigatório!'
        ];
    }
}

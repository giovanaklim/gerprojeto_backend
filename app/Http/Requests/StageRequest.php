<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StageRequest extends FormRequest
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

    public function rules()
    {
        return [
            'project_id' => 'required|uuid',
            'name' => 'required|min:4',
            'value' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'value.required' => 'Esse campo é obrigatório.',
            'name.min' => 'Insira um nome com pelo menos 4 caracteres.',
        ];
    }

}

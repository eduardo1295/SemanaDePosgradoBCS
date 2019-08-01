<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramaGeneral extends FormRequest
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
            'programaGeneral' => 'required|mimes:pdf|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'programaGeneral.required' => 'Es necesario seleccionar un archivo PDF',
            
        ];
    }
}

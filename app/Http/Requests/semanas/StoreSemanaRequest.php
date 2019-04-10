<?php

namespace App\Http\Requests\semanas;

use Illuminate\Foundation\Http\FormRequest;

class StoreSemanaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //Validacion campos semana
            'nombre' => 'required|string|max:100',
            
            'fecha_inicio' => 'required|date_format:d/m/Y|after:tomorrow',

            'fecha_fin' => 'required|date_format:d/m/Y|after_or_equal:fecha_inicio'
        ];
    }
}

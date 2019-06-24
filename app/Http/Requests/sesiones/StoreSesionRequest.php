<?php

namespace App\Http\Requests\sesiones;

use Illuminate\Foundation\Http\FormRequest;

class StoreSesionRequest extends FormRequest
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
            //Validacion campos usuario
            'modalidad' => 'required|string|max:40',
            'dia' => 'required|string|max:40',
            'hora_inicio' => 'required|string|max:60',
            'hora_fin' => 'required|string|max:60',
            'lugar' => 'required|string|max:60',
            'cantidad'   => 'required|int|max:30', 
        ];
    }
    public function messages(){
        return [
            '*.required' => 'El campo es obligatorio',
        ];
    }
}

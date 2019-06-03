<?php

namespace App\Http\Requests\usuarios;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlumnoRequest extends FormRequest
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
            'email' => 'required|email|max:60',

            'nombre' => 'required|string|max:40',
            
            'password' => 'nullable|min:8|max:60',
            
            'primer_apellido'   => 'required|string|max:30',            
            
            'segundo_apellido'  => 'required|string|max:30',
            
        ];
    }
    public function messages(){
        return [
            '*.required' => 'El campo es obligatorio',
            '*.max' => 'No debe contener maximo :max caracteres',
            '*.min' => 'Debe contener minimo :min caracteres'
            
            
            
        ];
    }
    
}

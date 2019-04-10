<?php

namespace App\Http\Requests\usuarios;

use Illuminate\Foundation\Http\FormRequest;

class StoreDirectorRequest extends FormRequest
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
            return [
                //Validacion campos usuario
                'email' => 'unique:users|required|email|max:60',
    
                'nombre' => 'required|string|max:40',
                
                'password' => 'required|string|max:60',
                
                'primer_apellido'   => 'required|string|max:30',
                
                'segundo_apellido'  => 'required|string|max:30',
    
                //Validacion campos extra para coordinador
                'grado'  => 'required|max:30',
    
            ];
        ];
    }
}

<?php

namespace App\Http\Requests\coordinadores;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoordinadorRequest extends FormRequest
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
            
            'email' => 'required|email|max:60|unique:users,email,'.$this->route('coordinador'),

            'nombre' => 'required|string|max:40',
            
            'password' => 'string|nullable|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
            
            'primer_apellido'   => 'required|string|max:30',
            
            'segundo_apellido'  => 'required|string|max:30',

            'id_institucion'    => 'required|exists:instituciones,id',

            //Validacion campos extra para coordinador
            'grado'  => 'required|max:30',
        ];
    }

    public function messages(){
        return [
            'email.email' => 'Email no válido' ,
            'id_institucion.required' => 'Debe seleccionar una institución' ,
            'id_institucion.exists' => 'Institución no valida' 
        ];
    }
}

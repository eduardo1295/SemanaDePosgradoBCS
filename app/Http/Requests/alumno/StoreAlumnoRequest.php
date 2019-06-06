<?php

namespace App\Http\Requests\alumno;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoRequest extends FormRequest
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
            'email' => 'unique:users|required|email|max:60',

            'nombre' => 'required|string|max:40',
            
            'password' => 'required|string|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
            
            'primer_apellido'   => 'required|string|max:30',
            
            'segundo_apellido'  => 'string|nullable|max:30',

            'id_institucion'    => 'required|exists:instituciones,id',

            //Validacion campos extra para coordinador
            'num_control'  => 'required|max:15',

            'semestre'  => 'required|max:30',

            'programaSelect'  => 'required|exists:programas,id',

            'directorSelect'  => 'required|exists:directores_tesis,id',
        ];
    }

    public function attributes()
    {
        return [
            'programaSelect' => 'programa de posgrado',
            'directorSelect' => 'director de tesis',
            'num_control' => 'numero de control',
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

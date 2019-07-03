<?php

namespace App\Http\Requests\usuarios;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateEditarPerfilRequest extends FormRequest
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
        //dd($this->request->get('email'));
        return [
            //Validacion campos usuario
            
            
            'email' => 'required|email|max:60|unique:users,email,'. auth()->user()->id,

            'nombre' => 'required|string|max:40',
            
            'password' => 'string|nullable|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
            
            'primer_apellido'   => 'required|string|max:30',
            
            'segundo_apellido'  => 'string|nullable|max:30',

            /*Alumno*/
            'semestre'  =>   Rule::requiredIf(auth()->user() && auth()->user()->hasRoles(['alumno'])).'|max:30',

            //'grado'  =>   Rule::requiredIf(auth()->user() && auth()->user()->hasRoles(['director'])).'|max:30',
            //'num_control'  => Rule::requiredIf(auth()->user()->hasRoles(['alumno']).'|required|max:30',

            
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'email',

            'nombre' => 'nombre',
            
            'password' => 'contraseña',
            
            'primer_apellido'   => 'primer apellido',
            
            'segundo_apellido'  => 'segundo apellido',

            'id_institucion'    => 'institucion',
            'semestre' => 'semestre',
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

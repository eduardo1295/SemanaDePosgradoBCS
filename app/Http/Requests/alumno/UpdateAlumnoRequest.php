<?php

namespace App\Http\Requests\alumno;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
        //dd($this->request->all());
        return [
            //Validacion campos usuario
            'email_al' => 'required|email|max:60|unique:users,email,'.$this->route('alumno'),

            'nombre_al' => 'required|string|max:40',
            
            //'password_al' => 'string|nullable|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
            'password_al' => 'string|nullable',
            
            'primer_apellido_al'   => 'required|string|max:30',
            
            'segundo_apellido_al'  => 'string|nullable|max:30',

            'id_institucion_al'    => Rule::requiredIf(Auth::guard("admin")->user()).'|exists:instituciones,id',

            //Validacion campos extra para alumno
            'num_control_al'  => 'required|max:15|unique:alumnos,num_control,'.$this->route('alumno'),

            'semestre_al'  => 'required|max:30',

            'programaSelect_al'  => Rule::requiredIf(Auth::guard("admin")->user() || (auth()->user() && auth()->user()->hasRoles(['coordinador']))).'|exists:programas,id',

            'directorSelect_al'  => 'required|exists:directores_tesis,id',
            //'directorSelect_al'  => Rule::requiredIf(Auth::guard("admin")->user()).'|exists:directores_tesis,id',
        ];
    }

    public function attributes()
    {
        return [
            'email_al' => 'email',

            'nombre_al' => 'nombre',
            
            'password_al' => 'contraseña',
            
            'primer_apellido_al'   => 'primer apellido',
            
            'segundo_apellido_al'  => 'segundo apellido',

            'id_institucion_al'    => 'institucion',
            'semestre_al' => 'semestre',
            'programaSelect_al' => 'programa de posgrado',
            'directorSelect_al' => 'director de tesis',
            'num_control_al' => 'numero de control',
        ];
    }

    public function messages(){
        return [
            'email_al.email' => 'Email no válido' ,
            'id_institucion_al.required' => 'Debe seleccionar una institución' ,
            'id_institucion_al.exists' => 'Institución no valida' 
        ];
    }
}

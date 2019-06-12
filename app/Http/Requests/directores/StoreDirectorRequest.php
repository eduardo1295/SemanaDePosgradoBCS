<?php

namespace App\Http\Requests\directores;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreDirectorRequest extends FormRequest
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
            'email_di' => 'unique:users,email|required|email|max:60',

            'nombre_di' => 'required|string|max:40',
            
            'password_di' => 'required|string|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',
            
            'primer_apellido_di'   => 'required|string|max:30',
            
            'segundo_apellido_di'  => 'string|max:30|nullable',

            'id_institucion_di'    => Rule::requiredIf(Auth::guard("admin")->user()).'|exists:instituciones,id',

            //Validacion campos extra para director
            'grado_di'  => 'required|max:30',
        ];
    }

    public function messages(){
        return [
            'email.email_di' => 'Email no válido' ,
            'id_institucion_di.required' => 'Debe seleccionar una institución' ,
            'id_institucion_di.exists' => 'Institución no valida' 
        ];
    }

    public function attributes()
    {
        return [
            'nombre_di' => 'nombre',
            'email_di' => 'email',            
            'password_di' => 'contraseña',            
            'primer_apellido_di'   => 'primer apellido',            
            'segundo_apellido_di'  => 'segundo apellido',
            'id_institucion_di'    => 'institucion',
            //Validacion campos extra para director
            'grado_di'  => 'grado',
        ];
    }
}

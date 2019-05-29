<?php

namespace App\Http\Requests\programas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProgramaRequest extends FormRequest
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
            //Validacion campos programa
            'id_programa' => 'unique:programas|required|max:15',

            'nombre' => 'required|string|max:100',
            
            'nivel' => 'required|string|max:30|in:maestria,doctorado',
            
            'periodo' => 'required|string|max:30|in:semestre,trimestre,cuatrimestre',
            
            'id_institucion' => 'required|max:10' 
        ];

    }
    
    public function messages(){
        return [
            'id_programa.required' => 'El campo es obligatorio',
            
            'id_institucion.required' => 'El campo es obligatorio' ,
            
            'periodo.in' =>'Periodo no válido',
            
            'nivel.in' =>'Nivel no válido',
        ];
    }
}

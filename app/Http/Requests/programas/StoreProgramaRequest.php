<?php

namespace App\Http\Requests\programas;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class StoreProgramaRequest extends FormRequest
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
            'id_programa_pro' => 'unique:programas,id_programa|required|max:15',

            'nombre_pro' => 'required|string|max:100',
            
            'nivel_pro' => 'required|string|max:30|in:Maestría,Doctorado',
            
            'periodo_pro' => 'required|string|max:30|in:Semestre,Trimestre,Cuatrimestre',
            
            'id_institucion_pro' => Rule::requiredIf(Auth::guard("admin")->user()).'|max:10' 
        ];

    }
    
    public function messages(){
        return [
            //'id_programa_pro.required' => 'El campo es obligatorio',
            
            //'id_institucion_pro.required' => 'El campo es obligatorio' ,
            
            'periodo_pro.in' =>'Periodo no válido',
            
            'nivel_pro.in' =>'Nivel no válido',
        ];
    }

    public function attributes()
    {
        return [
            'id_programa_pro' => 'clave del programa',

            'nombre_pro' => 'nombre',
            
            'nivel_pro' => 'nivel',
            
            'periodo_pro' => 'periodo',
            
            'id_institucion_pro' => 'institucion' 
        ];
    }
}

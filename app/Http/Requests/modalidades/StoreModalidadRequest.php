<?php

namespace App\Http\Requests\modalidades;

use Illuminate\Foundation\Http\FormRequest;

class StoreModalidadRequest extends FormRequest
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
            //Validacion campos modalidad
            'nombres' => 'required|string|max:50',
            'contenido' => 'required|string|max:1000',
            'posgrado' => 'required|array',
            'posgrado.*' => 'required',
            'periodo' => 'required|array',
            'periodo.*' => 'required',
        ];
    }
    public function messages(){
        return [
            'posgrado.*.required' => 'El campo es obligatorio',
            'periodo.*.required' => 'El campo es obligatorio',
            
        ];
    }
}

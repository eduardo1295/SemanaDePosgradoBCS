<?php

namespace App\Http\Requests\instituciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstitucionRequest extends FormRequest
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
            //Validacion campos institucion
            //'id_institucion' => 'unique:instituciones|required|max:15',

            'nombre' => 'required|string|max:100',

            'siglas' => 'required|string|max:100',
            
            'telefono' => 'string|max:20|nullable',
            
            'ciudad' => 'string|max:30|nullable',

            'calle' => 'string|max:30|nullable',

            'numero' => 'string|max:5|nullable',

            'colonia' => 'string|max:30|nullable',

            'cp' => 'string|max:10|nullable',

            'direccion_web' => 'string|max:100|nullable',

            'latitud' => 'numeric|nullable',

            'longitud' => 'numeric|nullable',
        
        ];
    }
}

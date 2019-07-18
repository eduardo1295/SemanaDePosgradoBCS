<?php

namespace App\Http\Requests\instituciones;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstitucionRequest extends FormRequest
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

            'nombre' => 'required|string|max:100',

            'siglas' => 'required|string|max:100',

            'logo' => 'mimes:jpeg,jpg,png|max:2048|nullable',

            'telefono' => 'required|string|max:20',
            
            'ciudad' => 'required|string|max:30',

            'calle' => 'required|string|max:30',

            'numero' => 'required|string|max:5',

            'colonia' => 'required|string|max:30',

            'cp' => 'required|string|max:10',

            'direccion_web' => 'required|string|max:100',

            'latitud' => 'numeric|nullable',

            'longitud' => 'numeric|nullable',
        
        ];
    }
}

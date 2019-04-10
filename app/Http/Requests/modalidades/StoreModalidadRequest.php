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
        return false;
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
            'nombre' => 'required|string|max:50',

            'descripcion' => 'required|string|max:1000',
        ];
    }
}

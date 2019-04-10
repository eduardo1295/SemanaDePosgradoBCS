<?php

namespace App\Http\Requests\locaciones;

use Illuminate\Foundation\Http\FormRequest;

class StoreLocacionRequest extends FormRequest
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
            //Validacion campos locacion
            'nombre' => 'required|string|max:100',

        ];
    }
}

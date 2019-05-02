<?php

namespace App\Http\Requests\carrusel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarruselRequest extends FormRequest
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
            //Validacion campos carrusel
            'link' => 'nullable|max:60',
            'imagenCarrusel' => 'required|mimes:jpeg,jpg,png|max:2048',

        ];
    }
}

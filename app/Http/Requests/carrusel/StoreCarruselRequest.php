<?php

namespace App\Http\Requests\carrusel;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarruselRequest extends FormRequest
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
            'titulo' => 'required|string|max:50',

            'contenido' => 'required|string|max:70',

            'imgcarrusel' => 'mimes:jpeg,jpg,png|max:2048',

        ];
    }
}

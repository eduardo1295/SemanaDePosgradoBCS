<?php

namespace App\Http\Requests\noticias;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNoticiaRequest extends FormRequest
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
            //Validacion campos noticia
            'titulo' => 'required|string|max:100',

            'resumen' => 'required|string|max:100',

            'contenido' => 'required|string|max:65535',

            'imgnoticia' => 'mimes:jpeg,jpg,png|max:2048',
        ];
    }
}

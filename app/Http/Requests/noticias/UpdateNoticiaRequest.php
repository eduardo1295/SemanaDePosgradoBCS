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

            'contenido' => 'required|string|not_in:<!--?xml encoding="utf-8" ?--><div><br></div>,<div><br></div>',

            'imgnoticia' => 'mimes:jpeg,jpg,png|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'contenido' => 'contenido de la noticia',
        ];
    }

    public function messages(){
        return [
            'contenido.not_in' => 'Contenido de la noticia no válido',
        ];
    }
}

<?php

namespace App\Http\Requests\trabajos;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrabajoRequest extends FormRequest
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
            //Validacion campos trabajo
            'titulo' => 'required|string|max:100',

            'resumen' => 'required|string|max:1000',
            
            'area' => 'required|string|max:100',

            'pal_clv1'   => 'required|string|max:15',

            'pal_clv2'   => 'required|string|max:15',

            'pal_clv3'   => 'required|string|max:15',
            
            'pal_clv4'   => 'required|string|max:15',

            'pal_clv5'   => 'required|string|max:15',

            'comentario'  => 'required|string|max:100',
        ];
    }
}

<?php

namespace App\Http\Requests\semanas;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSemanaRequest extends FormRequest
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
            //Validacion campos semana
            'nombre' => 'required|string|max:100',

            'contenido' =>'required|string|not_in:<!--?xml encoding="utf-8" ?--><div><br></div>,<div><br></div>',
            
            'fecha_inicio' => 'required|date_format:Y-m-d',

            'fecha_fin' => 'required|date_format:Y-m-d|after_or_equal:fecha_inicio',

            'id_institucion'    => 'required|exists:instituciones,id',

            'convocatoria' => 'mimes:pdf|max:2048',

            'imagensemana' => 'mimes:jpeg,jpg,png|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'id_institucion' => 'institución',
            'fecha_inicio' => 'Inicio del evento',
            'fecha_fin' => 'final del evento',
            'contenido' => 'información general',
            'imagensemana' => 'logo del evento',
            'convocatoria' => 'Convocatoria del evento',
        ];
    }

    public function messages(){
        return [
            'contenido.not_in' => 'Información general no válida',
            
        ];
    }
}
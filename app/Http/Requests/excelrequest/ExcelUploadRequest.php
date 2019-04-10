<?php

namespace App\Http\Requests\excelrequest;

use Illuminate\Foundation\Http\FormRequest;

class ExcelUploadRequest extends FormRequest
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
            'archivo'  => 'required|mimes:xls,xlsx'
        ];
    }

    /*public function messages()
    {
        return [
            'archivo.required' => 'Es necesario seleccionar un  :attribute',
            
        ];
    }*/
}

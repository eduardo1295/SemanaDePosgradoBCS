<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateAdminRequest extends FormRequest
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
        //dd($this->request->get('email'));
        return [
            //Validacion campos usuario
            
            
            'email' => 'required|email|max:60|unique:admins,email,'. auth('admin')->user()->id,

            'nombre' => 'required|string|max:40',
            
            'password' => 'string|nullable|min:5|max:60|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$^&-]).{6,}$/',

            
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
    
    
    public function messages()
    {
        return [
            'pass.required' => 'Ingrese la contraseña actual.',
            
            'password.required' => 'Ingrese la contraseñ nueva.',
            'password.min' => 'La contraseña debe estar compuesta por 6 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.'            
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'pass' => 'required',
            'password' => 'required|string|min:6|confirmed'
        ];
    }
}

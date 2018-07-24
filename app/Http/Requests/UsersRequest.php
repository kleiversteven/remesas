<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsersRequest extends FormRequest
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
    public function messages()
    {
        return [
            'rol.required' => 'Debe indicar el rol del usuario.',
            'name.required' => 'Debe ingresar el nombre del usuario.',
            'name.string' => 'El nombre de usuario debe contener solo letras.',
            'name.max' => 'El limite de caracteres son 50.',
            'email.required' => 'Debe ingresar el correo del usuario.',
            'email.email' => 'Ingrese un correo electronico valido.',
            'email.unique' => 'El correo indicado ya esta en uso.',
            'password.required' => 'Debe indicar la contraseña de usuario.',
            'password.confirmed' => 'Las contraseñas deben coincidir.'
            
        ];
    }
    
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'rol' => 'required'
        ];
    }
    
}

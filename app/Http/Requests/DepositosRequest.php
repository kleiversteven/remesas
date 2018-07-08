<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepositosRequest extends FormRequest
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
            'ref-into.required' => 'El numero de referencia es obligatorio',
            'email.required' => 'La direccion de correo es obligatoria',
            'cuenta.regex' => 'Numero de cuenta invalidao',
            'telefono.regex' => 'Numero de telefono invalido',
            
        ];
    }
    public function rules()
    {
        return [
            'ref-into' => 'required',
            'email'    => 'required|email',
            'cuenta'   => 'required',
            'telefono' => 'required|regex:/(^[0-9]{10}$)/u',
        ];
    }
}

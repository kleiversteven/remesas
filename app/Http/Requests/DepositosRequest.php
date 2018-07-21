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
            'ref-into.required' => 'El numero de referencia es obligatorio.',
            'telefono.regex' => 'Numero de telefono invalido.',
            'moneda-into.required' => 'Debe ingresar la moneda de deposito.',
            'banco-into.required' => 'Debe indicar a cual banco realizo el deposito.',
            'monto.numeric' => 'El monto debe contener solo numeros.',
            'fecha-into.required' => 'Debe indicar la fecha del deposito.',
            
        ];
    }
    public function rules()
    {
        return [
            'ref-into' => 'required',
            'monto' => 'required|numeric',
            'moneda-into' => 'required',
            'banco-into' => 'required',
            'fecha-into' => 'required'
        ];
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Depositos extends Model
{
    //
    protected $fillable =['banco_into','banco_out','tasa','moneda_into','codeuser',
                          'moneda_out','idfrecuente','monto_into','monto_out',
                          'comision','fecha_into','fecha_out','referencia_into',
                          'referencia_out','estatus','comprobante_into','comprobante_out'];
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bancos extends Model
{
    //
    protected $fillable =['id_bank','idcuenta','banco','estatus','entrada','salida','deposito','eliminado'];
}
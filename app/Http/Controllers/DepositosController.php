<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Depositos;
use App\Frecuentes;
use App\Http\Requests\DepositosRequest;
use Illuminate\Support\Facades\Auth;

class DepositosController extends Controller
{
    public function cargardeposito(){
        
        $bancos = \DB::table('bancos')
                ->select('*')
                ->where(['estatus'=>'1','eliminado'=>'0'])
                ->get();
        $bancos=$bancos->all();
        $monedas=  \DB::table('monedas')
             ->select('*')
             ->where(['estatus'=>'1'])
             ->get();
        $monedas=$monedas->all();
        return view('depositos.cargar')->with(['bancos'=>$bancos,'monedas'=>$monedas]);
    }
    public function savedeposito(DepositosRequest $request){
        $data=$request->all();
        
        $id= Auth::user()->id;
        $tasa= \DB::table('tasas')->select('*')
                ->where([
                   ['tasas.isoa', '=', 'VEF'],
                   ['tasas.isob', '=',trim($data['moneda-into']) ]
                ])
             ->get();
        if(empty($tasa['cambio'])){
            $tasa= \DB::table('tasas')->select('*')
                ->where([
                   ['tasas.isob', '=', 'VEF'],
                   ['tasas.isoa', '=',trim($data['moneda-into']) ]
                ])
             ->get();
            $tasa->all();
            $monto_out=$data['monto']*$tasa[0]->cambio;
        }else{
            $monto_out=$data['monto']/$tasa[0]->cambio;
        }

       $id_frec= \DB::table('frecuentes')->insertGetId(
            array(
                'codeuser'=>$id,
                'cedula'=>$data['nacionalidad']."-".$data['cedula'],
                'telefono'=>$data['telefono'],
                'codibank'=>$data['banco-out'],
                'cuenta'=>$data['cuenta'],
                'eliminado'=>'0',
                'titular'=>$data['titular'],
                'tipo'=>$data['tipo'],
                'correo'=>$data['email']
            )
        );
      $image='';
        
            $image=$request->file('comprobante')->store('public');
        
        \DB::table('depositos')->insert(
            array(        
                'banco_into'=>$data['banco-into'],
                'tasa'=>$tasa[0]->cambio,
                'moneda_into'=>$data['moneda-into'],
                'moneda_out'=>'VEF',
                'idfrecuente'=>$id_frec,
                'monto_into'=>$data['monto'],
                'monto_out'=>$monto_out,
                'comision'=>0,
                'fecha_into'=>$data['fecha-into'],
                'referencia_into'=>$data['ref-into'],
                'estatus'=>1,
                'comprobante'=>$image
                )
        );
    }

}
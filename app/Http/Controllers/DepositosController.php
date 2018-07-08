<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Depositos;
use App\Frecuentes;
use App\Http\Requests\DepositosRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;



class DepositosController extends Controller
{
    use HasRoles;
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
        $country= \DB::table('countries')
             ->select('*')
             ->where(['status'=>'1'])
             ->orderBy('country')
             ->get();
        
        return view('depositos.cargar')->with(['bancos'=>$bancos,'monedas'=>$monedas,'countries'=>$country]);
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
    
        if(isset($tasa) && count($tasa) > 0){
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
        //dd($monto_out);
        $frecuent=array();
        $frecuent= \DB::table('frecuentes')->select('codefrec')
                ->where([
                   ['cedula', '=', $data['nacionalidad']."-".$data['cedula'] ],
                   ['cuenta', '=', $data['cuenta'] ],
                   ['codeuser', '=', $id ]
                ])  ->get();

        if(!isset($frecuent) && count($frecuent) > 0){
            $id_frec = $frecuent[0]->codefrec;
        }else{
            
           $id_frec= \DB::table('frecuentes')->insertGetId( 
                    array(
                        'codeuser'=>$id,
                        'cedula'=>$data['nacionalidad']."-".$data['cedula'],
                        'telefono'=>$data['country'].$data['telefono'],
                        'codibank'=>$data['banco-out'],
                        'cuenta'=>$data['cuenta'],
                        'eliminado'=>'0',
                        'titular'=>$data['titular'],
                        'tipo'=>$data['tipo'],
                        'correo'=>$data['email']
                    )
               );
        }
      $image='';
        if($request->hasFile('comprobante')){
            $image=$request->file('comprobante')->store('public');
        }
        \DB::table('depositos')->insert(
            array(        
                'banco_into'=>$data['banco-into'],
                'banco_out'=>$data['banco-out'],
                'tasa'=>$tasa[0]->cambio,
                'codeuser'=>$id,
                'moneda_into'=>$data['moneda-into'],
                'moneda_out'=>'VEF',
                'idfrecuente'=>$id_frec,
                'monto_into'=>$data['monto'],
                'monto_out'=>$monto_out,
                'comision'=>0,
                'fecha_into'=>$data['fecha-into'],
                'referencia_into'=>$data['ref-into'],
                'estatus'=>1,
                'comprobante_into'=>$image
                )
        );

         return redirect( 'misdepositos')->with(['mensaje'=>' Deposito registrado con exito! ']); 
    }
    public function listardepositos(Request $request){

        $data= array();
        $depositos= array();
        $id= Auth::user()->id;
       
        $depositos = \DB::table('depositos')
                ->select(
                    'depositos.idtrans',
                    'depositos.tasa',
                    'depositos.monto_into',
                    'depositos.monto_out',
                    'depositos.comision',
                    'depositos.fecha_into',
                    'depositos.fecha_out',
                    'depositos.referencia_into',
                    'depositos.referencia_out',
                    'depositos.estatus',
                    'depositos.comprobante_into',
                    'depositos.comprobante_out',
                    'frecuentes.cedula',
                    'frecuentes.telefono',
                    'frecuentes.cuenta',
                    'frecuentes.titular',
                    'frecuentes.tipo',
                    'frecuentes.correo',
                    'banc_salida.banco AS banco_sal',
                    'banc_entrada.banco AS banco_ent',
                    'moneda_salida.descripcion AS mnd_sal_desc',
                    'moneda_salida.iso AS mnd_sal_iso',
                    'moneda_salida.simbolo AS mnd_sal_sim',
                    'moneda_entrada.descripcion AS mnd_ent_desc',
                    'moneda_entrada.iso AS mnd_ent_iso',
                   'moneda_entrada.simbolo AS mnd_ent_sim')
             ->join('frecuentes','depositos.idfrecuente','=','frecuentes.codefrec')
            //->on('depositos.banco_out','=','frecuentes.codibank')
             ->join('bancos AS banc_salida', 'depositos.banco_out', '=', 'banc_salida.idbank')
             ->join('bancos AS banc_entrada', 'depositos.banco_into', '=', 'banc_entrada.idbank')
             ->join('monedas AS moneda_salida', 'depositos.moneda_out', '=', 'moneda_salida.iso')
             ->join('monedas AS moneda_entrada', 'depositos.moneda_into', '=', 'moneda_entrada.iso')
                ->where(['depositos.codeuser'=>$id])
                ->get();
        $data = $depositos->all();
        //dd($data);
         return view('depositos.listardepositos')->with(['depositos'=>$data]);
    }
    public function alldepositos(Request $request){

        $data= array();
        $depositos= array();
       
        $depositos = \DB::table('depositos')
                ->select(
                    'depositos.idtrans',
                    'depositos.tasa',
                    'depositos.monto_into',
                    'depositos.monto_out',
                    'depositos.comision',
                    'depositos.fecha_into',
                    'depositos.fecha_out',
                    'depositos.referencia_into',
                    'depositos.referencia_out',
                    'depositos.estatus',
                    'depositos.comprobante_into',
                    'depositos.comprobante_out',
                    'frecuentes.cedula',
                    'frecuentes.telefono',
                    'frecuentes.cuenta',
                    'frecuentes.titular',
                    'frecuentes.tipo',
                    'frecuentes.correo',
                    'banc_salida.banco AS banco_sal',
                    'banc_entrada.banco AS banco_ent',
                    'moneda_salida.descripcion AS mnd_sal_desc',
                    'moneda_salida.iso AS mnd_sal_iso',
                    'moneda_salida.simbolo AS mnd_sal_sim',
                    'moneda_entrada.descripcion AS mnd_ent_desc',
                    'moneda_entrada.iso AS mnd_ent_iso',
                   'moneda_entrada.simbolo AS mnd_ent_sim')
             ->join('frecuentes','depositos.idfrecuente','=','frecuentes.codefrec')
            //->on('depositos.banco_out','=','frecuentes.codibank')
             ->join('bancos AS banc_salida', 'depositos.banco_out', '=', 'banc_salida.idbank')
             ->join('bancos AS banc_entrada', 'depositos.banco_into', '=', 'banc_entrada.idbank')
             ->join('monedas AS moneda_salida', 'depositos.moneda_out', '=', 'moneda_salida.iso')
             ->join('monedas AS moneda_entrada', 'depositos.moneda_into', '=', 'moneda_entrada.iso')
                ->get();
        $data = $depositos->all();
        //dd(HasRoles);
         return view('depositos.depositos')->with(['depositos'=>$data]);
    }
}
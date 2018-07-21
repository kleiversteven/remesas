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
        $id= Auth::user()->id;
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
        
        $frecuentes= \DB::table('frecuentes')
             ->select('frecuentes.codefrec','frecuentes.cedula','frecuentes.codibank','frecuentes.cuenta','frecuentes.titular',
                     \DB::raw('IF(frecuentes.tipo = 0 ,"Corriente","Ahorro") AS tipo'),'frecuentes.correo','bancos.banco')
            ->join('bancos','frecuentes.codibank','=','bancos.idbank')
             ->where(['.frecuentes.eliminado'=>'0','frecuentes.codeuser'=>$id])
             
             ->get();
        
        return view('depositos.cargar')->with(['bancos'=>$bancos,'monedas'=>$monedas,'countries'=>$country,'frecuentes'=>$frecuentes]);
    }
    
    public function savecuenta(Request $request){
        $data=$request->all();
        $id= Auth::user()->id;
        
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
                        'codibank'=>$data['banco-out'],
                        'cuenta'=>$data['cuenta'],
                        'eliminado'=>'0',
                        'titular'=>$data['titular'],
                        'tipo'=>$data['tipo'],
                        'correo'=>$data['email']
                        )
               );
        }
       
      return $id_frec;
        
    }
    
    public function savedeposito(DepositosRequest $request){
        $data=$request->all();
        $id= Auth::user()->id;
        $image='';
        if($request->hasFile('comprobante')){
            $image=$request->file('comprobante')->store('public');
        }
        
        
        $p=1;
        $tasa= \DB::table('tasas')->select('*')
                ->where([
                   ['tasas.isoa', '=', 'VEF'],
                   ['tasas.isob', '=',trim($data['moneda-into']) ]
                ])
             ->get();
        $tasa->all();
        if(count($tasa) <= 0){
            $p=2;
            $tasa= \DB::table('tasas')->select('*')
                ->where([
                   ['tasas.isob', '=', 'VEF'],
                   ['tasas.isoa', '=',trim($data['moneda-into']) ]
                ])
             ->get();
            $tasa->all();
        }
     
          if($p==1){
          $monto_out=$data['monto']/$tasa[0]->cambio;
      }elseif($p==2){
          $monto_out=$data['monto']*$tasa[0]->cambio;
      }
          
          $iddepo=  \DB::table('depositos')->insertGetId(
                array(
                    'banco_into'=>$data['banco-into'],
                    'tasa'=>$tasa[0]->cambio,
                    'codeuser'=>$id,
                    'moneda_into'=>$data['moneda-into'],
                    'moneda_out'=>'VEF',
                    'monto_into'=>$data['monto'],
                    'monto_out'=>$monto_out,
                    'comision'=>0,
                    'fecha_into'=>$data['fecha-into'],
                    'referencia_into'=>$data['ref-into'],
                    'estatus'=>1,
                    'comprobante_into'=>$image
                    )
            );
        
     foreach($data['frecuente'] as $k => $f){
      if($p==1){
          $monto_out=$data['montofrecuente'][$k]/$tasa[0]->cambio;
      }elseif($p==2){
          $monto_out=$data['montofrecuente'][$k]*$tasa[0]->cambio;
      }
          
          \DB::table('salidas')->insert(
                array(
                        'codedepo'=>$iddepo,
                        'idfrecuente'=>$f,
                        'monto_into'=>$data['montofrecuente'][$k],
                        'monto_out'=>$monto_out,
                    )
            );
      }
        
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
                    'depositos.referencia_into',
                    'depositos.estatus',
                    'depositos.comprobante_into',
                    'banc_entrada.banco AS banco_ent',
                    'moneda_salida.descripcion AS mnd_sal_desc',
                    'moneda_salida.iso AS mnd_sal_iso',
                    'moneda_salida.simbolo AS mnd_sal_sim',
                    'moneda_entrada.descripcion AS mnd_ent_desc',
                    'moneda_entrada.iso AS mnd_ent_iso',
                   'moneda_entrada.simbolo AS mnd_ent_sim')
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
                    'depositos.referencia_into',
                    'depositos.estatus',
                    'depositos.comprobante_into',
                    'banc_entrada.banco AS banco_ent',
                    'moneda_salida.descripcion AS mnd_sal_desc',
                    'moneda_salida.iso AS mnd_sal_iso',
                    'moneda_salida.simbolo AS mnd_sal_sim',
                    'moneda_entrada.descripcion AS mnd_ent_desc',
                    'moneda_entrada.iso AS mnd_ent_iso',
                   'moneda_entrada.simbolo AS mnd_ent_sim')
             ->join('bancos AS banc_entrada', 'depositos.banco_into', '=', 'banc_entrada.idbank')
             ->join('monedas AS moneda_salida', 'depositos.moneda_out', '=', 'moneda_salida.iso')
             ->join('monedas AS moneda_entrada', 'depositos.moneda_into', '=', 'moneda_entrada.iso')
                ->get();
        $data = $depositos->all();
        //dd(HasRoles);
         return view('depositos.depositos')->with(['depositos'=>$data]);
    }
}
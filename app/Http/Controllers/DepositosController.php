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
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Mail;
use PDF;

class DepositosController extends Controller
{
    use HasRoles;
    
    private function notificar_cliente($id,$dato,$data,$cambio,$monto_out){
        
        $email = Auth::user()->email;
        
        $data=array('name'=>Auth::user()->name,
                    'codigo'=>$id,
                    'tasa'=>$cambio,
                    'ingreso'=>$data['monto'],
                    'salida'=>$monto_out,
                    'moneda_into'=>$data['moneda-into'],
                    'referencia'=>$data['ref-into'],
                    'moneda_out'=>'VEF',
                    'fecha'=>date('d-m-Y')
                   );
        
        Mail::send('emails.cliente',['mensaje'=>$data],function($message)use($email,$data){
            $message->from('atencionalcliente@localremesas.com','Recibo LocalRemesas');
            $message->to($email)->subject('Recibo de trasferencia');
        });
        
    }
    private function notificar_localremesas($id,$dato,$data,$cambio,$monto_out){
        $frecuente= \DB::table('frecuentes')->select(
                                'frecuentes.codefrec',
                                'frecuentes.cedula',
                                'frecuentes.telefono',
                                'frecuentes.codibank',
                                'frecuentes.cuenta',
                                'frecuentes.tipo',
                                'frecuentes.correo',
                                'frecuentes.titular',
                                'bancos.banco')
                ->join('bancos','frecuentes.codibank','=','bancos.idbank')
                ->whereIn('frecuentes.codefrec',$data['frecuente'])
                ->get();
        $frecuente= $frecuente->all();
        $banco = \DB::table('bancos')->select('*')
                ->where('idbank',$data['banco-into'])
                ->first();
        $data=array('name'=>Auth::user()->name,
                    'codigo'=>$id,
                    'email'=>Auth::user()->email,
                    'tasa'=>$cambio,
                    'ingreso'=>$data['monto'],
                    'salida'=>$monto_out,
                    'data'=>$data,
                    'moneda_into'=>$data['moneda-into'],
                    'referencia'=>$data['ref-into'],
                    'moneda_out'=>'VEF',
                    'frecuente'=>$frecuente,
                    'banco'=>$banco->banco,
                    'fecha'=>date('d-m-Y')
                   );
        $email= Auth::user()->email;
        Mail::send('emails.trasferido',['mensaje'=>$data],function($message)use($email,$data){
            $message->from($email,'Nueva trasferencia');
            $message->to('atencionalcliente@localremesas.com')->subject('Nueva trasferencia');
        });
        
       
    }
    
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
        $user = new User;
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
        $dato= $tasa->all();
        if(!empty($dato)){
            if($user->hasRole('Mayorista') == true)
                $cambio = $tasa[0]->mayorista;
            elseif($user->hasRole('recaudador')== true )
                    $cambio = $tasa[0]->cambio + (($tasa[0]->recudador/100)*$tasa[0]->cambio);
            else
                $cambio = $tasa[0]->cambio;
        }
        
        
        if(count($tasa) <= 0){
            $p=2;
            $tasa= \DB::table('tasas')->select('*')
                ->where([
                   ['tasas.isob', '=', 'VEF'],
                   ['tasas.isoa', '=',trim($data['moneda-into']) ]
                ])
             ->get();
            $tasa->all();
            if($user->hasRole('Mayorista') == true)
                $cambio = $tasa[0]->mayorista;
            elseif($user->hasRole('recaudador')== true )
                $cambio = $tasa[0]->cambio + (($tasa[0]->recudador/100)*$tasa[0]->cambio);
            else
                $cambio = $tasa[0]->cambio;
        }
     
      if($p==1){
          $monto_out=$data['monto']/$cambio;
      }elseif($p==2){
          $monto_out=$data['monto']*$cambio;
      }
        
        $depo =\DB::table('depositos')->select('idtrans')
             ->where('referencia_into',$data['ref-into'])
             ->first();
        
        if(empty($depo)){
                      $iddepo=  \DB::table('depositos')->insertGetId(
                            array(
                                'banco_into'=>$data['banco-into'],
                                'tasa'=>$cambio,
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
                    $this->notificar_cliente($id,$dato,$data,$cambio,$monto_out);
                    $this->notificar_localremesas($id,$dato,$data,$cambio,$monto_out);
                 foreach($data['frecuente'] as $k => $f){


                  if($p==1){
                      $monto_out=$data['montofrecuente'][$k]/$cambio;
                  }elseif($p==2){
                      $monto_out=$data['montofrecuente'][$k]*$cambio;
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
        }else{
           return redirect( 'depositos')->with(['error'=>' El numero de operacion ya se encuentra registrado por favor validar']); 
        }
        
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
    public function transaccion($transc=''){
        $transaccion = \DB::table('depositos')
            ->select('depositos.banco_into',
                        'depositos.idtrans',
                        'depositos.tasa',
                        'depositos.moneda_into',
                        'depositos.moneda_out',
                        'depositos.monto_into as depo_into',
                        'depositos.monto_out',
                        'depositos.referencia_into',
                        'depositos.estatus',
                        'depositos.comprobante_into',
                        'depositos.codeuser',
                        'depositos.fecha_into',
                        'users.name',
                        'users.email',
                        'salidas.idfrecuente',
                        'salidas.codesali',
                        'salidas.monto_into',
                        'salidas.monto_out',
                        'salidas.referencia_out',
                        'salidas.comprobante_out',
                        'frecuentes.titular',
                        'frecuentes.cedula',
                        'frecuentes.tipo',
                        'banc_sal.banco as b_sal',
                        'frecuentes.cuenta',
                        'frecuentes.correo',
                        'moneda_salida.descripcion AS mnd_sal_desc',
                        'moneda_entrada.descripcion AS mnd_ent_desc',
                        'banc_ent.banco as b_ent' )
             ->join('users', 'depositos.codeuser', '=', 'users.id')
             ->join('salidas', 'depositos.idtrans', '=', 'salidas.codedepo')
             ->join('frecuentes', 'salidas.idfrecuente', '=', 'frecuentes.codefrec')
             ->join('bancos AS banc_sal', 'frecuentes.codibank', '=', 'banc_sal.idbank')
             ->join('bancos AS banc_ent', 'depositos.banco_into', '=', 'banc_ent.idbank')
             ->join('monedas AS moneda_salida', 'depositos.moneda_out', '=', 'moneda_salida.iso')
             ->join('monedas AS moneda_entrada', 'depositos.moneda_into', '=', 'moneda_entrada.iso')
             ->where('depositos.idtrans','=', $transc)
        ->get();
        $data = $transaccion->all();
        return view('depositos.detalles')->with(['deposito'=>$data]);
    }
    public function informacion($transc=''){
        $transaccion = \DB::table('depositos')
            ->select('depositos.banco_into',
                        'depositos.idtrans',
                        'depositos.tasa',
                        'depositos.moneda_into',
                        'depositos.moneda_out',
                        'depositos.monto_into as depo_into',
                        'depositos.monto_out',
                        'depositos.referencia_into',
                        'depositos.estatus',
                        'depositos.comprobante_into',
                        'depositos.codeuser',
                        'depositos.fecha_into',
                        'users.name',
                        'users.email',
                        'salidas.idfrecuente',
                        'salidas.codesali',
                        'salidas.monto_into',
                        'salidas.monto_out',
                        'salidas.referencia_out',
                        'salidas.comprobante_out',
                        'frecuentes.titular',
                        'frecuentes.cedula',
                        'frecuentes.tipo',
                        'banc_sal.banco as b_sal',
                        'frecuentes.cuenta',
                        'frecuentes.correo',
                        'moneda_salida.descripcion AS mnd_sal_desc',
                        'moneda_entrada.descripcion AS mnd_ent_desc',
                        'banc_ent.banco as b_ent' )
             ->join('users', 'depositos.codeuser', '=', 'users.id')
             ->join('salidas', 'depositos.idtrans', '=', 'salidas.codedepo')
             ->join('frecuentes', 'salidas.idfrecuente', '=', 'frecuentes.codefrec')
             ->join('bancos AS banc_sal', 'frecuentes.codibank', '=', 'banc_sal.idbank')
             ->join('bancos AS banc_ent', 'depositos.banco_into', '=', 'banc_ent.idbank')
             ->join('monedas AS moneda_salida', 'depositos.moneda_out', '=', 'moneda_salida.iso')
             ->join('monedas AS moneda_entrada', 'depositos.moneda_into', '=', 'moneda_entrada.iso')
             ->where('depositos.idtrans','=', $transc)
        ->get();
        $data = $transaccion->all();
        return view('depositos.informacion')->with(['deposito'=>$data]);
    }
    public function modtransaccion(Request $request){
        $data =$request->all();
        $resp = \DB::table('depositos')
             ->where('idtrans','=', $data['transac'])
             ->update(['estatus' => $data['estatus'] ]);
    }
    public function savereferencia(Request $request){
        $image='';
        
        if($request->hasFile('capture')){
            $image=$request->file('capture')->store('public');
        }
        $fecha =  date("Y-m-d");
        $ref=$request->referencia;
        $id=$request->transc;
        $resp = \DB::table('salidas')
             ->where('codesali','=', $id)
             ->update(['referencia_out' =>$ref,'fecha_out'=>$fecha,'comprobante_out'=>$image ]);            
        return back()->with(['mensaje'=>'Datos actualizados','imagen'=>$image]);
    }
    public function efectivo(Request $request){
        $data= array();
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
        $user = new User;
        
        return view('depositos.efectivo')->with(['bancos'=>$bancos,'monedas'=>$monedas,'countries'=>$country,'frecuentes'=>$frecuentes]);
    }
    
}
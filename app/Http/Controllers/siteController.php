<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Foundation\Auth\User as Authenticatable;

class siteController extends Controller
{
    
    
    public function index(){
        $monedas=  \DB::table('monedas')
             ->select('monedas.id','monedas.descripcion','monedas.estatus','monedas.iso')
             
             ->where(['estatus'=>'1'])
             ->get();
        $tasas=  \DB::table('monedas')
             ->select('monedas.id','tasas.cambio','tasas.isoa','tasas.isob','monedas.descripcion','monedas.estatus','monedas.iso', 
                      \DB::raw('IF(monedas.iso = tasas.isoa ,"d","m") AS tipo'),
                      \DB::raw('IF(monedas.iso = tasas.isoa,1/tasas.cambio,tasas.cambio*1) AS camb')
                     )
             ->join('tasas', function($join){
                    $join->on('monedas.iso','=','tasas.isoa')->orOn('monedas.iso','=','tasas.isob');
                } )
             ->where(['estatus'=>'1'])
            ->orderBy('monedas.iso')
             ->get();
        $sol_bs=$this->calculadora('PEN','VEF',1);
        $dol_so=$this->calculadora('USD','PEN',1);
        $dol_bs=$this->calculadora('USD','VEF',1);
        return view('site/inicio')->with(['monedas'=>$monedas,"tasas"=>$tasas,'sol_bs'=>$sol_bs,'dol_so'=>$dol_so,'dol_bs'=>$dol_bs]);
    }
    
    public function calcular(Request $request){
        $respons = $request->all();
        $user = new User;
        
        $data=array();
        $data = \DB::table('tasas')
                ->select('*')
                ->where(['isoa'=>$respons['isoa'],'isob'=>$respons['isob'] ])
                ->get();
        $data=$data->all();
        
        if(!empty($data)){
            if($user->hasRole('Mayorista') == true)
                $cambio = $data[0]->mayorista;
            elseif($user->hasRole('recaudador')== true )
                $cambio = $data[0]->cambio + (($data[0]->recudador/100)*$data[0]->cambio);
            else
                $cambio = $data[0]->cambio;
        }
        
        
         if(empty($data)){
       
            $data = \DB::table('tasas')
                    ->select('cambio')
                    ->where(['isob'=>$respons['isoa'],'isoa'=>$respons['isob']])
                    ->get();
                $tipo=2;
             $data=$data->all();
             if($user->hasRole('Mayorista') == true)
                $cambio = $data[0]->mayorista;
            elseif($user->hasRole('recaudador')== true )
                $cambio = $data[0]->cambio + (($data[0]->recudador/100)*$data[0]->cambio);
            else
                $cambio = $data[0]->cambio;
             $monto=$respons['monto']/$data[0]->cambio;
        }else{
             $monto=$data[0]->cambio*$respons['monto'];
            $tipo=1;
        }
        if(empty($data)){
            $tipo=3;
        }  
        
        return $monto;
    }
    
    public function respuesta(Request $request){
     
        return view('site/respuesta');
    }
    public function enviarcorreo(Request $request){
        $respons = $request->all();

        $data=array('name'=>$respons['fname'],
                    'email'=>$respons['email'],
                    'phone'=>$respons['country'].' '.$respons['phone'],
                    'subject'=>$respons['subject'],
                    'mensaje'=>$respons['message']);
        $email=$respons['email'];
        Mail::send('emails.contacto',['mensaje'=>$data],function($message)use($email,$data){
            $message->from($email,'Contacto');
            $message->to('atencionalcliente@localremesas.com')->subject($data['subject']);
        });
        return "Mensaje enviado";
    }
    public function calculadora($de,$para,$monto){
        
        $data=array();
        $data = \DB::table('tasas')
                ->select('*')
                ->where(['isoa'=>$de,'isob'=>$para ])
                ->get();
        $data=$data->all();
         if(empty($data)){
       
            $data = \DB::table('tasas')
                    ->select('cambio')
                    ->where(['isob'=>$de,'isoa'=>$para])
                    ->get();
                $tipo=2;
             $data=$data->all();
             $monto=$monto/$data[0]->cambio;
        }else{
             $monto=$data[0]->cambio*$monto;
            $tipo=1;
        }
        if(empty($data)){
            $tipo=3;
        }  
        
        return $monto;
    }
    public function contacto(Request $request){
        $country= \DB::table('countries')
             ->select('*')
             ->where(['status'=>'1'])
             ->orderBy('country')
             ->get();
        return view('contacto')->with(['countries'=>$country]);
    }
        
}

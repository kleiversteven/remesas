<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    use HasRoles;
   public function index(){
       $dolar = $this->calculadora('USD','VEF',1);
       $sol   = $this->calculadora('PEN','VEF',1);
       $depositos=$this->misdepositos(1);
       $procesados=$this->misdepositos(3);
       
        return view('admin')->with(['dolar'=>$dolar,"sol"=>$sol,'depositos'=>$depositos,'procesados'=>$procesados]);
    }
    public function profile(){
        
        return view('usuarios.profile');
    }
    
    public function misdepositos($estatus){
        $id= Auth::user()->id;
        $data=array();
        $data = \DB::table('depositos')
            ->where(['depositos.codeuser'=>$id,'depositos.estatus'=>$estatus])
            ->count() ;
       return $data;
    }
    public function bancos(Request $request){
        $id= Auth::user()->id;
        $data=array();
        $data = \DB::table('bancos')
            ->where(['bancos.eliminado'=>0])
            ->get() ;
       $data=$data->all();
        return view('administrar.bancos')->with(['data'=>$data]);
    }
    public function tasas(Request $request){
        $id= Auth::user()->id;
        $data=array();
        $data = \DB::table('tasas')->get() ;
       $data=$data->all();
        return view('administrar.tasas')->with(['data'=>$data]);
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
         $data=array('name'=>"Contacto");
            Mail::send('emails.welcome',$data,function($message){
                $message->from('kleiversteven6@gmail.com','Prueba');
                $message->to('caraquedeveloper@gmail.com')->subject('Mensaje de prueba');
            });
        return "Mensaje de prueba enviado";
    }
   
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        
        return view('site/inicio')->with(['monedas'=>$monedas,"tasas"=>$tasas]);
    }
    
    public function calcular(Request $request){
        $respons = $request->all();
        
        $data=array();
        $data = \DB::table('tasas')
                ->select('*')
                ->where(['isoa'=>$respons['isoa'],'isob'=>$respons['isob'] ])
                ->get();
        $data=$data->all();
        
         if(empty($data)){
       
            $data = \DB::table('tasas')
                    ->select('cambio')
                    ->where(['isob'=>$respons['isoa'],'isoa'=>$respons['isob']])
                    ->get();
                $tipo=2;
             $data=$data->all();
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
    public function sendmail(){
        $data=array('name'=>"Prueba");
            Mail::send('emails.welcome',$data,function($message){
                $message->from('kleiversteven6@gmail.com','Prueba');
                $message->to('caraquedeveloper@gmail.com')->subject('Mensaje de prueba');
            });
        return "Mensaje de prueba enviado";
                

    }
    
        
}

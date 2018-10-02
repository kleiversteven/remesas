<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;
use App\Bancos;
use App\Tasas;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\PasswordRequest;

class AdminController extends Controller
{
   use HasRoles;
   protected $guard_name = 'web';
    
   public function index(){
       $dolar = $this->calculadora('USD','VEF',1);
       $sol   = $this->calculadora('PEN','VEF',1);
       $depositos=$this->misdepositos(1);
       $procesados=$this->misdepositos(3);
       $resp = \DB::table('parametros')->get()->all();
        foreach($resp as $r){
            $data[$r->descpara]['status']= $r->valopara;
            $data[$r->descpara]['motivo']= $r->motivo;
        }
       $deudas=array();
       $user= Auth::user();
       if($user->hasRole('Super-admin') == true){
           
           $deudas= \DB::table('users')
             ->select('users.name',
                        'users.email',
                        'depositos_efectivo.moneda_into',    
                        'monedas.descripcion',
                        'depositos_efectivo.estatus',
                        'users.id',
                        \DB::raw('Sum(IF( ISNULL(salidas.referencia_out),0,salidas.monto_into)) AS trasferido'),      
                        'depositos_efectivo.monto_into AS total',    
                        \DB::raw('Count(depositos_efectivo.codeefec) AS transacciones'))
            ->join('depositos_efectivo','depositos_efectivo.codeuser','=','users.id')
            ->join('monedas','monedas.iso','=','depositos_efectivo.moneda_into')
            ->join('salidas','depositos_efectivo.codeefec','=','salidas.codeefec')
             ->whereIn('depositos_efectivo.estatus',array(1,3,4))
               ->where('depositos_efectivo.referencia_into','>',0)
             ->groupBy('users.id','depositos_efectivo.moneda_into')
             ->get();
           
       }
       
       
        return view('admin')->with(['deudas'=>$deudas,'dolar'=>$dolar,"sol"=>$sol,'depositos'=>$depositos,'procesados'=>$procesados,'parametros'=>$data,'deudas'=>$deudas]);
    }
    
    public function deudasuser(Request $request){
        $data=$request->all();
        
        $deudas= \DB::table('users')
             ->select('users.name',
                        'users.email',
                        'depositos_efectivo.moneda_into',    
                        'monedas.descripcion',
                        'depositos_efectivo.estatus',
                        'users.id',
                        'salidas.monto_into',
                        'depositos_efectivo.monto_into',
                        'depositos_efectivo.tasa',
                        'depositos_efectivo.fecha_into',
                        'depositos_efectivo.comision',
                        \DB::raw('Sum(IF( ISNULL(salidas.referencia_out),0,salidas.monto_into)) AS trasferido')
                       )
            ->join('depositos_efectivo','depositos_efectivo.codeuser','=','users.id')
            ->join('monedas','monedas.iso','=','depositos_efectivo.moneda_into')
            ->join('salidas','depositos_efectivo.codeefec','=','salidas.codeefec')
            ->whereIn('depositos_efectivo.estatus',array(1,3,4))
            ->where('depositos_efectivo.moneda_into','=',$data['iso'])
            ->where('users.id','=',$data['user'])
             ->groupBy('depositos_efectivo.codeefec')
             ->get();
        
        
        return json_encode($deudas);
    }
    public function profile(){
        $id= Auth::user()->id;
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
        $user=\DB::table('users')
            ->where(['id'=>$id])
            ->first();
        return view('usuarios.profile')->with(['usuario'=>$user,'countries'=>$country,'frecuentes'=>$frecuentes]);
    }
    public function profileuser($user){
        $id= Auth::user()->id;
         $country= \DB::table('countries')
             ->select('*')
             ->where(['status'=>'1'])
             ->orderBy('country')
             ->get();
         $frecuentes= \DB::table('frecuentes')
             ->select('frecuentes.codefrec','frecuentes.cedula','frecuentes.codibank','frecuentes.cuenta','frecuentes.titular',
                     \DB::raw('IF(frecuentes.tipo = 0 ,"Corriente","Ahorro") AS tipo'),'frecuentes.correo','bancos.banco')
            ->join('bancos','frecuentes.codibank','=','bancos.idbank')
             ->where(['.frecuentes.eliminado'=>'0','frecuentes.codeuser'=>$user])
             ->get();
        $user=\DB::table('users')
            ->where(['id'=>$user])
            ->first();
        return view('usuarios.profile')->with(['usuario'=>$user,'countries'=>$country,'frecuentes'=>$frecuentes]);
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
        return view('administrar.bancos')->with(['bancos'=>$data]);
    }
    public function tasas(Request $request){
        $id= Auth::user()->id;
        $data=array();
        $data = \DB::table('tasas')
             ->select('tasas.*','m_int.descripcion as entrada','m_out.descripcion as salida')
             ->join('monedas as m_int', 'm_int.iso', '=', 'tasas.isoa')
             ->join('monedas as m_out', 'm_out.iso', '=', 'tasas.isob')
            ->get() ;
        $data=$data->all();
        return view('administrar.tasas')->with(['tasas'=>$data]);
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
    public function savebanco(Request $request){
        $data=$request->all();
         $id_bank= \DB::table('bancos')->insertGetId(
            array(
                    'idcuenta'=>$data['cuenta'],
                    'banco'=>$data['desc'],
                    'entrada'=>$data['entrada'],
                    'salida'=>$data['salida']
                )
       );
        return $id_bank;
    }
    public function deletebanco(Request $request){
        $data=$request->all();
        $resp = \DB::table('bancos')
             ->where('idbank', $data['id'])
             ->update(['eliminado' => '1']);
        return $resp;
    }
    public function getbanco(Request $request){
        $data=$request->all();
        $resp = \DB::table('bancos')->where('idbank',$data['id'])->first();
        
        $resp=json_encode($resp);
        return $resp;
    }
    public function updatebanco(Request $request){
        $data=$request->all();
        
        $datos=array();
            if(!empty($data['cuenta'])){
                $datos['idcuenta']=$data['cuenta'];
            }
            if(!empty($data['desc'])){
                $datos['banco']=$data['desc'];
            }
        $datos['entrada']= $data['entrada'];
        $datos['salida']= $data['salida'];
        
        $resp = \DB::table('bancos')->where('idbank',$data['id'])->update($datos);
    }
    
    public function tasa(Request $request){
        $data=$request->all();
        $resp = \DB::table('tasas')->where('id',$data['id'])->first();
        $resp=json_encode($resp);
        return $resp;
    }
    
    public function cambiartasas(Request $request){
        $data=$request->all();
        

         if(!empty($data['camb'])){
            $datos['cambio']=$data['camb'];
        }
        if(!empty($data['may'])){
            $datos['mayorista']=$data['may'];
        }
        if(!empty($data['reca'])){
            $datos['recaudador']=$data['reca'];
        }
        if(!empty($datos))
        {
            \DB::table('tasas')->where('id',$data['id'])->update($datos);
        }
        
    }
    
    public function listarusuarios(Request $request){
        $users = \DB::table('users')
                ->select('users.*','model_has_roles.*','roles.name as rol_name')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.role_id','!=','3')
                ->get();
        $users = $users->all();
        return view('administrar.listaruser')->with(['users'=>$users]);
    }
    public function adduser(Request $request){
        $roles = \DB::table('roles')
                ->where('roles.id','!=','3')
                ->get();
        $roles= $roles->all();
        return view('usuarios.adduser')->with(['roles'=>$roles]);
    }
    function generarCodigo($longitud) {
         $key = '';
         $pattern = '1234567890abcdefghijklmnopqrstuvwxyz';
         $max = strlen($pattern)-1;
         for($i=0;$i < $longitud;$i++) $key .= $pattern{mt_rand(0,$max)};
         return $key;
    }
    public function create(UsersRequest $request)
    {
        $data= $request->all();
        $code=$this->generarCodigo(12);
        $email= $data['email'];
        $dates= array('name'=>$data['name'],'code'=>$code);
        $resp=$this->Email($dates,$email);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'confirmation_codemed' => $code
        ]);
        $user->assignRole($data['rol']);
        
        return redirect('listarusuarios')->with(['mensaje'=>' Usuario tipo '.$data['rol'].'  creado! ']); 
    }
    function Email($dates,$email){
      Mail::send('emails.welcome',$dates,function($message)use($email,$dates){
            $message->subject('Benvenid@ '.$dates['name'].' a LocalRemesas');
            $message->to($email);
            $message->from('atencionalcliente@localremesas.com','Bienvenid@ a LocalRemesas');
        });
    }
    
    public function estatus(Request $request){
        $data =$request->all();
        
        $resp = \DB::table('users')
             ->where('id', $data['id'])
             ->update(['estatus' => $data['estatus'] ]);
        return $data['estatus'];
    }
    public function upateuser(Request $request){
        $data =$request->all();
        $id= Auth::user()->id;
        
        if(!empty($data['nombre']))
            $query['name']=$data['nombre'];
        if(!empty($data['telefono']))
            $query['country']=$data['country'];
        if(!empty($data['telefono']))
            $query['telefono'] = $data['telefono'];
            
        $resp = \DB::table('users')
             ->where('id', $id)
             ->update($query);
        return redirect('perfil')->with(['mensaje'=>' Datos actualizados ']);
    }
   public function updateavatar(Request $request){
        $data =$request->all();
        $id= Auth::user()->id;
        $image['avatar']= Auth::user()->avatar;
        if($request->hasFile('avatar')){
            $image['avatar']=$request->file('avatar')->store('public/avatars');
        }
            
        $resp = \DB::table('users')
             ->where('id', $id)
             ->update($image);
        return redirect('perfil')->with(['mensaje'=>' Nueva imagen actualizada ']);
    }
    public function validarbanco(Request $request){
       
        $data=$request->all();
        if(!empty($data['cuenta']) ){
            $cue = substr($data['cuenta'],0,4);
            $resp = \DB::table('bancos')->where('idcuenta',$cue)->first();
            if(!empty($resp)){
                $resp=json_encode($resp);
            }else{
                $resp =0;
            }
        }else{
           $resp =0; 
        }
        return $resp;
    }
    public function parametros(){
       $resp = \DB::table('parametros')->get()->all();
        foreach($resp as $r){
            $data[$r->descpara]['status']= $r->valopara;
            $data[$r->descpara]['motivo']= $r->motivo;
        }
        return view('administrar.parametros')->with(['parametros'=>$data]);
    }
    public function bloqdepositos(Request $request){
       $data=$request->all();
        
        $datos['motivo']= $data['motivo'];
        $datos['valopara']= $data['check'];
       $resp = \DB::table('parametros')->where('descpara','BLOQUEO')->update($datos);
    }
    
   
}

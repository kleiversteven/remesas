<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PdfController extends Controller
{
    //
   public function pdfcliente($cliente=''){
        
        $pdf = PDF::loadView('reportes.cliente');
        return $pdf->download('ReportesCliente.pdf');
        
    }
    public function reportecliente(Request $request){
        $roles = array();
        $roles = \DB::table('roles')
                ->where('roles.id','!=','3')
                ->where('roles.id','!=','2')
                ->get();
        $roles= $roles->all();
        return view('administrar.pdfcliente')->with(['roles'=>$roles]);
    }
    public function usuarios(Request $request){
        $data=$request->all();
        $users = \DB::table('users')
                ->select('users.*','model_has_roles.*','roles.name as rol_name')
                ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')
                ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                ->where('model_has_roles.role_id','=',$data['id'])
                ->get();
        $users = json_encode($users->all());
        return $users;
    }
    public function reporteClientePdfdata(Request $request){
        
       $data= $request->all();
        if($data['clientes'] != 'null' && $data['clientes'] != 'undefined' && !empty($data['clientes']) && $data['clientes'] != 'all' && $data['rol'] != 'all'){
   
            $users= explode(',',$data['clientes']);
            $depositos =\DB::table('depositos')
            ->select('roles.name','depositos.moneda_into','depositos.banco_into','depositos.comprobante_into','depositos.referencia_into','monedas.descripcion','users.name as nombre',
                    \DB::raw('sum(depositos.monto_into) as monto_entrada'),
                    \DB::raw('sum(depositos.monto_out) as monto_salida'),
                    \DB::raw('count(depositos.idtrans) as depositos') )
            ->join('model_has_roles','model_has_roles.model_id','depositos.codeuser')
            ->join('roles','model_has_roles.role_id','roles.id')
            ->join('monedas','depositos.moneda_into','monedas.iso')
            ->join('users','users.id','depositos.codeuser')
            ->orderBy('depositos.fecha_into','DESC')
            ->groupBy('depositos.idtrans')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->whereIn('depositos.codeuser',$users)
            ->where('model_has_roles.role_id',$data['rol'])
            ->get();
            
        }elseif($data['rol'] != 'all'){
            $depositos =\DB::table('depositos')
            ->select('roles.name','depositos.moneda_into','depositos.banco_into','monedas.descripcion','users.name as nombre',
                    \DB::raw('sum(depositos.monto_into) as monto_entrada'),
                    \DB::raw('sum(depositos.monto_out) as monto_salida'),
                    \DB::raw('count(depositos.idtrans) as depositos') )
            ->join('model_has_roles','model_has_roles.model_id','depositos.codeuser')
            ->join('roles','model_has_roles.role_id','roles.id')
            ->join('monedas','depositos.moneda_into','monedas.iso')
            ->join('users','users.id','depositos.codeuser')
            ->orderBy('model_has_roles.role_id')
            ->groupBy('depositos.codeuser','depositos.moneda_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->where('model_has_roles.role_id',$data['rol'])->get();
        }else{
            $depositos =\DB::table('depositos')
            ->select('roles.name','depositos.moneda_into','depositos.banco_into','monedas.descripcion',
                    \DB::raw('sum(depositos.monto_into) as monto_entrada'),
                    \DB::raw('sum(depositos.monto_out) as monto_salida'),
                    \DB::raw('count(depositos.idtrans) as depositos') )
            ->join('model_has_roles','model_has_roles.model_id','depositos.codeuser')
            ->join('roles','model_has_roles.role_id','roles.id')
            ->join('monedas','depositos.moneda_into','monedas.iso')
            ->orderBy('model_has_roles.role_id')
            ->groupBy('model_has_roles.role_id','depositos.moneda_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->get();
        }
        $depositos=$depositos->all();
     if(!empty($depositos)){
        return json_encode($depositos);
     }else{
         return 0;
     }
        
        
        
    }
    public function reporteClientePdf(Request $request){
        date_default_timezone_set('America/Caracas');
        setlocale(LC_ALL,"es_ES");
        
        $data= $request->all();
        
        if($data['clientes'] != 'null' && $data['clientes'] != 'undefined' && !empty($data['clientes']) && $data['clientes'] != 'all' && $data['rol'] != 'all'){
   
            $users= explode(',',$data['clientes']);
            $depositos =\DB::table('depositos')
            ->select('roles.name','depositos.moneda_into','depositos.banco_into','depositos.comprobante_into','depositos.referencia_into','monedas.descripcion','users.name as nombre',
                    \DB::raw('sum(depositos.monto_into) as monto_entrada'),
                    \DB::raw('sum(depositos.monto_out) as monto_salida'),
                    \DB::raw('count(depositos.idtrans) as depositos') )
            ->join('model_has_roles','model_has_roles.model_id','depositos.codeuser')
            ->join('roles','model_has_roles.role_id','roles.id')
            ->join('monedas','depositos.moneda_into','monedas.iso')
            ->join('users','users.id','depositos.codeuser')
            ->orderBy('depositos.fecha_into','DESC')
            ->groupBy('depositos.idtrans')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->whereIn('depositos.codeuser',$users)
            ->where('model_has_roles.role_id',$data['rol'])
            ->get();
            $depositos=$depositos->all();
            $pdf = PDF::loadView('reportes.clientedetalle', ['depositos'=>$depositos,'desde'=>$data['desde'],'hasta'=>$data['hasta'],'rol'=>$data['rol']]);
            return $pdf->download('reporte.pdf');
            
        }elseif($data['rol'] != 'all'){
            $depositos =\DB::table('depositos')
            ->select('roles.name','depositos.moneda_into','depositos.banco_into','monedas.descripcion','users.name as nombre',
                    \DB::raw('sum(depositos.monto_into) as monto_entrada'),
                    \DB::raw('sum(depositos.monto_out) as monto_salida'),
                    \DB::raw('count(depositos.idtrans) as depositos') )
            ->join('model_has_roles','model_has_roles.model_id','depositos.codeuser')
            ->join('roles','model_has_roles.role_id','roles.id')
            ->join('monedas','depositos.moneda_into','monedas.iso')
            ->join('users','users.id','depositos.codeuser')
            ->orderBy('model_has_roles.role_id')
            ->groupBy('depositos.codeuser','depositos.moneda_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->where('model_has_roles.role_id',$data['rol'])->get();
            $depositos=$depositos->all();
            $pdf = PDF::loadView('reportes.role', ['depositos'=>$depositos,'desde'=>$data['desde'],'hasta'=>$data['hasta'],'rol'=>$data['rol']]);
            return $pdf->download('reporte.pdf');
        }else{
            $depositos =\DB::table('depositos')
            ->select('roles.name','depositos.moneda_into','depositos.banco_into','monedas.descripcion',
                    \DB::raw('sum(depositos.monto_into) as monto_entrada'),
                    \DB::raw('sum(depositos.monto_out) as monto_salida'),
                    \DB::raw('count(depositos.idtrans) as depositos') )
            ->join('model_has_roles','model_has_roles.model_id','depositos.codeuser')
            ->join('roles','model_has_roles.role_id','roles.id')
            ->join('monedas','depositos.moneda_into','monedas.iso')
            ->orderBy('model_has_roles.role_id')
            ->groupBy('model_has_roles.role_id','depositos.moneda_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->get();
            $depositos=$depositos->all();
            $pdf = PDF::loadView('reportes.cliente', ['depositos'=>$depositos,'desde'=>$data['desde'],'hasta'=>$data['hasta']]);
            return $pdf->download('reporte.pdf');
        }
        
    }
    public function reportebanco(Request $request){
        return view('administrar.pdfbanco');
    }
    
    public function reporteBancoPdfData(Request $request){
        
       $data= $request->all();
        if( $data['resumido']==0){
            $depositos =\DB::table('depositos')
            ->select('depositos.banco_into','depositos.tasa','depositos.moneda_into','depositos.monto_into','depositos.monto_out','bancos.banco','depositos.fecha_into')
            ->join('bancos','bancos.idbank','depositos.banco_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->get();
            
        }elseif($data['resumido'] == 1){
            $depositos =\DB::table('depositos')
            ->select('depositos.banco_into','depositos.tasa','depositos.moneda_into',
                     \DB::raw('sum(depositos.monto_into) as monto'),
                     \DB::raw('COUNT(depositos.banco_into) as movimientos'),
                     'depositos.monto_into','depositos.monto_out','bancos.banco','depositos.fecha_into')
            ->join('bancos','bancos.idbank','depositos.banco_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->groupBy('depositos.banco_into')
            ->get();
        }
        $depositos=$depositos->all();
        
         if(!empty($depositos)){
            return json_encode($depositos);
         }else{
             return 0;
         }
        
        
        
    }
    
    public function reportebancoPdf(Request $request){
        
       $data= $request->all();
        if( $data['resumido']==0){
            $depositos =\DB::table('depositos')
            ->select('depositos.banco_into','depositos.tasa','depositos.moneda_into','depositos.monto_into','depositos.monto_out','bancos.banco','depositos.fecha_into')
            ->join('bancos','bancos.idbank','depositos.banco_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->get();
            
        }elseif($data['resumido'] == 1){
            $depositos =\DB::table('depositos')
            ->select('depositos.banco_into','depositos.tasa','depositos.moneda_into',
                     \DB::raw('sum(depositos.monto_into) as monto'),
                     \DB::raw('COUNT(depositos.banco_into) as movimientos'),
                     'depositos.monto_into','depositos.monto_out','bancos.banco','depositos.fecha_into')
            ->join('bancos','bancos.idbank','depositos.banco_into')
            ->whereBetween('depositos.fecha_into',[$data['desde'],$data['hasta']])
            ->groupBy('depositos.banco_into')
            ->get();
        }
        $depositos=$depositos->all();
        
        
         $pdf = PDF::loadView('reportes.banco', ['depositos'=>$depositos,'desde'=>$data['desde'],'hasta'=>$data['hasta'],'resumido'=>$data['resumido']]);
         return $pdf->download('reporte.pdf');
        
    }
    
}

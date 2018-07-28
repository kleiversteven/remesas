<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\MyResetPassword;
use App\Http\Requests\PasswordRequest;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function activate($code){
        $users =User::where('confirmation_codemed',$code);
        $exist = $users->count();
        $user = $users->first();
        if($exist == 1 && $user->active == 0){
            $usuario =User::find($user->id);
            $usuario->confirmed=1;
            $usuario->save();
            Auth::login($usuario);
            return Redirect()->to('/');
        }else{
           return Redirect()->to('/');
        }
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatepass(PasswordRequest $request){
        
        $data =$request->all();
            if(Hash::check($data['pass'],Auth::user()->password)){
                $user = new User;
                $user->where('email','=',Auth::user()->email)
                    ->update(['password' => bcrypt($data['password'])] );
                return redirect('perfil')->with(['mensaje'=>' Datos actualizados ']);
            }else{
                return redirect('perfil')->with(['mensaje'=>' Contraseña actual invalida']);

            }
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $rol = $user->roles->implode('name',',');
        switch($rol){
            case 'cliente':
                $saludo = "Bienvenido";
                return view('home',compact('saludo'));
            break;
            case 'super-admin':
                $saludo = "Bienvenido";
                return view('home',compact('saludo'));
            break;
            case 'developers':
                $saludo = "Bienvenido";
                return view('home',compact('saludo'));
            break;
        }
        
    }
}

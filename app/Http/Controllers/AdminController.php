<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function index(){
        
        return view('admin');
    }
    public function profile(){
        
        return view('usuarios.profile');
    }
   
}

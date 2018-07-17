<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\DepositosController;


 Route::get('/inicio', 'siteController@index' ); 
 Route::get('/', 'siteController@index' ); 
 Route::get('/calcular', 'siteController@calcular' ); 
 Route::get('/respuesta', 'siteController@respuesta' ); 
 Route::get('/activacion/{code?}', 'UserController@activate' ); 

Route::get('/contacto', function () {
    return view('contacto');
});
Auth::routes();


Route::group(['prefix'=>'/','middleware'=>['auth'] ],function(){
    Route::get('/administrar', 'AdminController@index' );
    
    Route::get('/depositos', 'DepositosController@cargardeposito' );
    Route::post('/savedeposito', 'DepositosController@savedeposito' );
    Route::get('/misdepositos', 'DepositosController@listardepositos');
    Route::get('/listardepositos', 'DepositosController@alldepositos');
    
    Route::get('/bancos', 'AdminController@bancos');
    Route::get('/tasas', 'AdminController@tasas');
    
    
    //PERFIL
    Route::get('/perfil', 'AdminController@profile' );
});


//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/sendmail', 'siteController@sendmail');

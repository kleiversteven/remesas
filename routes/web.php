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
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PdfController;


 Route::get('/inicio', 'siteController@index' ); 
 Route::get('/', 'siteController@index' ); 
 Route::get('/calcular', 'siteController@calcular' ); 
 Route::get('/respuesta', 'siteController@respuesta' ); 
 Route::get('/activacion/{code?}', 'UserController@activate' ); 

//Enviar correo
    Route::get('/enviarcorreo', 'siteController@enviarcorreo' );

Route::get('/contacto','siteController@contacto');

Auth::routes();


Route::group(['prefix'=>'/','middleware'=>['auth'] ],function(){
    
    
    Route::get('/administrar', 'AdminController@index' );
    
    Route::get('/depositos', 'DepositosController@cargardeposito' );
    
    Route::post('/savecuenta', 'DepositosController@savecuenta' );
    
    Route::post('/savedeposito', 'DepositosController@savedeposito' );
    Route::get('/misdepositos', 'DepositosController@listardepositos');
    Route::get('/listardepositos', 'DepositosController@alldepositos');
    Route::get('/modtransaccion', 'DepositosController@modtransaccion');
    Route::get('/efectivo', 'DepositosController@efectivo');
    
    Route::get('/bancos', 'AdminController@bancos');
    
    Route::get('/cambiartasas', 'AdminController@cambiartasas');
    Route::get('/tasa', 'AdminController@tasa');
    
    Route::get('/savebanco', 'AdminController@savebanco');
    Route::get('/deletebanco', 'AdminController@deletebanco');
    Route::get('/getbanco', 'AdminController@getbanco');
    Route::get('/updatebanco', 'AdminController@updatebanco');
    Route::get('/validarbanco', 'AdminController@validarbanco');
    
    Route::get('/tasas', 'AdminController@tasas');
    
    
    //PERFIL
    Route::get('/perfil', 'AdminController@profile' );
    Route::get('/perfil/{user}', 'AdminController@profileuser' );
    Route::get('/listarusuarios', 'AdminController@listarusuarios' );
    Route::get('/adduser', 'AdminController@adduser' );
    Route::post('/saveuser', 'AdminController@create' );
    Route::post('/upateuser', 'AdminController@upateuser' );
    Route::post('/updateavatar', 'AdminController@updateavatar' );
    Route::post('/updatepass', 'UserController@updatepass' );
    
    Route::get('/estatus', 'AdminController@estatus' );
    Route::get('/parametros', 'AdminController@parametros' );
    Route::get('/bloqdepositos', 'AdminController@bloqdepositos' );
    
    Route::get('/transaccion/{transc?}', 'DepositosController@transaccion');
    Route::get('/informacion/{transc?}', 'DepositosController@informacion');
    
    
    
    
    Route::post('/savereferencia', 'DepositosController@savereferencia');
    
    
    Route::get('/reportebanco', 'PdfController@reportebanco');
    Route::get('/reporteBancoPdfData', 'PdfController@reporteBancoPdfData');
    Route::get('/reportebancoPdf', 'PdfController@reportebancoPdf');
    
    
    Route::get('/pdfcliente', 'PdfController@pdfcliente');
    Route::get('/reportecliente', 'PdfController@reportecliente');
    Route::get('/usuarios', 'PdfController@usuarios');
    Route::get('/reporteClientePdf', 'PdfController@reporteClientePdf');
    Route::get('/reporteClientePdfData', 'PdfController@reporteClientePdfdata');
    
    Route::get('/notificacion', 'DepositosController@notificacion');
    
    
});



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

Route::get('/', function () {
    return redirect('login');
});



Auth::routes(['register' => false]);
Auth::routes(['verify' => true]);

Route::group(['middleware' => ['verified' , 'passwd_changed']], function(){
	Route::get('/home', 'HomeController@index');
});


Route::get('password', 'Auth\ChangePasswordController@showForm')->name('password');
Route::patch('password', 'Auth\ChangePasswordController@updatePassword')->name('password.change');

//Route::get('aeronaves', 'AeronaveController@index');

Route::resource('aeronaves', 'AeronaveController')->parameters(['aeronaves' => 'aeronave']);;
//Route::get('aeronaves{aeronave}/edit', 'AeronaveController@edit($aeronave)');
//
Route::resource('socios', 'SocioController');

Route::patch('socios/{socio}/ativo', 'SocioController@mudarEstado')->name('socios.mudarEstado');
Route::patch('socios/{socio}/quota', 'SocioController@mudarEstadoQuota')->name('socios.mudarEstadoQuota');
Route::get('socios/{socio}/send_reactivate_email', 'SocioController@enviarEmailConfirmacao')->name('socios.enviarEmailConfirmacao');

Route::resource('movimentos', 'MovimentoController');


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

Route::group(['middleware' => ['verified' , 'passwd_changed', 'deleted']], function(){
	Route::get('/home', 'HomeController@index');
});


Route::get('password', 'Auth\ChangePasswordController@showForm')->name('password');
Route::patch('password', 'Auth\ChangePasswordController@updatePassword')->name('password.change');

//Route::get('aeronaves', 'AeronaveController@index');

Route::get('aeronaves/linha_temporal', 'AeronaveController@linhaTemporal')->name('aeronaves.linhaTemporal');

Route::resource('aeronaves', 'AeronaveController')->parameters(['aeronaves' => 'aeronave']);
//Route::get('aeronaves{aeronave}/edit', 'AeronaveController@edit($aeronave)');
Route::patch('socios/reset_quotas', 'SocioController@resetQuotas')->name('socios.resetQuotas')->middleware('direcao');
Route::patch('socios/desativar_sem_quotas', 'SocioController@desativarSemQuotas')->name('socios.desativarSemQuotas')->middleware('direcao');

Route::resource('socios', 'SocioController');

Route::patch('socios/{socio}/ativo', 'SocioController@mudarEstado')->name('socios.mudarEstado')->middleware('direcao');
Route::patch('socios/{socio}/quota', 'SocioController@mudarEstadoQuota')->name('socios.mudarEstadoQuota')->middleware('direcao');
Route::get('socios/{socio}/send_reactivate_email', 'SocioController@enviarEmailConfirmacao')->name('socios.enviarEmailConfirmacao')->middleware('direcao');

Route::get('pilotos/{piloto}/certificado', 'SocioController@mostrarFicheiroCertificado')->name('pilotos.mostrarFicheiroCertificado')->middleware('ativo');
Route::get('pilotos/{piloto}/licenca', 'SocioController@mostrarFicheiroLicenca')->name('pilotos.mostrarFicheiroLicenca')->middleware('ativo');


Route::get('aeronaves/{aeronave}/pilotos', 'AeronavePilotosController@index')->middleware('direcao');

Route::get('aeronaves/{aeronave}/precos_tempos' ,'AeronaveController@getJson')->name('aeronaves.json')->middleware('ativo');

Route::post('aeronaves/{aeronave}/pilotos/{piloto}', 'AeronavePilotosController@store')->middleware('direcao');

Route::delete('aeronaves/{aeronave}/pilotos/{piloto}', 'AeronavePilotosController@destroy')->name('pilotos.delete')->middleware('direcao');


Route::post('aeronaves/{aeronave}/pilotos/{piloto}', 'AeronavePilotosController@store')->name('pilotos.add')->middleware('direcao');

Route::get('movimentos/estatisticas', 'MovimentoController@statistics')->name('movimentos.estatisticas')->middleware('ativo');

Route::get('/pendentes','MovimentoController@pendentes')->name('movimentos.pendentes')->middleware('direcao');

Route::resource('movimentos', 'MovimentoController');

Route::patch('/confirm',"MovimentoController@confirm")->middleware('direcao');



<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('email', 'UsuarioController@concidencias');

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('register', 'AuthController@register');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('recovery', 'AuthController@recovery');
    Route::post('password', 'AuthController@password');
});

Route::prefix('tabla-aportes')->group(function () {
	Route::get('', 'TablaAporteController@tabla');
	Route::get('importes', 'TablaAporteController@importes');
	Route::get('detalles', 'TablaAporteController@detalles');
	Route::get('subcertificaciones', 'TablaAporteController@subcertificaciones');
	Route::post('detalles/reporte', 'TablaAporteController@reporte');
});

Route::prefix('novedades')->group(function(){
	Route::get('', 'NovedadController@index');
});

Route::prefix('afiliados')->group(function(){
	Route::get('colegios','AfiliadoController@consejos_colegios');
	Route::post('buscar', 'AfiliadoController@buscar');
	Route::post('{matricula}/certificado/convenio', 'AfiliadoController@certificado_convenio');
	Route::post('{matricula}/certificado/comun', 'AfiliadoController@certificado_comun');
	Route::post('{matricula}/certificado/reciprocidad', 'AfiliadoController@certificado_reciprocidad');
});

Route::group(['middleware' => 'jwt'], function(){
	Route::prefix('convenios')->group(function(){
		Route::get('', 'ConvenioController@index');
		Route::get('localidades', 'ConvenioController@localidades');
		Route::get('provincias', 'ConvenioController@provincias');
		Route::get('tipos', 'ConvenioController@tipos');
	});
});
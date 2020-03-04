<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware( 'auth:api' )->get( '/user', function ( Request $request ) {
	return $request->user();
} );
Route::group( [
	'prefix' => 'auth'
], function () {
	Route::post( 'login', 'AuthController@login' )->name( 'login' );
	Route::post( 'register', 'AuthController@register' );
	Route::group( [
		'middleware' => 'auth:api'
	], function () {
		Route::get( 'logout', 'AuthController@logout' );
		Route::get( 'user', 'AuthController@user' );
	} );
} );
Route::post( "/forgot", "AuthController@forgot" ); //submit forgot password
Route::post( "/reset", "AuthController@resetPwd" ); //reset password

////index
//Route::middleware('auth:api')->get('/{controller}', function($variable_name){
//    $app = app();
//    $controller = $app->make("\App\Http\Controllers\\". $variable_name. "Controller");
//    return $controller->callAction('index', $parameters = array());
//})->where('variable_name', '[A-Za-z]+');
//
////store
//Route::middleware('auth:api')->post('/{controller}', function($variable_name){
//	$app = app();
//	$controller = $app->make("\App\Http\Controllers\\". $variable_name. "Controller");
//	return $controller->callAction('store', $parameters = array());
//})->where('variable_name', '[A-Za-z]+');
//
////no need create route
//
////destroy
//Route::middleware('auth:api')->delete('/{controller}/{id}', function($variable_name, $id){
//	$app = app();
//	$controller = $app->make("\App\Http\Controllers\\". $variable_name. "Controller");
//	return $controller->callAction('destroy', $parameters = array($id));
//})->where('variable_name', '[A-Za-z]+');
//
////show
//Route::middleware('auth:api')->get('/{controller}/{id}', function($variable_name,$id){
//	$app = app();
//	$controller = $app->make("\App\Http\Controllers\\". $variable_name. "Controller");
//	return $controller->callAction('show', $parameters = array($id));
//})->where('variable_name', '[A-Za-z]+');
//
////update
//Route::middleware('auth:api')->patch('/{controller}', function($variable_name,$id){
//	$app = app();
//	$controller = $app->make("\App\Http\Controllers\\". $variable_name. "Controller");
//	return $controller->callAction('update', $parameters = array($id));
//})->where('variable_name', '[A-Za-z]+');
//
////edit
//Route::middleware('auth:api')->get('/{controller}/{id}/edit', function($variable_name,$id){
//	$app = app();
//	$controller = $app->make("\App\Http\Controllers\\". $variable_name. "Controller");
//	return $controller->callAction('edit', $parameters = array($id));
//})->where('variable_name', '[A-Za-z]+');


Route::middleware( 'auth:api' )->resource( "/classrooms", "ClassroomController" );
Route::middleware( 'auth:api' )->resource( "/computers", "ComputerController" );
Route::middleware( 'auth:api' )->resource( "/ip", "IPController" );
Route::middleware( 'auth:api' )->resource( "/labs", "LabController" );
Route::middleware( 'auth:api' )->resource( "/projectors", "ProjectorController" );
Route::middleware( 'auth:api' )->resource( "/qc_configures", "QCConfigureListController" );
Route::middleware( 'auth:api' )->resource( "/qc", "QualityCheckController" );





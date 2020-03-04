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

//Route::get('/', function () {
//    return view('welcome');
//});

//later below link will show as the ionic link
Route::get( 'password/reset/{token}', function () {
	return response()->json( [
		'message' => "Error! Unauthorised page visited!"
	], 404 );
} )->name( 'password.request' );

Route::post( 'password/reset', function () {
	return response()->json( [
		'message' => "Error! Unauthorised page visited!"
	], 404 );
} )->name( 'password.reset' );

Route::post( 'reset', function () { //for frontend url, not for backend
	return null;
} )->name( 'custom_password_reset' );

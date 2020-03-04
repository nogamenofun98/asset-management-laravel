<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;


class AuthController extends Controller {
	use SendsPasswordResetEmails, ResetsPasswords {
		ResetsPasswords::broker insteadof SendsPasswordResetEmails;
	}

	public function register( Request $request ) {
		$data  = $request->validate( [
			'name'     => 'required|string',
			'email'    => 'required|string|email|unique:users',
			'password' => 'required|string'
		] );
		$user  = User::create( $data );
		$token = auth( "api" )->login( $user );


		return $this->respondWithToken( $token, 0 );
	}

	protected function respondWithToken( $token, $isRememberMe ) {
		return response()->json( [
			'access_token' => $token,
			'token_type'   => 'bearer',
//			'expires_in'   => ( $isRememberMe ) ? auth( "api" )->factory()->getTTL() * 8760 : auth( "api" )->factory()->getTTL() * 1
//			'expires_in'   => 1
		] );
	}

	public function login() {
		request()->validate( [
			'email'       => 'required|string|email',
			'password'    => 'required|string',
			'remember_me' => 'boolean'
		] );
		$credentials = request( [ 'email', 'password' ] );

		if ( ! $token = auth( "api" )->attempt( $credentials ) ) {
			return response()->json( [ "error" => "Unauthorized Access!" ], 401 );
		} else {
			if ( request()->remember_me ) {
				return $this->respondWithToken( $token, true ); //longer time
			} else {
				return $this->respondWithToken( $token, false );
			}
		}


	}

	public function logout() {
		auth( "api" )->logout();

		return response()->json( [ 'message' => "You have successfully logged out." ] );

	}

	public function forgot( Request $request ) //route api controller method
	{
//		dd("is forgot");
		$data = request()->validate( [
			'email' => 'required|string|email',
		] );
		$user = User::where( 'email', $data )->first();
		if ( ! $user ) {
			$error_message = "Your email address was not found.";

			return response()->json( [ 'error' => [ 'email' => $error_message ] ], 401 );
		}

//		$response = Password::sendResetLink($request->only('email'));
//		dump($response);

		//sendresetlinkemail alrdy contain email validation
		return $this->sendResetLinkEmail( $request ); //can customize in the ResetPassword class
//		dump($test);
//		return $test;
//		return response()->json([
//			'message'=> 'A reset email has been sent! Please check your email.'
//		]);

	}

	public function resetPwd( Request $request ) { //route api controller method
		//reset method alrdy contain validation
//		dd("is reset");
		return $this->reset( $request );   //there is
	}

	public function user( Request $request ) {
		return response()->json( $request->user() );
	}

	protected function sendResetLinkResponse( Request $request, $response ) {
		return response()->json( [
			'message' => 'A reset email has been sent! Please check your email.'
		], 200 );

	}

	protected function sendResetLinkFailedResponse( Request $request, $response ) {
		return response()->json( [
			'error' => 'Email could not be sent to this email address!'
		], 401 );
	}

	protected function resetPassword( $user, $password ) {
		$user->password = $password; //no need bcrypt becoz it is auto hashing in the user model class there by setPasswordAttribute method
		$user->save();
		event( new PasswordReset( $user ) );
	}

	protected function sendResetResponse( Request $request, $response ) {
		return response()->json( [
			"message" => "Password reset successfully!"
		] );
	}

	protected function sendResetFailedResponse( Request $request, $response ) {
		return response()->json( [
			"error" => "Password reset failed! Please do no reuse reset token!"
		], 403 );
	}
}

<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Handler extends ExceptionHandler {
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param \Exception $exception
	 *
	 * @return \Illuminate\Http\JsonResponse
	 * @throws Exception
	 */
	public function report( Exception $exception ) {
		parent::report( $exception );
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Exception $exception
	 *
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
	 */
	public function render( $request, Exception $exception ) {
		if ( $exception instanceof TokenExpiredException ) {
			//1) refresh if ttl within 2 week, else reject refresh
			try {
				$newToken = auth()->refresh();
//				if ( ! $user = auth()->user() ) {
//					Log::info("is not user auth");
//					return response()->json( [
//						'code' => 101, // means auth error in the api,
//						'response' => null // nothing to show
//					]);
//				}
			} catch ( TokenExpiredException $e ) {
				Log::info( "if token exp" );
				// If the token is expired, then it will be refreshed and added to the headers
				try {
//				$refreshed = JWTAuth::refresh( JWTAuth::getToken() );
					$refreshed = auth()->refresh();
					$user      = JWTAuth::setToken( $refreshed )->toUser();
					header( 'Authorization: Bearer ' . $refreshed );
				} catch ( Exception $e ) {
					Log::info( "if jwt exp" );
					Log::info( print_r( $e ) );

					return response()->json( [
						'code'     => 103, // means not refreshable
						'response' => null // nothing to show
					] );
				}
			} catch ( JWTException $e ) {
				Log::info( "if jwt exp 2" );

				return response()->json( [
					'code'     => 101, // means auth error in the api,
					'response' => null // nothing to show
				] );
			}
			Log::info( "is after try" );
			// Login the user instance for global usage
			Auth::login( $user, false );


//			return Response::json( [
//				'error' => "Unauthenticated, token expired!"
//			], 401 );
		} else if ( $exception instanceof TokenInvalidException ) {
			return Response::json( [
				'error' => "Unauthenticated, token invalid!"
			], 401 );
		} else if ( $exception instanceof TokenBlacklistedException ) {
			return Response::json( [
				'error' => "Unauthenticated, token blacklisted!"
			], 401 );
		} else if ( $exception instanceof ModelNotFoundException ) {
			$model_name = explode( "\\", $exception->getModel() );

			// Do your stuff here
			return Response::json( [
				'error' => "Invalid $model_name[1] identifier queried!"
			], 422 );
		} else if ( $exception instanceof AuthenticationException ) {
			return Response::json( [
				'error' => "Unauthenticated, please check your username and password!"
			], 401 );

		} else {
			return parent::render( $request, $exception );
		}
	}
}

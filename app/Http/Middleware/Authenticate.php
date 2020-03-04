<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware {
	protected function authenticate( $request, array $guards ) {
		if ( empty( $guards ) ) {
			$guards = [ null ];
		}

		foreach ( $guards as $guard ) {
			if ( $this->auth->guard( $guard )->check() ) {
				return $this->auth->shouldUse( $guard );
			} elseif ( $guard == 'api' ) {
				// check() returns false means that throws JWTException
				return $this->auth->guard( $guard )->checkOrFail();
			}
		}

		throw new AuthenticationException(
			'Unauthenticated.', $guards, $this->redirectTo( $request )
		);
	}

	/**
	 * Get the path the user should be redirected to when they are not authenticated.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return string
	 */
	protected function redirectTo( $request ) {
//    	Log::info('redirecto');


		if ( ! $request->expectsJson() ) {
//	        return Response::json([
//		        'data' => ["error"=>"You must login first before can proceed!"]
//	        ], 401);
			return route( 'login' );
		}
	}
}

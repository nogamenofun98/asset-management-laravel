<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;

class MailResetPasswordNotification extends ResetPassword {
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @param $token
	 */
	public function __construct( $token ) {
		parent::__construct( $token );
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function via( $notifiable ) {
		return [ 'mail' ];
	}

	/**
	 * Get the mail representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return \Illuminate\Notifications\Messages\MailMessage
	 */
	public function toMail( $notifiable ) {
		if ( static::$toMailCallback ) {
			return call_user_func( static::$toMailCallback, $notifiable, $this->token );
		}

		return ( new MailMessage )
			->subject( Lang::getFromJson( 'Reset Password Notification' ) )
			->line( Lang::getFromJson( 'You are receiving this email because we received a password reset request for your account.' ) )
			->action( Lang::getFromJson( 'Reset Password' ), url( config( 'app.frontend_url' ) . route( 'custom_password_reset', [ 'token' => $this->token ], false ) ) )
			->line( Lang::getFromJson( 'This password reset link will expire in :count minutes.', [ 'count' => config( 'auth.passwords.users.expire' ) ] ) )
			->line( Lang::getFromJson( 'If you did not request a password reset, no further action is required.' ) );
	}

	/**
	 * Get the array representation of the notification.
	 *
	 * @param mixed $notifiable
	 *
	 * @return array
	 */
	public function toArray( $notifiable ) {
		return [
			//
		];
	}
}

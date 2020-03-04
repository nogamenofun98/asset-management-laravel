<?php

namespace App;

use App\Notifications\MailResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject {
	use CanResetPassword, Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'email',
		'password',
	];
	protected $guarded = [
		"id"
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'email_verified_at' => 'datetime',
	];

	/*
	 * Query qc histories that belong to this user
	 *
	 * @var qc_model
	 * */
	public function qc_histories() {
		return $this->hasMany( QualityCheck::class );
	}

	public function getJWTIdentifier() {
		return $this->getKey();
	}

	public function getJWTCustomClaims() {
		return [];
	}

	public function setPasswordAttribute( $password ) {
		if ( ! empty( $password ) ) {
			$this->attributes['password'] = bcrypt( $password );
		}
	}

	public function sendPasswordResetNotification( $token ) {
		$this->notify( new MailResetPasswordNotification( $token ) );
	}


}

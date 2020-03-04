<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projector extends Model {
	protected $guarded = [
		"id"
	];
//	protected $hidden = [
//		'created_at','updated_at'
//	];

	public function classroom() {
		return $this->hasOne( Classroom::class );
	}
}

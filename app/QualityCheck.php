<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QualityCheck extends Model {
	protected $guarded = [
		"id"
	];

	public function user() {
		return $this->belongsTo( User::class );
	}

	public function classroom() {
		return $this->belongsTo( Classroom::class );
	}

	public function classroom_configure() {
		return $this->classroom->configuration(); //->classroom refer to classroom()
	}
}

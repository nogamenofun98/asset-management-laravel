<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lab extends Model {
	protected $guarded = [
		"id"
	];

	public function computers() {
		return $this->hasMany( Computer::class );
	}
}

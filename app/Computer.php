<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Computer extends Model {
	protected $guarded = [
		"id"
	];

	public function lab() {
		return $this->belongsTo( Lab::class );
	}
}

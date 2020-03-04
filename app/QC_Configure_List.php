<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QC_Configure_List extends Model {
	protected $guarded = [
		"id"
	];

	public function classrooms() {
		return $this->hasMany( Classroom::class, "qc_configure_list_id" );
	}
}

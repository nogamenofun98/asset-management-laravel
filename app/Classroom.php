<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model {
	protected $guarded = [
		"id"
	];

	public function projector() {
		return $this->belongsTo( Projector::class );
	}

	public function configuration() {
		return $this->belongsTo( QC_Configure_List::class, "qc_configure_list_id" );
	}

	public function qc_histories() {
		return $this->hasMany( QualityCheck::class );
	}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectorsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'projectors', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( "projector_label" );
			$table->string( "model" );
			$table->string( "serial_number" );
			$table->unsignedInteger( "lamp_hour" );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'projectors' );
	}
}

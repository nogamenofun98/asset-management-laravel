<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClassroomsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'classrooms', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( "class_label" );
			$table->string( "campus" );
			$table->boolean( "isAud" )->default( false );
			$table->unsignedInteger( "projector_id" )->nullable();
			$table->ipAddress( "projector_ip" )->nullable();
			$table->unsignedInteger( "qc_configure_list_id" )->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'classrooms' );
	}
}

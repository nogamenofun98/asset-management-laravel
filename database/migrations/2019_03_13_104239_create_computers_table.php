<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComputersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'computers', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->string( "pc_label" );
			$table->string( "model" );
			$table->string( "serial_number" );
			$table->json( "specification" )->nullable();
			$table->unsignedInteger( "lab_id" )->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'computers' );
	}
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityChecksTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'quality_checks', function ( Blueprint $table ) {
			$table->bigIncrements( 'id' );
			$table->unsignedInteger( "classroom_id" );
			$table->json( "config_result" )->default( null ); //create table column dynamically based on those value
			$table->unsignedInteger( "user_id" );
			$table->string( "remark" )->nullable();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'quality_checks' );
	}
}

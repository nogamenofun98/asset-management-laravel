<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define( App\Computer::class, function ( Faker $faker ) {
	return [
		"pc_label"      => Str::random( 5 ),
		"model"         => Str::random( 6 ),
		"serial_number" => Str::random( 10 ),
	];
} );

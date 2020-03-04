<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define( App\Projector::class, function ( Faker $faker ) {
	return [
		"projector_label" => Str::random( 5 ),
		"model"           => Str::random( 6 ),
		"serial_number"   => Str::random( 10 ),
		"lamp_hour"       => $faker->numberBetween( 1000, 5000 ),
	];
} );

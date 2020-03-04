<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define( App\Classroom::class, function ( Faker $faker ) {
	return [
		"projector_ip" => $faker->localIpv4,
		"class_label"  => Str::random( 5 ),
		"campus"       => ( $faker->boolean( 50 ) ) ? "apu" : "apiit",

	];
} );

<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define( App\Lab::class, function ( Faker $faker ) {
	return [
		"lab_label" => Str::random( 5 ),
		"campus"    => ( $faker->boolean( 50 ) ) ? "apu" : "apiit",
	];
} );

<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define( App\IP::class, function ( Faker $faker ) {
	return [
		"ip"     => $faker->ipv4,
		"isp"    => Str::random( 5 ),
		"campus" => ( $faker->boolean( 50 ) ) ? "apu" : "apiit",
	];
} );

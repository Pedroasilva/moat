<?php

use Illuminate\Support\Facades\Hash;

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\User::class, function (Faker $faker) {
	$role = App\UserRole::where('name', 'participant')->first();

    return [
        'name'     		=> $faker->name,
        'username'    	=> $faker->unique()->userName,
        'email'    		=> $faker->unique()->email,
        'password' 		=> Hash::make('123456'),
        'role'			=> $role->role_id
    ];
});
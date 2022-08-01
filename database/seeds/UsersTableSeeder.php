<?php

namespace Database\Seeders;

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker)
    {
        $user = \App\UserRole::where('name', 'administrator')->first();
        \App\User::create([
            'name' => 'USER: '.$faker->name,
            'username' => 'user',
            'email' => 'user@moat.com',
            'password' => Hash::make('123456'),
            'role' => $user->role_id,
            'establishment' => 1,
            'status' => 1,
            'verified' => 1,
        ]);

        $admin = \App\UserRole::where('name', 'comercial')->first();
        \App\User::create([
            'name' => 'ADMIN: '.$faker->name,
            'username' => 'admin',
            'email' => 'admin@moat.com',
            'password' => Hash::make('123456'),
            'role' => $admin->role_id,
            'establishment' => 1,
            'status' => 1,
            'verified' => 1,
        ]);
    }
}

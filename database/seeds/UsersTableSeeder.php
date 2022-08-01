<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $admin = \App\UserRole::where('name', 'administrator')->first();
        \App\User::create([
            'name'                  => 'ADM: '.$faker->name,
            'username'              => 'admin',
            'email'                 => 'admin@user.com',
            'password'              => Hash::make('_123456adm!'),
            'role'                  => $admin->role_id,
            'establishment'         => 1,
            'status'                => 1,
            'verified'              => 1
        ]);

        $comercial = \App\UserRole::where('name', 'comercial')->first();
        \App\User::create([
            'name'                  => 'Com: '.$faker->name,
            'username'              => 'comercial',
            'email'                 => 'comercial@user.com',
            'password'              => Hash::make('123456'),
            'role'                  => $comercial->role_id,
            'establishment'         => 1,
            'status'                => 1,
            'verified'              => 1
        ]);

        $player = \App\UserRole::where('name', 'player')->first();
        \App\User::create([
            'name'                  => $faker->name,
            'username'              => 'corretor',
            'email'                 => 'corretor@user.com',
            'password'              => Hash::make('123456'),
            'role'                  => $player->role_id,
            'establishment'         => 1,
            'status'                => 1,
            'verified'              => 1
        ]);
    }
}

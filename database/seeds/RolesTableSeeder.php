<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = \App\UserRole::where('name', 'admin')->first();
        if (!$admin) {
            \App\UserRole::create([
                'name' => 'admin',
                'label' => 'Admin',
            ]);
        }

        $user = \App\UserRole::where('name', 'user')->first();
        if (!$user) {
            \App\UserRole::create([
                'name' => 'user',
                'label' => 'User',
            ]);
        }
    }
}

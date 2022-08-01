<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adm = \App\UserRole::where('name', 'administrator')->first();
        if (!$adm) {
            \App\UserRole::create([
                'name' => 'administrator',
                'label' => 'Administrador'
            ]);
        }

        $com = \App\UserRole::where('name', 'comercial')->first();
        if (!$com) {
            \App\UserRole::create([
                'name' => 'comercial',
                'label' => 'Comercial'
            ]);
        }

        $cli = \App\UserRole::where('name', 'player')->first();
        if (!$cli) {
            \App\UserRole::create([
                'name' => 'player',
                'label' => 'Corretor'
            ]);
        }
    }
}

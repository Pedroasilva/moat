<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Generator as Faker;

class EstablishmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        // create 1 Establishment
        \App\Establishment::create([
            'name'                  => 'Meest',
            'phonenumber'           => '11999888777',
            'email'                 => 'meest@meest.com.br',
            'slug'                  => 'meest-tecnologia'
        ]);
    }
}
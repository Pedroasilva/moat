<?php

namespace Database\Seeders;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Establishment;
use App\IntegrationToken;

class IntegrationTokenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Establishment::all() as $company) {
            // Finding some Integration Token
            $exists = IntegrationToken::where('company', $company->establishment_id)->exists();
            if (!$exists) {
                IntegrationToken::create([
                    'authenticity_token' => md5(uniqid($company->name, true)),
                    'company' => $company->establishment_id
                ]);
            }
        }
    }
}
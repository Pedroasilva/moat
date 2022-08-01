<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Establishment;
use App\IntegrationToken;

class CreateIntegrationToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $company;
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Establishment $company)
    {
        $this->company = $company;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->createNewToken();
    }

    private function createNewToken()
    {
        // Finding some Integration Token
        $exists = IntegrationToken::where('company', $this->company->establishment_id)->exists();
        if (!$exists) {
            IntegrationToken::create([
                'authenticity_token' => md5(uniqid($this->company->name, true)),
                'company' => $this->company->establishment_id
            ]);
        }
    }
}